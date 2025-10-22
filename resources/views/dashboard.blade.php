@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Menu -->
    <div class="mb-4">
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">View Products</a>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">Add Product</a>
        <a href="{{ route('admin.cart.index') }}" class="btn btn-warning">View Cart Items</a>
    </div>

    <p>Welcome, {{ auth()->user()->name }}!</p>
</div>
@endsection
