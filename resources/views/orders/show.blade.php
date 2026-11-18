@extends('layouts.dash')
@section('body')
<h2>Order {{ $order->code }} @include('partials.status', ['s' => $order->status])</h2>
<div class="card pad"><p><b>Restaurant:</b> {{ $order->vendor->name }} · <b>Student:</b> {{ $order->student->name }} ({{ $order->student->phone }})<br>
<b>Deliver to:</b> {{ $order->hostel->name }} – {{ $order->hostel->delivery_point }} @if($order->delivery_note)· <i>{{ $order->delivery_note }}</i>@endif<br>
<b>Payment:</b> {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} {{ $order->payment_ref ? '(Ref: '.$order->payment_ref.')' : '' }} · {{ ucfirst($order->payment_status) }}</p>
<table class="table"><tr><th>Item</th><th>Price</th><th>Qty</th><th>Total</th></tr>@foreach($order->items as $i)<tr><td>{{ $i->name }}</td><td>{{ number_format($i->price) }}</td><td>{{ $i->qty }}</td><td>{{ number_format($i->price * $i->qty) }}</td></tr>@endforeach
<tr><td colspan="3">Subtotal</td><td>{{ number_format($order->subtotal) }}</td></tr><tr><td colspan="3">Delivery</td><td>{{ number_format($order->delivery_fee) }}</td></tr><tr><th colspan="3">Total (UGX)</th><th>{{ number_format($order->total) }}</th></tr></table></div>
<h3>Status history</h3><div class="card pad">@foreach($order->history as $h)<div>{{ ucwords(str_replace('_', ' ', $h->status)) }} — {{ $h->created_at->format('d M Y H:i') }} @if($h->user)<small>by {{ $h->user->name }}</small>@endif</div>@endforeach</div>
@endsection
