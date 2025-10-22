@extends('layouts.app')
@section('content')
<div class="container mt-4">
  <h3>Shop</h3>
  <div class="row">
    @foreach($products as $p)
      <div class="col-md-3 mb-4">
        <div class="card">
          <img src="{{ $p->images->first()?->url ?? asset('images/placeholder.png') }}" class="card-img-top" style="height:160px;object-fit:cover;">
          <div class="card-body text-center">
            <h5>{{ $p->name }}</h5>
            <p class="text-muted">₹{{ $p->price }}</p>
            <a href="{{ route('shop.show', $p->id) }}" class="btn btn-outline-primary btn-sm">View</a>
            @auth
              <form method="POST" action="{{ route('cart.add', $p->id) }}" class="d-inline">@csrf<button class="btn btn-success btn-sm">Add</button></form>
            @endauth
          </div>
        </div>
      </div>
    @endforeach
  </div>
  {{ $products->links() }}
</div>
@endsection
