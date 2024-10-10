<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    public function run()
    {
        $stocks = [
            [
                'product_id' => 1,
                'type_id' => 1,
                'quantity' => 50,
                'user_id' => 1,
                'data' => now(),
                'type' => 'entrada', // Tipo de operação de entrada
                'canceled' => false, // Lançamento não cancelado
            ],
            [
                'product_id' => 2,
                'type_id' => 1,
                'quantity' => 30,
                'user_id' => 1,
                'data' => now(),
                'type' => 'saida', // Tipo de operação de saída
                'canceled' => false, // Lançamento não cancelado
            ],
        ];

        foreach ($stocks as $stock) {
            Stock::create($stock);
        }
    }
}
