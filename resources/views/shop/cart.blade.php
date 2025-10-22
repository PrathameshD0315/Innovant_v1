@extends('layouts.app')
@section('content')
<div class="container mt-4">
  <h3>Your Cart</h3>
  @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
  @if($items->count())
    <table class="table">
      <thead><tr><th>Image</th><th>Name</th><th>Price</th><th>Qty</th></tr></thead>
      <tbody>
        @foreach($items as $it)
          <tr>
            <td><img src="{{ $it->product->images->first()?->url ?? asset('images/placeholder.png') }}" width="60"></td>
            <td>{{ $it->product->name }}</td>
            <td>₹{{ $it->product->price }}</td>
            <td>{{ $it->quantity }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @else
    <p>No items in cart.</p>
  @endif
</div>
@endsection
