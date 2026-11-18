@extends('layouts.dash')
@section('body')
<h2>{{ $food->exists ? 'Edit' : 'Add' }} Food</h2>
<form method="POST" enctype="multipart/form-data" action="{{ $food->exists ? route('vendor.foods.update', $food) : route('vendor.foods.store') }}" class="card pad form">@csrf @if($food->exists)@method('PUT')@endif
<label>Name<input name="name" value="{{ old('name', $food->name) }}" required></label>
<label>Category<select name="category_id">@foreach($cats as $c)<option value="{{ $c->id }}" @selected(old('category_id', $food->category_id) == $c->id)>{{ $c->name }}</option>@endforeach</select></label>
<label>Price (UGX)<input type="number" name="price" value="{{ old('price', $food->price) }}" required></label>
<label>Description<textarea name="description">{{ old('description', $food->description) }}</textarea></label>
<label>Image<input type="file" name="image" accept="image/*"></label>
<label class="inl"><input type="checkbox" name="available" value="1" @checked(old('available', $food->exists ? $food->available : true))> Available</label><button class="btn">Save</button></form>
@endsection
