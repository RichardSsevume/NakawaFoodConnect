@extends('layouts.app')
@section('title', $vendor->name)
@section('content')
<div class="wrap sec"><div class="card rdetail"><img src="{{ asset($vendor->image) }}" alt=""><div class="pad"><h2>{{ $vendor->name }}</h2><p>{{ $vendor->description }}</p>
<p><b>Location:</b> {{ $vendor->location }}<br><b>Hours:</b> {{ $vendor->hours }}<br><b>Service areas:</b> {{ $vendor->service_areas ?: '—' }}<br><b>Phone:</b> {{ $vendor->phone }}</p></div></div>
<h2>Menu</h2><div class="grid g4">@foreach($foods as $f)@php $f->setRelation('vendor', $vendor); @endphp @if($f->available)@include('partials.food')@endif @endforeach</div></div>
@endsection
