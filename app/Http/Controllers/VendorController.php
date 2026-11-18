<?php
namespace App\Http\Controllers;
use App\Models\{Food, Category, Order, User};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class VendorController extends Controller {
    private function v() { $v = auth()->user()->vendor; abort_unless($v, 403, 'No restaurant is linked to this account. Ask an administrator.'); return $v; }
    private function own(Food $f) { abort_unless($f->vendor_id === $this->v()->id, 403); }
    public function dashboard() {
        $v = $this->v();
        return view('vendor.dashboard', ['v' => $v, 'total' => $v->orders()->count(), 'pending' => $v->orders()->where('status', 'pending')->count(),
            'done' => $v->orders()->where('status', 'delivered')->count(), 'items' => $v->foods()->where('available', true)->count(),
            'recent' => $v->orders()->with('student', 'hostel')->latest()->take(5)->get()]);
    }
    public function foods() { return view('vendor.foods', ['foods' => $this->v()->foods()->with('category')->get()]); }
    public function foodForm(?Food $food = null) { return view('vendor.food_form', ['food' => $food ?? new Food, 'cats' => Category::all()]); }
    public function foodSave(Request $r, ?Food $food = null) {
        $d = $r->validate(['name' => 'required|max:100', 'category_id' => 'required|exists:categories,id', 'price' => 'required|integer|min:500', 'description' => 'nullable|max:300', 'image' => 'nullable|image|max:3072']);
        $d['available'] = $r->boolean('available');
        if ($r->hasFile('image')) { $n = Str::random(12).'.'.$r->file('image')->extension(); $r->file('image')->move(public_path('uploads'), $n); $d['image'] = 'uploads/'.$n; }
        if ($food) { $this->own($food); $food->update($d); } else $this->v()->foods()->create($d);
        return redirect()->route('vendor.foods')->with('ok', 'Food saved.');
    }
    public function toggle(Food $food) { $this->own($food); $food->update(['available' => !$food->available]); return back(); }
    public function foodDelete(Food $food) { $this->own($food); $food->delete(); return back()->with('ok', 'Food deleted.'); }
    public function categories() { return view('vendor.categories', ['cats' => Category::withCount('foods')->get()]); }
    public function categorySave(Request $r) { $d = $r->validate(['name' => 'required|max:50']); Category::firstOrCreate(['slug' => Str::slug($d['name'])], $d); return back()->with('ok', 'Category saved.'); }
    public function orders(Request $r) {
        $q = $this->v()->orders()->with('student', 'hostel')->latest(); if ($r->status) $q->where('status', $r->status);
        return view('vendor.orders', ['orders' => $q->get()]);
    }
    private function mine(Order $o) { abort_unless($o->vendor_id === $this->v()->id, 403); }
    public function status(Request $r, Order $order) {
        $this->mine($order); abort_unless($this->v()->status === 'approved', 403);
        $to = $r->validate(['to' => 'required'])['to'];
        abort_unless(in_array($to, Order::FLOW[$order->status] ?? []), 422, 'Invalid status change.');
        $order->update(['status' => $to]); $order->log($to, auth()->id());
        User::notify_user($order->student_id, "Order {$order->code} is now ".str_replace('_', ' ', $to).'.');
        return back()->with('ok', 'Status updated.');
    }
    public function paid(Order $order) { $this->mine($order); $order->update(['payment_status' => 'paid']); return back()->with('ok', 'Marked as paid.'); }
    public function restaurant() { return view('vendor.restaurant', ['v' => $this->v()]); }
    public function restaurantSave(Request $r) {
        $d = $r->validate(['name' => 'required|max:100', 'description' => 'nullable|max:400', 'location' => 'required|max:150', 'phone' => 'required|max:20', 'hours' => 'required|max:60', 'service_areas' => 'nullable|max:200', 'image' => 'nullable|image|max:3072']);
        if ($r->hasFile('image')) { $n = Str::random(12).'.'.$r->file('image')->extension(); $r->file('image')->move(public_path('uploads'), $n); $d['image'] = 'uploads/'.$n; }
        $this->v()->update($d); return back()->with('ok', 'Restaurant updated.');
    }
}
