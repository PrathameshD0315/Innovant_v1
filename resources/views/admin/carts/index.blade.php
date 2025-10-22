@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
  <h1 class="text-2xl font-bold mb-4">Cart Items (Admin view)</h1>

  <div class="bg-white rounded shadow p-4">
    <table class="w-full">
      <thead class="text-left border-b"><tr><th>User ID</th><th>Product</th><th>Qty</th><th>Price</th><th>Added</th></tr></thead>
      <tbody>
        @foreach($items as $it)
        <tr class="border-b">
          <td class="py-2">{{ $it->user_id }}</td>
          <td class="py-2 flex items-center gap-3">
            <img src="{{ $it->product->images->first()?->url ?? asset('images/placeholder.png') }}" class="h-12 w-12 object-cover rounded">
            <div>
              <div class="font-semibold">{{ $it->product->name }}</div>
              <div class="text-xs text-gray-500">${{ number_format($it->product->price,2) }}</div>
            </div>
          </td>
          <td class="py-2">{{ $it->quantity }}</td>
          <td class="py-2">${{ number_format($it->product->price * $it->quantity,2) }}</td>
          <td class="py-2 text-sm text-gray-500">{{ $it->created_at->diffForHumans() }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-4">{{ $items->links() }}</div>
  </div>
</div>
@endsection
