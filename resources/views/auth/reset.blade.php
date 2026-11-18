@extends('layouts.app')
@section('title', 'Reset Password')
@section('content')
<div class="wrap narrow sec"><h2>Reset Password</h2><form method="POST" action="{{ route('password.update') }}" class="card pad form">@csrf<input type="hidden" name="token" value="{{ $token }}">
<label>Email<input type="email" name="email" value="{{ $email }}" required></label><label>New password<input type="password" name="password" required></label><label>Confirm<input type="password" name="password_confirmation" required></label><button class="btn">Reset</button></form></div>
@endsection
