<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
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

        // Cria 10 registros aleatórios para a tabela Stock
        for ($i = 1; $i <= 10; $i++) {
            Stock::create([
                'user_id' => rand(1, 5),
                'product_id' => rand(1, 14),
                'data' => Carbon::now()->subDays(rand(0, 30)),
                'quantity' => rand(1, 100),
                'type_id' => rand(1, 2),
                'type' => rand(1, 2) == 1 ? 'Entrada' : 'Saída',
                'canceled' => (bool)rand(0, 1),
            ]);
        }
    }
}
