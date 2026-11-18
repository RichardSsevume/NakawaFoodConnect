@extends('layouts.dash')
@section('body')
<h2>Manage Restaurant</h2><form method="POST" enctype="multipart/form-data" action="{{ route('vendor.restaurant.update') }}" class="card pad form">@csrf @method('PUT')
<label>Name<input name="name" value="{{ $v->name }}" required></label><label>Description<textarea name="description">{{ $v->description }}</textarea></label><label>Location<input name="location" value="{{ $v->location }}" required></label>
<label>Phone / MoMo number<input name="phone" value="{{ $v->phone }}" required></label><label>Operating hours<input name="hours" value="{{ $v->hours }}" required></label><label>Service areas<input name="service_areas" value="{{ $v->service_areas }}"></label>
<label>Photo<input type="file" name="image" accept="image/*"></label><button class="btn">Save</button></form>
@endsection
