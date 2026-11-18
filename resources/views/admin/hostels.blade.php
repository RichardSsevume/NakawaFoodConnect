@extends('layouts.dash')
@section('body')
<h2>Manage Hostels &amp; Delivery Points</h2>
<form method="POST" action="{{ route('admin.hostels.store') }}" class="card pad form row2">@csrf<input name="name" placeholder="Hostel name" required><input name="delivery_point" placeholder="Delivery point" value="Main gate / reception" required><input name="landmark" placeholder="Landmark"><button class="btn">Add hostel</button></form>
<div class="card tw"><table class="table"><tr><th>Hostel</th><th>Delivery point</th><th>Landmark</th><th>Status</th><th></th></tr>@foreach($hostels as $h)<tr><td>{{ $h->name }}</td><td>{{ $h->delivery_point }}</td><td>{{ $h->landmark }}</td><td>@include('partials.status', ['s' => $h->status])</td>
<td>@foreach(['verified' => 'Verify', 'suspended' => 'Suspend'] as $k => $l)@if($h->status !== $k)<form method="POST" action="{{ route('admin.hostels.status', $h) }}" class="inl">@csrf<input type="hidden" name="status" value="{{ $k }}"><button class="btn sm ghost">{{ $l }}</button></form>@endif @endforeach
<form method="POST" action="{{ route('admin.hostels.delete', $h) }}" class="inl">@csrf @method('DELETE')<button class="linkbtn">Delete</button></form></td></tr>@endforeach</table></div>
@endsection
