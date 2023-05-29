<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Library\Cacher;
use App\Http\Resources\Order_itemCollection;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $order_number = rand(0, 99999);
        $item_count = 0;
        $total_price = 0.0;

        foreach ($request->all() as $key => $value) {
            $product = Product::find($key);
            if ($value > $product->instock) {
                Log::error('Cannot order product with quantity '.$value.' because in stock is: '.$product->in_stock);

                continue;
            } else {
                $order_item = Order_item::create([
                    'order_number' => $order_number,
                    'product_id' => $product->id,
                    'quantity' => $value,
                    'user_id' => $user->id,
                ]);
                $item_count += $value;
                $total_price += $product->price;
                $this->cacher->setCached('order_item_'.$order_item->id, $order_item->toJson());
            }

        }

        $order = Order::create([
            'order_number' => $order_number,
            'user_id' => $user->id,
            'item_count' => $item_count,
            'summary_price' => $total_price,
        ]);

        $this->cacher->setCached('ordered_'.$order->id, $order->toJson());

        Log::info("Order number {$order_number} created successfully. Please check out for more information");

        $ordered = new OrderResource($order);

        return $ordered->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show($order_number): JsonResponse
    {

        $order_no = Order_item::collection()->where('order_number', $order_number)->paginate();

        $cachedData = $this->cacher->getCached('ordered_'.$order->order_number);
        if ($cachedData) {
            $order = $cachedData;
            dd($order);

            return response()->json($order, 200);
        } else {
            $order = new Order_itemCollection($order_no);
            dd($order);
            // $this->cacher->setCached('ordered_'.$order->order_number, $order->toJson());

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
