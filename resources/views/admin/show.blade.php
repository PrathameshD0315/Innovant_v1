@extends('layouts.app')
@section('content')
<div class="container mx-auto p-6">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div x-data="{ idx: 0 }">
      <div class="h-96 bg-gray-100 rounded overflow-hidden">
        <template x-for="(img, i) in {{ json_encode($product->images->pluck('url')) }}" :key="i">
          <img x-show="idx === i" :src="img" class="w-full h-96 object-cover">
        </template>
      </div>
      <div class="flex gap-2 mt-3">
        <template x-for="(img, i) in {{ json_encode($product->images->pluck('url')) }}" :key="i">
          <img @click="idx = i" :src="img" class="h-16 w-16 object-cover rounded cursor-pointer">
        </template>
      </div>
    </div>
    <div>
      <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
      <p class="mt-4 text-gray-700">{{ $product->description }}</p>
      <div class="mt-4 text-2xl font-semibold">${{ number_format($product->price,2) }}</div>

      <form id="buyForm" class="mt-6">
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <label>Qty</label>
        <input type="number" name="quantity" value="1" min="1" class="border rounded px-2 py-1 w-20">
        <button type="button" id="buyBtn" class="ml-4 bg-indigo-600 text-white px-4 py-2 rounded">Buy now</button>
      </form>
    </div>
  </div>
</div>

<script>
document.getElementById('buyBtn').addEventListener('click', async () => {
  const form = document.getElementById('buyForm');
  const productId = form.product_id.value;
  const quantity = form.quantity.value;
  const res = await fetch('/checkout/create', {
    method: 'POST',
    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
    body: JSON.stringify({ items: [{ product_id: productId, quantity }] })
  });
  const j = await res.json();
  if (j.url) window.location = j.url;
});
</script>
@endsection
