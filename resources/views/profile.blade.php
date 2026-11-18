@extends('layouts.dash')
@section('body')
<h2>My Profile</h2><form method="POST" action="{{ route('profile.update') }}" class="card pad form">@csrf @method('PUT')
<label>Name<input name="name" value="{{ auth()->user()->name }}" required></label><label>Email<input name="email" value="{{ auth()->user()->email }}" required></label><label>Phone<input name="phone" value="{{ auth()->user()->phone }}" required></label><button class="btn">Save</button></form>
<h2>Change Password</h2><form method="POST" action="{{ route('profile.password') }}" class="card pad form">@csrf @method('PUT')
<label>Current<input type="password" name="current" required></label><label>New<input type="password" name="password" required></label><label>Confirm<input type="password" name="password_confirmation" required></label><button class="btn">Change</button></form>
@endsection
