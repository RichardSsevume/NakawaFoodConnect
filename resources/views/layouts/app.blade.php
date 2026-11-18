<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Home') | {{ \App\Models\Setting::get('site_name', 'Nakawa Food Connect') }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>document.documentElement.dataset.theme = localStorage.getItem('theme') || (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');</script>
<link rel="preconnect" href="https://fonts.googleapis.com"><link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<header class="nav"><div class="wrap nav-in">
  <a href="{{ route('home') }}" class="brand"><img src="{{ asset('images/logo.jpeg') }}" alt="Nakawa Food Connect"></a>
  <button class="burger" onclick="document.querySelector('.links').classList.toggle('open')" aria-label="Menu">☰</button>
  <nav class="links">
    <a href="{{ route('home') }}">Home</a><a href="{{ route('explore') }}">Explore Food</a><a href="{{ route('restaurants') }}">Restaurants</a>
    <a href="{{ route('how') }}">How It Works</a><a href="{{ route('about') }}">About</a><a href="{{ route('contact') }}">Contact</a>
  </nav>
  <div class="nav-r">
    <button class="icon" id="theme" title="Light / dark mode" aria-label="Toggle theme">◐</button>
    @auth
      @if(auth()->user()->role === 'student')<a class="icon" href="{{ route('student.cart') }}" title="Cart">🛒 <b>{{ count(session('cart', [])) }}</b></a>@endif
      <a class="icon" href="{{ route('notices') }}" title="Notifications">🔔 <b>{{ auth()->user()->notices()->where('seen', false)->count() }}</b></a>
      <a class="btn" href="{{ route(auth()->user()->role.'.dashboard') }}">Dashboard</a>
    @else
      <a class="btn ghost" href="{{ route('login') }}">Login</a><a class="btn" href="{{ route('register.student') }}">Sign up</a>
    @endauth
  </div>
</div></header>
<main>
@if(session('ok'))<div class="wrap"><div class="flash ok">{{ session('ok') }}</div></div>@endif
@if($errors->any())<div class="wrap"><div class="flash err">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div></div>@endif
@yield('content')
</main>
<footer class="foot"><div class="wrap foot-in">
  <div><img class="flogo" src="{{ asset('images/logo.jpeg') }}" alt=""><p>Connecting students to food and convenient hostel delivery around Nakawa.</p></div>
  <div><h4>Explore</h4><a href="{{ route('explore') }}">Food</a><a href="{{ route('restaurants') }}">Restaurants</a><a href="{{ route('how') }}">How it works</a></div>
  <div><h4>Join</h4><a href="{{ route('register.student') }}">Student sign up</a><a href="{{ route('register.vendor') }}">Vendor sign up</a><a href="{{ route('contact') }}">Contact &amp; FAQ</a></div>
  <div><h4>Contact</h4><p>{{ \App\Models\Setting::get('contact_phone') }}<br>{{ \App\Models\Setting::get('contact_email') }}</p></div>
</div><div class="copy">© {{ date('Y') }} Nakawa Food Connect · MUBS</div></footer>
<script src="{{ asset('js/app.js') }}"></script>
</body></html>
