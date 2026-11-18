@extends('layouts.dash')
@section('body')
<h2>{{ $v->name }}</h2>
@if($v->status !== 'approved')<div class="flash err">Your restaurant is <b>{{ $v->status }}</b>. It is hidden from students until an administrator approves it.</div>@endif
<div class="grid g4 stats"><div class="card pad"><small>Total orders</small><b>{{ $total }}</b></div><div class="card pad"><small>Pending</small><b>{{ $pending }}</b></div><div class="card pad"><small>Completed</small><b>{{ $done }}</b></div><div class="card pad"><small>Available items</small><b>{{ $items }}</b></div></div>
<h3>Recent orders</h3>@include('vendor._orders', ['orders' => $recent])
@endsection
