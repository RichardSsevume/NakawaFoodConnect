@extends('layouts.app')
@section('content')
<section class="hero"><img class="h1" src="{{ asset('images/3.jpeg') }}" alt=""><img class="h2" src="{{ asset('images/2.jpeg') }}" alt="">
  <div class="hero-c"><h1>Real Food,<br>Real <b>Convenience</b></h1><p>Order from trusted restaurants around Nakawa and get it delivered to your verified hostel.</p>
  <form action="{{ route('explore') }}" class="search"><input name="q" placeholder="Search for food…"><button class="btn">Search</button></form></div></section>
<section class="strip"><div class="wrap strip-in"><span>✔ Verified hostels</span><span>✔ Trusted restaurants</span><span>✔ Live order status</span><span>✔ Cash or Mobile Money</span><span>✔ Student friendly prices</span></div></section>
<section class="wrap sec"><h2>Welcome to Nakawa Food Connect</h2><p class="lead">One place for MUBS students in Nakawa hostels to browse menus, compare prices, order, and follow the order from kitchen to hostel gate.</p></section>
<section class="wrap sec"><h2>Featured Restaurants</h2><div class="grid g4">@foreach($vendors as $v)
<a class="card rest" href="{{ route('restaurant.show', $v) }}"><img src="{{ asset($v->image) }}" alt="{{ $v->name }}" loading="lazy"><div class="fb"><h3>{{ $v->name }}</h3><small>{{ $v->description }}</small></div></a>@endforeach</div></section>
<section class="wrap sec"><h2>Popular Meals</h2><div class="grid g4">@foreach($foods as $f)@include('partials.food')@endforeach</div><p class="center"><a class="btn" href="{{ route('explore') }}">View all food</a></p></section>
<section class="wrap sec"><h2>Food Categories</h2><div class="chips">@foreach($cats as $c)<a class="chip" href="{{ route('explore', ['cat' => $c->slug]) }}">{{ $c->name }}</a>@endforeach</div></section>
<section class="wrap sec"><h2>How It Works</h2><div class="grid g4 steps">
<div class="card step"><img src="{{ asset('images/23.jpeg') }}" alt=""><h3>1. Browse &amp; choose</h3><p>Pick meals from participating restaurants.</p></div>
<div class="card step"><img src="{{ asset('images/22.jpeg') }}" alt=""><h3>2. Select your hostel</h3><p>Choose a verified hostel delivery point.</p></div>
<div class="card step"><img src="{{ asset('images/2.1.jpeg') }}" alt=""><h3>3. Vendor accepts</h3><p>Follow Pending → Preparing → Delivery.</p></div>
<div class="card step"><img src="{{ asset('images/27.jpeg') }}" alt=""><h3>4. Receive &amp; pay</h3><p>Pay cash or Mobile Money on delivery.</p></div></div></section>
<section class="wrap sec"><h2>Verified Hostels</h2><div class="chips">@foreach($hostels as $h)<span class="chip">🏠 {{ $h->name }}</span>@endforeach</div></section>
<section class="wrap sec"><h2>Why Choose Us</h2><div class="grid g3"><div class="card pad"><h3>Clear orders</h3><p>One order number, price and status shared by student and vendor.</p></div><div class="card pad"><h3>Verified locations</h3><p>Only field-verified hostel delivery points can be selected.</p></div><div class="card pad"><h3>Privacy first</h3><p>No live tracking and only the minimum data collected.</p></div></div></section>
@endsection
