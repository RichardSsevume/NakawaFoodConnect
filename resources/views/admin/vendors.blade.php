@extends('layouts.dash')
@section('body')
<h2>Manage Vendors</h2><div class="card tw"><table class="table"><tr><th>Restaurant</th><th>Owner</th><th>Foods</th><th>Orders</th><th>Status</th><th>Actions</th></tr>@foreach($vendors as $v)<tr><td>{{ $v->name }}</td><td>{{ $v->user->name }}<br><small>{{ $v->user->email }}</small></td><td>{{ $v->foods_count }}</td><td>{{ $v->orders_count }}</td><td>@include('partials.status', ['s' => $v->status])</td>
<td>@foreach(['approved' => 'Approve', 'rejected' => 'Reject', 'suspended' => 'Suspend'] as $k => $l)@if($v->status !== $k)<form method="POST" action="{{ route('admin.vendor.status', $v) }}" class="inl">@csrf<input type="hidden" name="status" value="{{ $k }}"><button class="btn sm {{ $k === 'approved' ? '' : 'ghost' }}">{{ $l }}</button></form>@endif @endforeach</td></tr>@endforeach</table></div>
@endsection
