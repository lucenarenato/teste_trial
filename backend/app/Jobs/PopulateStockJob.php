<?php

namespace App\Jobs;

use App\Models\Stock;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PopulateStockJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        for ($i = 0; $i < 10; $i++) {
            $user = User::inRandomOrder()->first();
            $product = Product::inRandomOrder()->first();

            Stock::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'data' => now(),
                'quantity' => rand(1, 100),
                'type_id' => rand(1, 2),
                'canceled' => false,
            ]);
        }
    }
}
