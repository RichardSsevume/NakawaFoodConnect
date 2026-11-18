@extends('layouts.dash')
@section('body')
<h2>All Orders</h2><div class="chips"><a class="chip" href="{{ route('admin.orders') }}">All</a>@foreach(['pending', 'accepted', 'preparing', 'ready', 'out_for_delivery', 'delivered', 'rejected', 'cancelled'] as $s)<a class="chip {{ request('status') == $s ? 'on' : '' }}" href="?status={{ $s }}">{{ ucwords(str_replace('_', ' ', $s)) }}</a>@endforeach</div>
<div class="card tw"><table class="table"><tr><th>Code</th><th>Restaurant</th><th>Student</th><th>Hostel</th><th>Total</th><th>Status</th></tr>@foreach($orders as $o)<tr><td><a href="{{ route('order.show', $o) }}">{{ $o->code }}</a></td><td>{{ $o->vendor->name }}</td><td>{{ $o->student->name }}</td><td>{{ $o->hostel->name }}</td><td>{{ number_format($o->total) }}</td><td>@include('partials.status', ['s' => $o->status])</td></tr>@endforeach</table></div>
@endsection
