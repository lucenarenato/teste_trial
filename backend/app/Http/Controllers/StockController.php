<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * Authenticated User Instance.
     *
     * @var User
     */
    public User | null $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->user = Auth::guard('api')->user();
    }

    /**
     * @OA\Post(
     *     path="/api/stock",
     *     tags={"Stock"},
     *     summary="Create Stock Entry",
     *     description="Create a new stock entry for a product",
     *     operationId="createStockEntry",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "product_id", "data", "quantity", "type_id"},
     *             @OA\Property(property="user_id", type="integer", example=1, description="ID of the user"),
     *             @OA\Property(property="product_id", type="integer", example=10, description="ID of the product"),
     *             @OA\Property(property="data", type="string", format="date", example="2024-10-11", description="Date of the stock entry"),
     *             @OA\Property(property="quantity", type="integer", example=5, description="Quantity of the stock"),
     *             @OA\Property(property="type_id", type="integer", example=1, description="Type of the stock entry: 1 for entry, 2 for exit"),
     *             @OA\Property(property="canceled", type="boolean", example=false, description="Whether the stock entry is canceled")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Stock entry created successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
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
     * @OA\Get(
     *     path="/api/stock",
     *     tags={"Stock"},
     *     summary="Get filtered stock data",
     *     description="Retrieve stock entries based on filters such as user, product, and period.",
     *     operationId="getStockData",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         required=false,
     *         description="Filter by user ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="product_id",
     *         in="query",
     *         required=false,
     *         description="Filter by product ID",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         required=false,
     *         description="Filter by start date (YYYY-MM-DD)",
     *         @OA\Schema(type="string", format="date", example="2024-01-01")
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         required=false,
     *         description="Filter by end date (YYYY-MM-DD)",
     *         @OA\Schema(type="string", format="date", example="2024-10-01")
     *     ),
     *     @OA\Response(response=200, description="Successfully retrieved stock data"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
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
     * @OA\Get(
     *     path="/api/stock/statistics",
     *     tags={"Stock"},
     *     summary="Get stock statistics",
     *     description="Retrieve statistics for top 10 products with the most and least stock.",
     *     operationId="getStockStatistics",
     *     @OA\Response(response=200, description="Successfully retrieved stock statistics"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
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
