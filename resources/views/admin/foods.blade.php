@extends('layouts.dash')
@section('body')
<h2>Manage Food</h2><div class="card tw"><table class="table"><tr><th></th><th>Name</th><th>Vendor</th><th>Category</th><th>Price</th><th>Available</th><th></th></tr>@foreach($foods as $f)<tr><td><img class="thumb" src="{{ asset($f->image) }}" alt=""></td><td>{{ $f->name }}</td><td>{{ $f->vendor->name }}</td><td>{{ $f->category->name }}</td><td>{{ number_format($f->price) }}</td>
<td><form method="POST" action="{{ route('admin.foods.toggle', $f) }}">@csrf<button class="chip {{ $f->available ? 'on' : '' }}">{{ $f->available ? 'Yes' : 'No' }}</button></form></td>
<td><form method="POST" action="{{ route('admin.foods.delete', $f) }}" onsubmit="return confirm('Remove?')">@csrf @method('DELETE')<button class="linkbtn">Remove</button></form></td></tr>@endforeach</table></div>
@endsection
