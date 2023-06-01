<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Library\Cacher;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use ApiHelpers;

    private $cacher;

    public function __construct()
    {
        $this->cacher = new Cacher('redis');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $product = Product::paginate();

        return (new ProductCollection($product))->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'instock' => 'required',
        ]);

        $product = new Product();

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');
        $product->price = $request->input('price');
        $product->instock = $request->input('instock');
        $product->user_id = $user->id;
        $product->save();
        $this->cacher->setCached('product_'.$product->id, $product->toJson());

        Log::info("Product ID {$product->name} created successfully.");

        return (new ProductResource($product))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {

        $cachedData = $this->cacher->getCached('product_'.$product->id);
        if ($cachedData) {
            $product = $cachedData;

            return response()->json($product, 200);
        } else {
            $product = new ProductResource($product);
            $this->cacher->setCached('product_'.$product->id, $product->toJson());

            return $product->response();
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $user = Auth::user();
        if ($this->isAdmin($request->user())) {
            $product->name = $request->input('name');
            $product->desc = $request->input('desc');
            $product->category_id = $request->input('category_id');
            $product->price = $request->input('price');
            $product->stock = $request->input('stock');
        } elseif ($this->isEditor($request->user())) {
            $request->validate([
                'name' => 'required',
                'category_id' => 'integer',
            ]);
            $product->name = $request->input('name');
            $product->category_id = $request->input('category_id');
        } else {
            return response(NULL, Response::HTTP_UNAUTHORIZED);
        }
        $product->user_id = $user->id;
        $product->save();

        $cachedData = $this->cacher->getCached('product_'.$product->id);

        if ($cachedData) {
           $this->cacher->removeCached('product_'.$product->id);
        } else {
           $this->cacher->setCached('product_'.$product->id, $product->toJson());
        }

        Log::info("Product ID {$product->id} Update successfully.");

        $pd = Product::find($product->id);

        return (new ProductResource($pd))->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): Response
    {
        $product->delete();

        Log::info("Product ID {$product->id} deleted successfully.");

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
