<article class="card food">
  <img src="{{ asset($f->image) }}" alt="{{ $f->name }}" loading="lazy">
  <div class="fb">
    <small>{{ $f->vendor->name }} · {{ $f->category->name ?? '' }}</small>
    <h3>{{ $f->name }}</h3>
    <div class="row"><b class="price">UGX {{ number_format($f->price) }}</b>
    @if(auth()->check() && auth()->user()->role === 'student')
      <form method="POST" action="{{ route('student.cart.add', $f) }}">@csrf<button class="btn sm">Add to cart</button></form>
    @elseif(!auth()->check())<a class="btn sm" href="{{ route('login') }}">Login to order</a>@endif</div>
  </div>
</article>
