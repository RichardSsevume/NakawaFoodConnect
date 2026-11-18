@extends('layouts.dash')
@section('body')
<h2>Food Categories</h2><form method="POST" action="{{ route('admin.categories.store') }}" class="search">@csrf<input name="name" placeholder="New category" required><button class="btn">Add</button></form>
<div class="card tw"><table class="table">@foreach($cats as $c)<tr><td>{{ $c->name }}</td><td>{{ $c->foods_count }} items</td><td><form method="POST" action="{{ route('admin.categories.delete', $c) }}">@csrf @method('DELETE')<button class="linkbtn">Delete</button></form></td></tr>@endforeach</table></div>
@endsection
