@extends('layouts.app')
@section('title', ucfirst($type).' Registration')
@section('content')
<div class="wrap narrow sec"><h2>{{ ucfirst($type) }} Registration</h2><form method="POST" action="{{ route('register.'.$type) }}" class="card pad form">@csrf
<label>Full name<input name="name" value="{{ old('name') }}" required></label><label>Email<input type="email" name="email" value="{{ old('email') }}" required></label>
<label>Phone<input name="phone" value="{{ old('phone') }}" required></label>
@if($type === 'vendor')<label>Restaurant name<input name="restaurant" value="{{ old('restaurant') }}" required></label><label>Location<input name="location" value="{{ old('location') }}" required></label>@endif
<label>Password (min 8)<input type="password" name="password" required></label><label>Confirm password<input type="password" name="password_confirmation" required></label>
<button class="btn">Create account</button>@if($type === 'vendor')<small>Vendor accounts must be approved by an administrator before going live.</small>@endif</form></div>
@endsection
