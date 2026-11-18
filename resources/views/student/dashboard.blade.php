@extends('layouts.dash')
@section('body')
<h2>Welcome, {{ auth()->user()->name }} 👋</h2>
<div class="grid g3 stats"><div class="card pad"><small>Total orders</small><b>{{ $total }}</b></div><div class="card pad"><small>Active orders</small><b>{{ $pending }}</b></div><div class="card pad"><small>Spent (UGX)</small><b>{{ number_format($spent) }}</b></div></div>
<h3>Recent orders</h3>@include('student._orders', ['orders' => $recent])
<h3>Recommended meals</h3><div class="grid g4">@foreach($recommended as $f)@include('partials.food')@endforeach</div>
@endsection
