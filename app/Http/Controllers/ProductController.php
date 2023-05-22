<?php

namespace App\Http\Controllers;

use App\Http\Library\Cacher;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    private $cacher;

    public function __construct()
    {
        $this->cacher = new Cacher('redis');
    }

    public function index()
    {

        return ProductResource::collection(Product::with(['category', 'user'])->paginate(25));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $cachedData = $this->cacher->getCached('product_'.$id);
        if ($cachedData) {
            $product = $cachedData;
        } else {
            $product = new ProductResource(Product::find($id));
            $this->cacher->setCached('product_'.$id, $product->toJson());
        }
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product does not exist.');
        }

        return $this->sendResponse(new ProductResource($product), 'Product fetched.');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
