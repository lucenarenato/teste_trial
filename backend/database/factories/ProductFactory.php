<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'image' => $this->faker->image('public/images/products', 640, 480),
            'barcode' => $this->faker->ean13(),
            'is_active' => $this->faker->boolean(),
            'user_id' => $this->faker->numberBetween(1, 20), // Adicionando o user_id de 1 a 20
            'published_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
