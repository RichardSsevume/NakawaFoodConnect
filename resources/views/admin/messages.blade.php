@extends('layouts.dash')
@section('body')
<h2>Contact Messages</h2>
@forelse($messages as $m)
<div class="card pad"><b>{{ $m->name }}</b> ({{ $m->email }}) <small>· {{ $m->created_at->diffForHumans() }}</small>
<p>{{ $m->message }}</p>
<form method="POST" action="{{ route('admin.messages.delete', $m) }}" onsubmit="return confirm('Delete this message?')">@csrf @method('DELETE')<button class="linkbtn">Delete</button></form></div>
@empty
<p>No messages yet.</p>
@endforelse
@endsection
