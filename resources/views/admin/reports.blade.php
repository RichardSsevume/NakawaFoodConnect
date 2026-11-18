@extends('layouts.dash')
@section('body')
<h2>Reports</h2><div class="grid g3 stats"><div class="card pad"><small>Sales (delivered, UGX)</small><b>{{ number_format($sales) }}</b></div><div class="card pad"><small>Delivered orders</small><b>{{ $count }}</b></div></div>
<h3>Vendor report</h3><div class="card tw"><table class="table"><tr><th>Vendor</th><th>Delivered</th><th>Revenue (UGX)</th></tr>@foreach($byVendor as $v)<tr><td>{{ $v->name }}</td><td>{{ $v->delivered }}</td><td>{{ number_format($v->revenue ?? 0) }}</td></tr>@endforeach</table></div>
<h3>Order report</h3><div class="chips">@foreach($byStatus as $s => $c)<span class="chip">{{ ucwords(str_replace('_', ' ', $s)) }}: {{ $c }}</span>@endforeach</div>
<h3>Top food items</h3><div class="card tw"><table class="table">@foreach($topFoods as $t)<tr><td>{{ $t->name }}</td><td>{{ $t->q }} sold</td></tr>@endforeach</table></div>
@endsection
