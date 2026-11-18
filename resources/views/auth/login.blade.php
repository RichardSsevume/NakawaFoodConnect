@extends('layouts.app')
@section('title', 'Login')
@section('content')
<div class="wrap narrow sec"><h2>Login</h2><form method="POST" action="{{ route('login.post') }}" class="card pad form">@csrf
<label>Email<input type="email" name="email" value="{{ old('email') }}" required></label><label>Password<input type="password" name="password" required></label>
<label class="inl"><input type="checkbox" name="remember"> Remember me</label><button class="btn">Login</button>
<p><a href="{{ route('password.request') }}">Forgot password?</a> · <a href="{{ route('register.student') }}">Student sign up</a> · <a href="{{ route('register.vendor') }}">Vendor sign up</a></p></form></div>
@endsection
