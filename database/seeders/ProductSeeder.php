<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\products;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create demo images if not exist
        if (!Storage::disk('public')->exists('products/demo.jpg')) {
            // Storage::disk('public')->put('products/demo.jpg', file_get_contents('https://via.placeholder.com/400'));
        }

        $products = [
            ['name' => 'Red T-Shirt', 'price' => 499.00, 'description' => 'Comfortable cotton red t-shirt.'],
            ['name' => 'Wireless Mouse', 'price' => 799.00, 'description' => 'Smooth and fast wireless mouse.'],
            ['name' => 'Bluetooth Headphones', 'price' => 1499.00, 'description' => 'Noise-cancelling Bluetooth headset.'],
            ['name' => 'Smart Watch', 'price' => 2499.00, 'description' => 'Fitness tracking smart watch.'],
        ];

        foreach ($products as $data) {
            $product = products::create($data);

            ProductImage::create([
                'product_id' => $product->id,
                'path' => 'products/demo.jpg'
            ]);
        }
    }
}
