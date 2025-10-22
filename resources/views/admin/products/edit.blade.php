@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Product</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
        </div>
        <div class="mb-3">
            <label>Images (leave empty to keep existing)</label>
            <input type="file" name="images[]" multiple class="form-control">
            <div class="mt-2">
                @foreach($product->images as $img)
                    <img src="{{ asset('storage/'.$img->path) }}" width="50" class="me-1">
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
</div>
@endsection
