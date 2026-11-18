@extends('layouts.app')
@section('title', 'Explore Food')
@section('content')
<div class="wrap sec"><h2>Explore Food</h2>
<form class="search" method="GET"><input name="q" value="{{ request('q') }}" placeholder="Search food…">@if(request('cat'))<input type="hidden" name="cat" value="{{ request('cat') }}">@endif<button class="btn">Search</button></form>
<div class="chips"><a class="chip {{ request('cat') ? '' : 'on' }}" href="{{ route('explore') }}">All Food</a>@foreach($cats as $c)<a class="chip {{ request('cat') == $c->slug ? 'on' : '' }}" href="{{ route('explore', ['cat' => $c->slug]) }}">{{ $c->name }}</a>@endforeach</div>
<div class="grid g4">@forelse($foods as $f)@include('partials.food')@empty<p>No food found.</p>@endforelse</div></div>
@endsection
