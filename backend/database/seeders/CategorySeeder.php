<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Criando categorias
        $categories = [
            ['title' => 'Electronics', 'content' => 'Various electronic items', 'slug' => Str::slug('Electronics')],
            ['title' => 'Books', 'content' => 'Various books', 'slug' => Str::slug('Books')],
            ['title' => 'Clothing', 'content' => 'Various clothing items', 'slug' => Str::slug('Clothing')],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Executar a seed de produtos primeiro para garantir que os produtos existam
        $this->call([
            ProductSeeder::class,
        ]);

        // Criando relações na tabela pivot category_product
        $categoryProductData = [
            ['product_id' => 1, 'category_id' => 1],
            ['product_id' => 2, 'category_id' => 2],
            ['product_id' => 3, 'category_id' => 3],
        ];

        foreach ($categoryProductData as $data) {
            \DB::table('category_product')->insert($data);
        }

        // Criando tipos de produtos na tabela product_types
        $productTypes = [
            ['product_id' => 1, 'title' => 'Smartphone', 'type' => 'Electronics', 'order' => 1, 'parent_id' => null],
            ['product_id' => 2, 'title' => 'E-Book', 'type' => 'Books', 'order' => 2, 'parent_id' => null],
            ['product_id' => 3, 'title' => 'T-Shirt', 'type' => 'Clothing', 'order' => 3, 'parent_id' => null],
        ];

        foreach ($productTypes as $productType) {
            ProductType::create($productType);
        }

        // Estoque
        $this->call([
            StockSeeder::class,
        ]);
    }
}
