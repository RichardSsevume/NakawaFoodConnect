@extends('layouts.dash')
@section('body')
<h2>Users, Roles &amp; Permissions</h2><div class="card tw"><table class="table"><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th></th></tr>@foreach($users as $u)<tr><td>{{ $u->name }}</td><td>{{ $u->email }}</td>
<td>@if($u->id !== auth()->id())<form method="POST" action="{{ route('admin.user.role', $u) }}" class="inl">@csrf<select name="role" onchange="this.form.submit()">@foreach(['student', 'vendor', 'admin'] as $r)<option value="{{ $r }}" @selected($u->role === $r)>{{ ucfirst($r) }}</option>@endforeach</select></form>@else admin (you)@endif</td><td>{{ $u->status }}</td>
<td>@if($u->id !== auth()->id())<form method="POST" action="{{ route('admin.user.status', $u) }}">@csrf<button class="btn sm ghost">{{ $u->status === 'active' ? 'Deactivate' : 'Activate' }}</button></form>@endif</td></tr>@endforeach</table></div>
<p><small>Permissions: students order and view their own orders; vendors manage only their own menu/orders; administrators manage everything. Enforced by role middleware and ownership checks.</small></p>
@endsection
