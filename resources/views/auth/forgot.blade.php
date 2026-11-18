@extends('layouts.app')
@section('title', 'Forgot Password')
@section('content')
<div class="wrap narrow sec"><h2>Forgot Password</h2><form method="POST" action="{{ route('password.email') }}" class="card pad form">@csrf<label>Email<input type="email" name="email" required></label><button class="btn">Send reset link</button></form></div>
@endsection
