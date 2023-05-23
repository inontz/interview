<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Library\Cacher;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
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
        $order = Order::paginate();

        return (new OrderCollection($order))->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $request->validate([
            'phone' => 'required|number|phone_number',
            'address' => 'required|long|address',
            'tax_address' => 'long|address',
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
    public function show($order_number): JsonResponse
    {
        $order = Order::where('order_number', $order_number);
        dd($order);
        $cachedData = $this->cacher->getCached('checkout_'.$order->order_number);
        if ($cachedData) {
            $order = $cachedData;

            return response()->json($order, 200);
        } else {
            $order = new OrderResource($order);
            $this->cacher->setCached('checkout_'.$order->order_number, $order->toJson());

            return $order->response();
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
