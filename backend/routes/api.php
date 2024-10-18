<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Products\ProductsController;
use App\Http\Controllers\StockController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api'
], function ($router) {

    /**
     * Authentication Module
     */
    Route::group(['prefix' => 'auth'], function() {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });

    /**
     * Products Module
     */
    Route::get('products', [ProductsController::class, 'index'])->name('products.index'); // Listar produtos
    Route::get('products/{product}', [ProductsController::class, 'show'])->name('products.show'); // Mostrar produto específico
    Route::post('products', [ProductsController::class, 'store'])->name('products.store'); // Criar novo produto
    Route::put('products/{product}', [ProductsController::class, 'update'])->name('products.update'); // Atualizar produto
    Route::patch('products/{product}', [ProductsController::class, 'update'])->name('products.update'); // Atualizar parcialmente produto
    Route::delete('products/{product}', [ProductsController::class, 'destroy'])->name('products.destroy'); // Excluir produto
    Route::get('products/view/all', [ProductsController::class, 'indexAll']);
    Route::get('products/view/search', [ProductsController::class, 'search']);

    /**
     * Stocks Module
     */
    Route::post('/stock', [StockController::class, 'createStockEntry']);
    Route::post('/stock/filter', [StockController::class, 'getStockData']);
    Route::get('/stock/statistics', [StockController::class, 'getStockStatistics']);

});
