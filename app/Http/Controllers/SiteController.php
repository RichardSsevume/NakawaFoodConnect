<?php
namespace App\Http\Controllers;
use App\Models\{Food, Vendor, Category, Hostel, ContactMessage};
use Illuminate\Http\Request;
class SiteController extends Controller {
    public function home() {
        return view('home', [
            'vendors' => Vendor::where('status', 'approved')->take(7)->get(),
            'foods' => Food::with('vendor')->where('available', true)->inRandomOrder()->take(8)->get(),
            'cats' => Category::all(), 'hostels' => Hostel::where('status', 'verified')->get(),
        ]);
    }
    public function about() { return view('about'); }
    public function how() { return view('how'); }
    public function explore(Request $r) {
        $q = Food::with(['vendor', 'category'])->where('available', true)->whereHas('vendor', fn($v) => $v->where('status', 'approved'));
        if ($r->cat) $q->whereHas('category', fn($c) => $c->where('slug', $r->cat));
        if ($r->q) $q->where('name', 'like', '%'.$r->q.'%');
        return view('explore', ['foods' => $q->get(), 'cats' => Category::all(), 'title' => 'Explore Food']);
    }
    public function restaurants() { return view('restaurants', ['vendors' => Vendor::where('status', 'approved')->withCount('foods')->get()]); }
    public function restaurant(Vendor $vendor) { abort_unless($vendor->status === 'approved', 404); return view('restaurant', ['vendor' => $vendor, 'foods' => $vendor->foods()->with('category')->get()]); }
    public function contact() { return view('contact'); }
    public function send(Request $r) {
        ContactMessage::create($r->validate(['name' => 'required', 'email' => 'required|email', 'message' => 'required|min:5']));
        return back()->with('ok', 'Thank you! Your message has been received.');
    }
}
