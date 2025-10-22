<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\products;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // GET /api/products
    public function index()
    {
        return view('shop.index');
    
    }

    // GET /api/products/{id}
    public function show(Product $product)
    {
        $product->load('images');
        return response()->json($product);
    }

    // POST /api/products
    public function store(StoreProductRequest $request)
    {
        $data = $request->only(['name','price','description']);
        $product = products::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $originalName = $file->getClientOriginalName();
                // create unique filename
                $filename = now()->format('YmdHis') . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public/products', $filename); // stored in storage/app/public/products
                // store path without 'public/' prefix or with it — we will use Storage::url($path)
                // Save the path as 'products/filename' or full 'public/products/filename' — we'll save 'products/...' but storeAs returned 'public/products/...'
                // To avoid confusion store the returned $path
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => str_replace('public/', 'products/', $path), // simplified path (see accessor)
                    'original_name' => $originalName
                ]);
            }
        }

        $product->load('images');

        // Normalize image URLs before returning
        $this->normalizeImagePaths($product);

        return response()->json($product, 201);
    }

    // PUT/PATCH /api/products/{product}
    public function update(StoreProductRequest $request, Product $product)
    {
        $product->update($request->only(['name','price','description']));

        // Optionally add more images (we will append)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $originalName = $file->getClientOriginalName();
                $filename = now()->format('YmdHis') . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public/products', $filename);
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => str_replace('public/', 'products/', $path),
                    'original_name' => $originalName
                ]);
            }
        }

        $product->load('images');
        $this->normalizeImagePaths($product);

        return response()->json($product);
    }

    // DELETE /api/products/{product}
    public function destroy(products $product)
    {
        // this will cascade delete product_images due to foreign key onDelete('cascade')
        // but we also need to remove image files from storage
        foreach ($product->images as $img) {
            // img->path is 'products/filename' — convert to storage path
            $storagePath = 'public/' . ltrim($img->path, '/');
            if (Storage::exists($storagePath)) {
                Storage::delete($storagePath);
            }
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }

    // Extra: delete single product image
    public function destroyImage($imageId)
    {
        $img = ProductImage::findOrFail($imageId);
        $storagePath = 'public/' . ltrim($img->path, '/');
        if (Storage::exists($storagePath)) {
            Storage::delete($storagePath);
        }
        $img->delete();
        return response()->json(['message' => 'Image deleted']);
    }

    // Helper: ensures image->url returns full URL (Storage::url expects 'products/...')
    protected function normalizeImagePaths(Product $product)
    {
        $product->images->transform(function ($img) {
            // ensure path stored is 'products/...'
            $img->url = \Storage::url($img->path);
            return $img;
        });
    }
}
