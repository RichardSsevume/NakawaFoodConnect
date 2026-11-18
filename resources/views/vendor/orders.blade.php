@extends('layouts.dash')
@section('body')
<h2>Manage Orders</h2><div class="chips"><a class="chip" href="{{ route('vendor.orders') }}">All</a>@foreach(['pending', 'accepted', 'preparing', 'ready', 'out_for_delivery', 'delivered', 'rejected', 'cancelled'] as $s)<a class="chip {{ request('status') == $s ? 'on' : '' }}" href="?status={{ $s }}">{{ ucwords(str_replace('_', ' ', $s)) }}</a>@endforeach</div>
@include('vendor._orders')
@endsection
