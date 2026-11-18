@extends('layouts.dash')
@section('body')
<h2>Notifications</h2>@forelse($notices as $n)<div class="card pad">{{ $n->message }} <small>· {{ $n->created_at->diffForHumans() }}</small></div>@empty<p>No notifications.</p>@endforelse
@endsection
