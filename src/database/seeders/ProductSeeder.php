<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::withoutGlobalScopes()->insert([
            [
                'tenant_id'            => 1,
                'name'                 => 'Pen',
                'sku'                  => 'PEN-001',
                'price'                => 10,
                'stock'                => 100,
                'low_stock_threshold'  => 10,
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'tenant_id'            => 1,
                'name'                 => 'Notebook',
                'sku'                  => 'NOTE-001',
                'price'                => 50,
                'stock'                => 50,
                'low_stock_threshold'  => 5,
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
        ]);
    }
}
