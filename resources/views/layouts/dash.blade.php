@extends('layouts.app')
@section('content')
@php
$r = auth()->user()->role;
$menus = [
 'student' => ['student.dashboard' => 'Dashboard', 'explore' => 'Browse Food', 'restaurants' => 'Restaurants', 'student.cart' => 'Shopping Cart', 'student.orders' => 'My Orders / History', 'notices' => 'Notifications', 'profile' => 'My Profile'],
 'vendor' => ['vendor.dashboard' => 'Dashboard', 'vendor.foods' => 'Manage Food', 'vendor.categories' => 'Categories', 'vendor.orders' => 'Manage Orders', 'vendor.restaurant' => 'Restaurant', 'notices' => 'Notifications', 'profile' => 'Vendor Profile'],
 'admin' => ['admin.dashboard' => 'Dashboard', 'admin.students' => 'Students', 'admin.vendors' => 'Vendors', 'admin.foods' => 'Food', 'admin.categories' => 'Categories', 'admin.hostels' => 'Hostels', 'admin.orders' => 'Orders', 'admin.users' => 'Users & Roles', 'admin.reports' => 'Reports', 'admin.messages' => 'Messages', 'notices' => 'Notifications', 'admin.settings' => 'Settings', 'profile' => 'Profile'],
][$r];
@endphp
<div class="wrap dash">
  <aside class="side card">
    <div class="who"><b>{{ auth()->user()->name }}</b><small>{{ ucfirst($r) }}</small></div>
    @foreach($menus as $route => $label)<a href="{{ route($route) }}" class="{{ request()->routeIs($route) ? 'on' : '' }}">{{ $label }}</a>@endforeach
    <form method="POST" action="{{ route('logout') }}">@csrf<button class="linkbtn">Logout</button></form>
  </aside>
  <section class="dmain">@yield('body')</section>
</div>
@endsection
