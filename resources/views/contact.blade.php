@extends('layouts.app')
@section('title', 'Contact Us')
@section('content')
<div class="wrap sec grid g2"><div><h2>Contact Us</h2><p>{{ \App\Models\Setting::get('contact_phone') }}<br>{{ \App\Models\Setting::get('contact_email') }}</p>
<form method="POST" action="{{ route('contact.send') }}" class="card pad form">@csrf<label>Name<input name="name" required></label><label>Email<input type="email" name="email" required></label><label>Message<textarea name="message" rows="4" required></textarea></label><button class="btn">Send</button></form></div>
<div><h2>FAQ</h2>
<details class="card pad" open><summary>How do I pay?</summary><p>Cash on delivery, MTN MoMo or Airtel Money (send to the vendor's number and enter the reference).</p></details>
<details class="card pad"><summary>Which hostels are covered?</summary><p>Only verified hostels listed at checkout.</p></details>
<details class="card pad"><summary>Can I cancel?</summary><p>Yes, while the order is still Pending.</p></details>
<details class="card pad"><summary>I own a restaurant. How do I join?</summary><p>Use Vendor sign up; an administrator approves you.</p></details></div></div>
@endsection
