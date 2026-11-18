@extends('layouts.app')
@section('title', 'How It Works')
@section('content')
<div class="wrap sec"><h2>How It Works</h2><div class="grid g3">
<div class="card step"><img src="{{ asset('images/25.jpeg') }}" alt=""><h3>Students</h3><p>Register, browse food, fill your cart, pick a verified hostel and submit. Track status until delivered.</p></div>
<div class="card step"><img src="{{ asset('images/2.3.jpeg') }}" alt=""><h3>Vendors</h3><p>Register, get approved, manage menu and availability, accept or reject orders and update status.</p></div>
<div class="card step"><img src="{{ asset('images/26.jpeg') }}" alt=""><h3>Payment</h3><p>Choose Cash on Delivery, MTN MoMo or Airtel Money. The vendor confirms payment received.</p></div></div>
<p class="lead">An order stays <b>Pending</b> until the vendor accepts it, then moves Preparing → Ready → Out for Delivery → Delivered.</p></div>
@endsection
