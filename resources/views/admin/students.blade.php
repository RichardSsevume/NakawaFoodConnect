@extends('layouts.dash')
@section('body')
<h2>Manage Students</h2><div class="card tw"><table class="table"><tr><th>Name</th><th>Email</th><th>Phone</th><th>Orders</th><th>Status</th><th></th></tr>@foreach($users as $u)<tr><td>{{ $u->name }}</td><td>{{ $u->email }}</td><td>{{ $u->phone }}</td><td>{{ $u->orders_count }}</td><td>{{ $u->status }}</td>
<td><form method="POST" action="{{ route('admin.user.status', $u) }}">@csrf<button class="btn sm ghost">{{ $u->status === 'active' ? 'Suspend' : 'Activate' }}</button></form></td></tr>@endforeach</table></div>
@endsection
