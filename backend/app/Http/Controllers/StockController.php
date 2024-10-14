<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StockController extends Controller
{
    /**
     * Lançamento de estoque (entrada/saída).
     */
    public function createStockEntry(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'product_id' => 'required|integer|exists:products,id',
            'data' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'type_id' => 'required|integer',
            'canceled' => 'boolean',
        ]);

        $stock = Stock::create($validated);

        return response()->json([
            'id' => $stock->id,
            'user' => $stock->user->name ?? 'Unknown',
            'product' => $stock->product->name ?? 'Unknown',
            'data' => $stock->data,
            'quantity' => $stock->quantity,
            'type' => $stock->type_id == 1 ? 'Entrada' : 'Saída',
            'canceled' => $stock->canceled,
        ], 201);
    }

    /**
     * Consulta de estoque com filtros.
     */
    public function getStockData(Request $request)
    {
        $query = Stock::query();

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $query->whereBetween('data', [$startDate, $endDate]);
        }

        $stockData = $query->get();

        return response()->json($stockData);
    }

    /**
     * Estatísticas de estoque (Tabelas/Gráficos).
     */
    public function getStockStatistics()
    {
        $topProductsWithMostStock = Stock::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();

        $topProductsWithLeastStock = Stock::with('product')
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->groupBy('product_id')
            ->orderBy('total_quantity')
            ->limit(10)
            ->get();

        return response()->json([
            'top_products_with_most_stock' => $topProductsWithMostStock,
            'top_products_with_least_stock' => $topProductsWithLeastStock,
        ]);
    }
}
