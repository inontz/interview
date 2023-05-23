<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Library\Cacher;
use App\Http\Resources\Order_itemCollection;
use App\Models\Order_item;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Validator;

class OrderItemController extends Controller
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
        $orderItem = Order_item::with(['order', 'product'])->paginate();

        return (new Order_itemCollection($orderItem))->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $order_number = rand(0, 99999);
        foreach ($request->all() as $key => $value) {
            $order_item = new Order_item();
            $order_item->order_number = $order_number;
            $order_item->product_id = $value['product_id'];
            $order_item->quantity = $value['quantity'];
            $order_item->user_id = $user->id;
            $order_item->save();
            $this->cacher->setCached('order_item_'.$order_item->id, $order_item->toJson());
        }

        Log::info("Order number {$order_number} created successfully. Please check out for more information");
        $order = Order_item::where('order_number', $order_number)->with(['order', 'product'])->paginate();
        return (new Order($order_number))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order_items $order_items)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order_items $order_items)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order_items $order_items)
    {
        //
    }
}