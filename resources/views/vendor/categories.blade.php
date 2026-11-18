@extends('layouts.dash')
@section('body')
<h2>Categories</h2><form method="POST" action="{{ route('vendor.categories.store') }}" class="search">@csrf<input name="name" placeholder="New category" required><button class="btn">Add</button></form>
<div class="chips">@foreach($cats as $c)<span class="chip">{{ $c->name }} ({{ $c->foods_count }})</span>@endforeach</div>
@endsection
