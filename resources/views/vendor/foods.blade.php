@extends('layouts.dash')
@section('body')
<h2>Manage Food <a class="btn sm" href="{{ route('vendor.foods.create') }}">+ Add new food</a></h2>
<div class="card tw"><table class="table"><tr><th></th><th>Name</th><th>Category</th><th>Price</th><th>Available</th><th></th></tr>@foreach($foods as $f)<tr><td><img class="thumb" src="{{ asset($f->image) }}" alt=""></td><td>{{ $f->name }}</td><td>{{ $f->category->name }}</td><td>{{ number_format($f->price) }}</td>
<td><form method="POST" action="{{ route('vendor.foods.toggle', $f) }}">@csrf<button class="chip {{ $f->available ? 'on' : '' }}">{{ $f->available ? 'Yes' : 'No' }}</button></form></td>
<td><a href="{{ route('vendor.foods.edit', $f) }}">Edit</a><form method="POST" action="{{ route('vendor.foods.delete', $f) }}" class="inl" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="linkbtn">Delete</button></form></td></tr>@endforeach</table></div>
@endsection
