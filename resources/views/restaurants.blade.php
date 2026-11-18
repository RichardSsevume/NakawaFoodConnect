@extends('layouts.app')
@section('title', 'Restaurants')
@section('content')
<div class="wrap sec"><h2>Restaurants &amp; Vendors</h2><div class="grid g4">@foreach($vendors as $v)
<a class="card rest" href="{{ route('restaurant.show', $v) }}"><img src="{{ asset($v->image) }}" alt="{{ $v->name }}" loading="lazy"><div class="fb"><h3>{{ $v->name }}</h3><small>{{ $v->foods_count }} meals · {{ $v->hours }}</small></div></a>@endforeach</div>
<h2>Menu boards</h2><div class="grid g4"><img class="card" src="{{ asset('images/menu_1.jpeg') }}" alt=""><img class="card" src="{{ asset('images/menu_2.jpeg') }}" alt=""><img class="card" src="{{ asset('images/menu_4.jpeg') }}" alt=""></div></div>
@endsection
