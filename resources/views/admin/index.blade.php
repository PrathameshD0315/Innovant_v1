@extends('layouts.app')
@section('content')
<div class="container mx-auto p-6">
  <h1 class="text-2xl font-bold mb-6">Shop</h1>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @foreach($products as $p)
    <div class="bg-white rounded shadow p-4">
      <a href="{{ route('shop.show', $p) }}">
        <img src="{{ $p->images->first()?->url ?? asset('images/placeholder.png') }}" class="h-48 w-full object-cover rounded">
        <h2 class="mt-3 font-semibold">{{ $p->name }}</h2>
        <p class="text-indigo-600 font-bold">${{ number_format($p->price,2) }}</p>
      </a>
    </div>
    @endforeach
  </div>
  <div class="mt-6">{{ $products->links() }}</div>
</div>
@endsection
