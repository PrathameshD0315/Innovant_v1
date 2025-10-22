@extends('layouts.app')
@section('content')
<div class="container mt-4">
  <div class="row">
    <div class="col-md-6">
      <img src="{{ $product->images->first()?->url ?? asset('images/placeholder.png') }}" class="img-fluid rounded">
    </div>
    <div class="col-md-6">
      <h3>{{ $product->name }}</h3>
      <p class="text-muted">₹{{ $product->price }}</p>
      <p>{{ $product->description }}</p>
      @auth
        <form method="POST" action="{{ route('cart.add', $product->id) }}">@csrf<button class="btn btn-success">Add to Cart</button></form>
      @else
        <a href="{{ route('login') }}" class="btn btn-primary">Login to buy</a>
      @endauth
    </div>
  </div>
</div>
@endsection
