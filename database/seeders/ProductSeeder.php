<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'sku' => 'SKU001',
            'name' => 'Produk A',
            'category_id' => null,
            'stock' => 10,
            'price' => 50000,
            'description' => 'Deskripsi produk A',
        ]);

        Product::create([
            'sku' => 'SKU002',
            'name' => 'Produk B',
            'category_id' => null,
            'stock' => 20,
            'price' => 75000,
            'description' => 'Deskripsi produk B',
        ]);
    }
}
