<?php
namespace App\Http\Controllers;
use App\Models\{User, Vendor};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Password, Hash};
use Illuminate\Support\Str;
class AuthController extends Controller {
    public function loginForm() { return view('auth.login'); }
    public function login(Request $r) {
        $c = $r->validate(['email' => 'required|email', 'password' => 'required']);
        if (Auth::attempt($c + ['status' => 'active'], $r->boolean('remember'))) {
            $r->session()->regenerate();
            return redirect()->intended(route(Auth::user()->role.'.dashboard'));
        }
        return back()->withErrors(['email' => 'Invalid credentials, or the account is suspended.'])->onlyInput('email');
    }
    public function logout(Request $r) { Auth::logout(); $r->session()->invalidate(); $r->session()->regenerateToken(); return redirect()->route('home'); }
    public function studentForm() { return view('auth.register', ['type' => 'student']); }
    public function vendorForm() { return view('auth.register', ['type' => 'vendor']); }
    private function base(Request $r, array $extra = []) {
        return $r->validate(['name' => 'required|max:100', 'email' => 'required|email|unique:users', 'phone' => 'required|max:20', 'password' => 'required|min:8|confirmed'] + $extra);
    }
    public function student(Request $r) {
        $d = $this->base($r);
        Auth::login(User::create($d + ['role' => 'student']));
        return redirect()->route('student.dashboard');
    }
    public function vendor(Request $r) {
        $d = $this->base($r, ['restaurant' => 'required|max:100', 'location' => 'required|max:150']);
        $u = User::create(collect($d)->only(['name', 'email', 'phone', 'password'])->all() + ['role' => 'vendor']);
        Vendor::create(['user_id' => $u->id, 'name' => $d['restaurant'], 'slug' => Str::slug($d['restaurant']).'-'.Str::random(4), 'location' => $d['location'], 'phone' => $d['phone'], 'status' => 'pending']);
        foreach (User::where('role', 'admin')->get() as $a) User::notify_user($a->id, "New vendor awaiting approval: {$d['restaurant']}");
        Auth::login($u);
        return redirect()->route('vendor.dashboard');
    }
    public function forgotForm() { return view('auth.forgot'); }
    public function forgot(Request $r) {
        $r->validate(['email' => 'required|email']);
        Password::sendResetLink($r->only('email'));
        return back()->with('ok', 'If that email exists, a reset link has been sent.');
    }
    public function resetForm($token, Request $r) { return view('auth.reset', ['token' => $token, 'email' => $r->email]); }
    public function reset(Request $r) {
        $r->validate(['token' => 'required', 'email' => 'required|email', 'password' => 'required|min:8|confirmed']);
        $s = Password::reset($r->only('email', 'password', 'password_confirmation', 'token'), function ($u, $p) { $u->forceFill(['password' => $p, 'remember_token' => Str::random(60)])->save(); });
        return $s === Password::PASSWORD_RESET ? redirect()->route('login')->with('ok', 'Password reset. Please log in.') : back()->withErrors(['email' => __($s)]);
    }
}
