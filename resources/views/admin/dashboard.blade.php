@extends('layouts.dash')
@section('body')
<h2>Administrator Dashboard</h2><div class="grid g4 stats">@foreach($s as $k => $v)<div class="card pad"><small>{{ $k }}</small><b>{{ $v }}</b></div>@endforeach</div>
<h3>Recent orders</h3><div class="card tw"><table class="table">@foreach($recent as $o)<tr><td><a href="{{ route('order.show', $o) }}">{{ $o->code }}</a></td><td>{{ $o->vendor->name }}</td><td>{{ $o->student->name }}</td><td>{{ number_format($o->total) }}</td><td>@include('partials.status', ['s' => $o->status])</td></tr>@endforeach</table></div>
<h3>Contact messages <a class="btn sm ghost" href="{{ route('admin.messages') }}">View all</a></h3>@forelse($messages as $m)<div class="card pad"><b>{{ $m->name }}</b> ({{ $m->email }}): {{ $m->message }}</div>@empty<p>None.</p>@endforelse
@endsection
