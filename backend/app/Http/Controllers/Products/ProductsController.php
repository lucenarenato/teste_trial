<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Repositories\ProductRepository;
use App\Repositories\ResponseRepository;
use Illuminate\Http\Response;


class ProductsController extends Controller
{
    public $productRepository;
    public $responseRepository;

    public function __construct(ProductRepository $productRepository, ResponseRepository $rp)
    {
        $this->middleware('auth:api', ['except' => ['indexAll']]);
        $this->productRepository = $productRepository;
        $this->responseRepository = $rp;
    }

    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Get Product List",
     *     description="Get Product List as Array",
     *     operationId="getProductList",
     *     @OA\Response(response=200, description="Successfully retrieved product list"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found")
     * )
     *
     */
    public function index()
    {
        try {
            $data = $this->productRepository->getAll();
            return $this->responseRepository->ResponseSuccess($data, 'Product List Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/view/all",
     *     tags={"Products"},
     *     summary="All Products - Publicly Accessible",
     *     description="Retrieve all products with pagination",
     *     operationId="getAllProducts",
     *     @OA\Response(response=200, description="Successfully retrieved all products"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */

    public function indexAll(Request $request)
    {
        try {
            $data = $this->productRepository->getPaginatedData($request->perPage);
            return $this->responseRepository->ResponseSuccess($data, 'Product List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/products/view/search",
     *     tags={"Products"},
     *     summary="All Products - Publicly Accessible",
     *     description="All Products - Publicly Accessible",
     *     operationId="searchProducts",
     *     @OA\Parameter(name="perPage", description="perPage, eg; 20", example=20, in="query", @OA\Schema(type="integer")),
     *     @OA\Parameter(name="search", description="search, eg; Test", example="Test", in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="All Products - Publicly Accessible" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function search(Request $request)
    {
        try {
            $data = $this->productRepository->searchProduct($request->search, $request->perPage);
            return $this->responseRepository->ResponseSuccess($data, 'Product List Fetched Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

   /**
     * @OA\POST(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Create New Product",
     *     description="Create New Product",
     *     operationId="createProduct",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="title", type="string", example="Product 1"),
     *              @OA\Property(property="description", type="string", example="Description of the product"),
     *              @OA\Property(property="price", type="number", format="float", example=101.20),
     *              @OA\Property(property="image", type="string", format="binary", example="image.jpg"),
     *              @OA\Property(property="barcode", type="string", example="123456789012"),
     *              @OA\Property(property="is_active", type="boolean", example=true),
     *              @OA\Property(property="SKU", type="string", example="SKU12345"),
     *              @OA\Property(property="published_at", type="string", format="date-time", example="2024-10-11T00:00:00Z"),
     *              @OA\Property(property="user_id", type="integer", example=1),
     *          ),
     *      ),
     *      @OA\Response(response=200, description="New Product Created Successfully"),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      @OA\Response(response=500, description="Internal Server Error"),
     * )
     */
    public function store(ProductRequest $request)
    {
        try {
            $data = $request->all();
            $unit = $this->productRepository->create($data);
            return $this->responseRepository->ResponseSuccess($unit, 'New Product Created Successfully !');
        } catch (\Exception $exception) {
            return $this->responseRepository->ResponseError(null, $exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     summary="Show Product Details",
     *     description="Show Product Details",
     *     operationId="getProductDetails",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Show Product Details" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function show($id)
    {
        try {
            $data = $this->productRepository->getByID($id);
            if (is_null($data))
                return $this->responseRepository->ResponseError(null, 'Product Not Found', Response::HTTP_NOT_FOUND);

            return $this->responseRepository->ResponseSuccess($data, 'Product Details Fetch Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     summary="Update Product",
     *     description="Update Product",
     *     operationId="updateProduct",
     *     @OA\Parameter(
     *         name="id",
     *         description="Product ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="title", type="string", example="Updated Product Title"),
     *              @OA\Property(property="description", type="string", example="Updated description of the product"),
     *              @OA\Property(property="price", type="number", format="float", example=105.50),
     *              @OA\Property(property="image", type="string", format="binary", example="updated_image.jpg"),
     *              @OA\Property(property="barcode", type="string", example="987654321098"),
     *              @OA\Property(property="is_active", type="boolean", example=true),
     *              @OA\Property(property="SKU", type="string", example="SKU54321"),
     *              @OA\Property(property="published_at", type="string", format="date-time", example="2024-10-11T00:00:00Z"),
     *              @OA\Property(property="user_id", type="integer", example=2),
     *          ),
     *      ),
     *     @OA\Response(response=200, description="Product Updated Successfully"),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Product Not Found"),
     *     @OA\Response(response=500, description="Internal Server Error"),
     * )
     */
    public function update(ProductRequest $request, $id)
    {
        try {
            $data = $this->productRepository->update($id, $request->all());
            if (is_null($data)) {
                return $this->responseRepository->ResponseError(null, 'Product Not Found', Response::HTTP_NOT_FOUND);
            }

            return $this->responseRepository->ResponseSuccess($data, 'Product Updated Successfully!');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     summary="Delete Product",
     *     description="Delete Product",
     *     operationId="deleteProduct",
     *     @OA\Parameter(name="id", description="id, eg; 1", required=true, in="path", @OA\Schema(type="integer")),
     *     @OA\Response( response=200, description="Delete Product" ),
     *     @OA\Response(response=400, description="Bad request"),
     *     @OA\Response(response=404, description="Resource Not Found")
     * )
     *
     */
    public function destroy($id)
    {
        try {
            $product =  $this->productRepository->getByID($id);
            $deleted = $this->productRepository->delete($id);
            if (!$deleted) {
                return $this->responseRepository->ResponseError(null, 'Product Not Found', Response::HTTP_NOT_FOUND);
            }

            return $this->responseRepository->ResponseSuccess($product, 'Product Deleted Successfully !');
        } catch (\Exception $e) {
            return $this->responseRepository->ResponseError(null, $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
