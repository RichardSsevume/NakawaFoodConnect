@extends('layouts.dash')
@section('body')
<h2>Checkout</h2>
<form method="POST" action="{{ route('student.checkout.place') }}" class="card pad form">@csrf
<p><b>{{ auth()->user()->name }}</b> · {{ auth()->user()->phone }}</p>
<label>Verified hostel<select name="hostel_id" required><option value="">Select hostel…</option>@foreach($hostels as $h)<option value="{{ $h->id }}">{{ $h->name }} — {{ $h->delivery_point }}</option>@endforeach</select></label>
<label>Delivery instructions / landmark<input name="delivery_note" maxlength="200" placeholder="e.g. Block B, call on arrival (no room numbers needed)"></label>
<label>Payment<select name="payment_method" id="pm"><option value="cash">Cash on delivery</option><option value="mtn_momo">MTN Mobile Money</option><option value="airtel_money">Airtel Money</option></select></label>
<div id="momo" hidden><p class="flash ok">Send the total to the vendor's Mobile Money number: @foreach($lines->pluck('food.vendor')->unique('id') as $v)<b>{{ $v->name }}: {{ $v->phone }}</b> @endforeach</p><label>Transaction reference<input name="payment_ref" maxlength="60"></label></div>
<h3>Order summary</h3><table class="table">@foreach($lines as $l)<tr><td>{{ $l->food->name }} × {{ $l->qty }}</td><td>{{ number_format($l->sum) }}</td></tr>@endforeach
<tr><td>Delivery fee</td><td>{{ number_format($fee) }}</td></tr><tr><th>Total (UGX)</th><th>{{ number_format($subtotal + $fee) }}</th></tr></table><button class="btn">Confirm order</button></form>
@endsection
