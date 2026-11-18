@extends('layouts.dash')
@section('body')
@php $g = fn($k, $d = '') => \App\Models\Setting::get($k, $d); @endphp
<h2>System Settings</h2><form method="POST" action="{{ route('admin.settings.save') }}" class="card pad form">@csrf @method('PUT')
<label>Website name<input name="site_name" value="{{ $g('site_name') }}" required></label><label>Delivery fee per order (UGX)<input type="number" name="delivery_fee" value="{{ $g('delivery_fee', 2000) }}" required></label>
<label>Service radius (km)<input name="service_radius" value="{{ $g('service_radius', 2) }}" required></label><label>Contact phone<input name="contact_phone" value="{{ $g('contact_phone') }}"></label><label>Contact email<input name="contact_email" value="{{ $g('contact_email') }}"></label><button class="btn">Save</button></form>
@endsection
