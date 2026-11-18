<?php
namespace App\Http\Controllers;
use App\Models\{User, Vendor, Food, Category, Hostel, Order, Setting, ContactMessage};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class AdminController extends Controller {
    public function dashboard() {
        return view('admin.dashboard', ['s' => ['Students' => User::where('role', 'student')->count(), 'Vendors' => Vendor::count(), 'Food items' => Food::count(), 'Orders' => Order::count(),
            'Pending orders' => Order::where('status', 'pending')->count(), 'Completed orders' => Order::where('status', 'delivered')->count(), 'Pending vendors' => Vendor::where('status', 'pending')->count(), 'Hostels' => Hostel::count()],
            'recent' => Order::with('vendor', 'student')->latest()->take(6)->get(), 'messages' => ContactMessage::latest()->take(5)->get()]);
    }
    public function students() { return view('admin.students', ['users' => User::where('role', 'student')->withCount('orders')->latest()->get()]); }
    public function vendors() { return view('admin.vendors', ['vendors' => Vendor::with('user')->withCount('foods', 'orders')->latest()->get()]); }
    public function userStatus(User $user) { abort_if($user->id === auth()->id(), 403); $user->update(['status' => $user->status === 'active' ? 'suspended' : 'active']); return back()->with('ok', 'Account updated.'); }
    public function vendorStatus(Request $r, Vendor $vendor) {
        $s = $r->validate(['status' => 'required|in:approved,rejected,suspended'])['status']; $vendor->update(['status' => $s]);
        User::notify_user($vendor->user_id, "Your restaurant account is now: $s."); return back()->with('ok', "Vendor $s.");
    }
    public function foods() { return view('admin.foods', ['foods' => Food::with('vendor', 'category')->latest()->get()]); }
    public function foodDelete(Food $food) { $food->delete(); return back()->with('ok', 'Food removed.'); }
    public function toggle(Food $food) { $food->update(['available' => !$food->available]); return back(); }
    public function categories() { return view('admin.categories', ['cats' => Category::withCount('foods')->get()]); }
    public function categorySave(Request $r) { $d = $r->validate(['name' => 'required|max:50']); Category::firstOrCreate(['slug' => Str::slug($d['name'])], $d); return back()->with('ok', 'Category saved.'); }
    public function categoryDelete(Category $category) { if ($category->foods()->exists()) return back()->withErrors(['x' => 'Category has food items.']); $category->delete(); return back(); }
    public function hostels() { return view('admin.hostels', ['hostels' => Hostel::orderBy('name')->get()]); }
    public function hostelSave(Request $r) { Hostel::create($r->validate(['name' => 'required|max:100', 'delivery_point' => 'required|max:100', 'landmark' => 'nullable|max:100']) + ['status' => 'verified']); return back()->with('ok', 'Hostel added.'); }
    public function hostelStatus(Request $r, Hostel $hostel) { $hostel->update($r->validate(['status' => 'required|in:verified,pending,suspended'])); return back(); }
    public function hostelDelete(Hostel $hostel) { if (Order::where('hostel_id', $hostel->id)->exists()) return back()->withErrors(['x' => 'Hostel has orders; suspend it instead.']); $hostel->delete(); return back(); }
    public function orders(Request $r) { $q = Order::with('vendor', 'student', 'hostel')->latest(); if ($r->status) $q->where('status', $r->status); return view('admin.orders', ['orders' => $q->get()]); }
    public function users() { return view('admin.users', ['users' => User::latest()->get()]); }
    public function userRole(Request $r, User $user) {
        abort_if($user->id === auth()->id(), 403);
        $role = $r->validate(['role' => 'required|in:student,vendor,admin'])['role'];
        $user->update(['role' => $role]);
        // A vendor account needs a restaurant profile, otherwise the vendor pages cannot load.
        if ($role === 'vendor' && !$user->vendor()->exists()) {
            Vendor::create(['user_id' => $user->id, 'name' => $user->name.' Kitchen', 'slug' => Str::slug($user->name).'-'.Str::lower(Str::random(4)),
                'phone' => $user->phone, 'location' => 'Nakawa, near MUBS', 'status' => 'approved']);
        }
        return back()->with('ok', 'Role updated.');
    }
    public function messages() { return view('admin.messages', ['messages' => ContactMessage::latest()->get()]); }
    public function messageDelete(ContactMessage $message) { $message->delete(); return back()->with('ok', 'Message deleted.'); }
    public function reports() {
        $d = Order::where('status', 'delivered');
        return view('admin.reports', ['sales' => (clone $d)->sum('total'), 'count' => (clone $d)->count(),
            'byVendor' => Vendor::withCount(['orders as delivered' => fn($q) => $q->where('status', 'delivered')])->withSum(['orders as revenue' => fn($q) => $q->where('status', 'delivered')], 'total')->get(),
            'byStatus' => Order::selectRaw('status, count(*) c')->groupBy('status')->pluck('c', 'status'),
            'topFoods' => \App\Models\OrderItem::selectRaw('name, sum(qty) q')->groupBy('name')->orderByDesc('q')->take(8)->get()]);
    }
    public function settings() { return view('admin.settings'); }
    public function settingsSave(Request $r) {
        $d = $r->validate(['site_name' => 'required', 'delivery_fee' => 'required|integer|min:0', 'service_radius' => 'required|numeric|min:0', 'contact_phone' => 'nullable', 'contact_email' => 'nullable|email']);
        foreach ($d as $k => $v) Setting::put($k, $v); return back()->with('ok', 'Settings saved.');
    }
}
