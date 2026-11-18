<?php
namespace App\Http\Controllers;
use App\Models\{Food, Hostel, Order, Setting, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class StudentController extends Controller {
    public function dashboard() {
        $o = auth()->user()->orders();
        return view('student.dashboard', ['total' => (clone $o)->count(), 'pending' => (clone $o)->whereIn('status', ['pending', 'accepted', 'preparing', 'ready', 'out_for_delivery'])->count(),
            'spent' => (clone $o)->where('status', 'delivered')->sum('total'), 'recent' => (clone $o)->with('vendor')->latest()->take(5)->get(),
            'recommended' => Food::with('vendor')->where('available', true)->inRandomOrder()->take(4)->get()]);
    }
    private function lines() {
        $cart = session('cart', []); $foods = Food::with('vendor')->whereIn('id', array_keys($cart))->get();
        return $foods->map(fn($f) => (object)['food' => $f, 'qty' => $cart[$f->id], 'sum' => $f->price * $cart[$f->id]]);
    }
    public function cart() { $l = $this->lines(); return view('student.cart', ['lines' => $l, 'subtotal' => $l->sum('sum')]); }
    public function add(Food $food, Request $r) {
        abort_unless($food->available && $food->vendor->status === 'approved', 404);
        $c = session('cart', []); $c[$food->id] = min(20, ($c[$food->id] ?? 0) + max(1, (int)$r->qty)); session(['cart' => $c]);
        return back()->with('ok', "{$food->name} added to cart.");
    }
    public function updateCart(Request $r) {
        $c = []; foreach ((array)$r->qty as $id => $q) if ((int)$q > 0) $c[$id] = min(20, (int)$q);
        session(['cart' => $c]); return back()->with('ok', 'Cart updated.');
    }
    public function remove($id) { $c = session('cart', []); unset($c[$id]); session(['cart' => $c]); return back(); }
    public function checkout() {
        $l = $this->lines(); if ($l->isEmpty()) return redirect()->route('student.cart');
        return view('student.checkout', ['lines' => $l, 'subtotal' => $l->sum('sum'), 'fee' => (int)Setting::get('delivery_fee', 2000) * $l->groupBy('food.vendor_id')->count(),
            'hostels' => Hostel::where('status', 'verified')->orderBy('name')->get()]);
    }
    public function place(Request $r) {
        $d = $r->validate(['hostel_id' => 'required|exists:hostels,id', 'delivery_note' => 'nullable|max:200', 'payment_method' => 'required|in:cash,mtn_momo,airtel_money', 'payment_ref' => 'nullable|max:60']);
        abort_unless(Hostel::where('id', $d['hostel_id'])->where('status', 'verified')->exists(), 422, 'Hostel not verified.');
        $lines = $this->lines(); if ($lines->isEmpty()) return redirect()->route('student.cart');
        $fee = (int)Setting::get('delivery_fee', 2000);
        DB::transaction(function () use ($lines, $d, $fee) {
            foreach ($lines->groupBy('food.vendor_id') as $vid => $set) {
                $sub = $set->sum('sum');
                $o = Order::create(['code' => 'NFC-'.strtoupper(Str::random(6)), 'student_id' => auth()->id(), 'vendor_id' => $vid, 'hostel_id' => $d['hostel_id'],
                    'delivery_note' => $d['delivery_note'] ?? null, 'payment_method' => $d['payment_method'], 'payment_ref' => $d['payment_ref'] ?? null,
                    'subtotal' => $sub, 'delivery_fee' => $fee, 'total' => $sub + $fee]);
                foreach ($set as $l) $o->items()->create(['food_id' => $l->food->id, 'name' => $l->food->name, 'price' => $l->food->price, 'qty' => $l->qty]);
                $o->log('pending', auth()->id());
                User::notify_user($set->first()->food->vendor->user_id, "New order {$o->code} from ".auth()->user()->name);
            }
        });
        session()->forget('cart');
        return redirect()->route('student.orders')->with('ok', 'Order submitted! It stays Pending until the vendor accepts it.');
    }
    public function orders(Request $r) {
        $q = auth()->user()->orders()->with('vendor')->latest(); if ($r->status) $q->where('status', $r->status);
        return view('student.orders', ['orders' => $q->get()]);
    }
    public function cancel(Order $order) {
        abort_unless($order->student_id === auth()->id() && $order->status === 'pending', 403);
        $order->update(['status' => 'cancelled']); $order->log('cancelled', auth()->id()); return back()->with('ok', 'Order cancelled.');
    }
}
