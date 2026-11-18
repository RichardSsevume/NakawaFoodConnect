<?php
namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class SharedController extends Controller {
    public function profile() { return view('profile'); }
    public function update(Request $r) {
        $d = $r->validate(['name' => 'required|max:100', 'phone' => 'required|max:20', 'email' => 'required|email|unique:users,email,'.auth()->id()]);
        auth()->user()->update($d); return back()->with('ok', 'Profile updated.');
    }
    public function password(Request $r) {
        $r->validate(['current' => 'required', 'password' => 'required|min:8|confirmed']);
        if (!Hash::check($r->current, auth()->user()->password)) return back()->withErrors(['current' => 'Current password is wrong.']);
        auth()->user()->update(['password' => $r->password]); return back()->with('ok', 'Password changed.');
    }
    public function notices() {
        $n = auth()->user()->notices()->latest()->get(); $html = view('notices', ['notices' => $n]); auth()->user()->notices()->update(['seen' => true]); return $html;
    }
    public function order(Order $order) {
        $u = auth()->user();
        abort_unless($u->role === 'admin' || $order->student_id === $u->id || optional($u->vendor)->id === $order->vendor_id, 403);
        return view('orders.show', ['order' => $order->load(['items', 'vendor', 'hostel', 'student', 'history.user'])]);
    }
}
