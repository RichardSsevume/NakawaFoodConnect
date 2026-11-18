@extends('layouts.dash')
@section('body')
<h2>Shopping Cart</h2>@if($lines->isEmpty())<p>Your cart is empty. <a href="{{ route('explore') }}">Browse food</a></p>@else
<form method="POST" action="{{ route('student.cart.update') }}" class="card tw">@csrf<table class="table"><tr><th></th><th>Item</th><th>Price</th><th>Qty</th><th>Total</th><th></th></tr>
@foreach($lines as $l)<tr><td><img class="thumb" src="{{ asset($l->food->image) }}" alt=""></td><td>{{ $l->food->name }}<br><small>{{ $l->food->vendor->name }}</small></td><td>{{ number_format($l->food->price) }}</td><td><input class="qty" type="number" min="0" max="20" name="qty[{{ $l->food->id }}]" value="{{ $l->qty }}"></td><td>{{ number_format($l->sum) }}</td><td><a href="{{ route('student.cart.remove', $l->food) }}">Remove</a></td></tr>@endforeach
<tr><th colspan="4">Subtotal (UGX)</th><th colspan="2">{{ number_format($subtotal) }}</th></tr></table><div class="pad"><button class="btn ghost">Update quantities</button> <a class="btn" href="{{ route('student.checkout') }}">Checkout</a></div></form>@endif
@endsection
