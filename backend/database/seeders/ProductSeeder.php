<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $products = [
            [
                'title' => 'Laptop',
                'description' => 'High performance laptop',
                'price' => 4000.00,
                'image' => null,
                'barcode' => '0956274827488',
                'is_active' => 1,
                'user_id'    => 1,
                'published_at' => now(),
            ],
            [
                'title' => 'Smartphone',
                'description' => 'High performance Smartphone',
                'price' => 3000.00,
                'image' => null,
                'barcode' => '8745826580252',
                'is_active' => 1,
                'user_id'    => 1,
                'published_at' => now(),
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
        Product::factory(10)->create();
    }
}
