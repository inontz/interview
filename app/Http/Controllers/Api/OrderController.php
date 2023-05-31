<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Library\ApiHelpers;
use App\Http\Library\Cacher;
use App\Http\Resources\OrderCollection;
use App\Models\OrderDetail;
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
        $orderItem = OrderDetail::paginate();

        return (new OrderCollection($orderItem))->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $order_number = fake()->numerify('SP########');
        $item_count = 0;
        $total_price = 0.00;

        if ($user->address()) {
            $order = OrderDetail::create([
                'order_number' => $order_number,
                'total' => $total_price,
                'user_id' => $user->id,
            ]);

            if ($order) {
                $orderItems = [];
                for ($i = 0; $i < count($request->input('product_id')); $i++) {
                    $product_id = $request->input('product_id')[$i];
                    $quantity = $request->input('quantity')[$i];
                    $product = Product::find($product_id);
                    if ($product->stock == 0) {
                        Log::error('Cannot make order for '.$product->name.' because it is out of stock');

                        continue;
                    } elseif ($product->stock < $quantity) {
                        Log::error('Cannot make order for '.$product->id." because it's not enough to shipping");

                        continue;
                    } else {
                        $item_count += $quantity;
                        $total_price += ($product->price * $quantity);
                        $orderItems[] = [
                            'product_id' => $product_id,
                            'quantity' => $quantity,
                        ];
                    }

                }

                if (count($orderItems) > 0) {
                    $order->order_item()->createMany($orderItems);
                    $order->total = $total_price;
                    $order->save();
                    $this->cacher->setCached('order'.$order->id, $order->toJson());
                    $ordered = OrderDetail::find($order->id)->paginate();
                    Log::info("Order number {$order_number} created successfully.");

                    return (new OrderCollection($order))->response()->setStatusCode(Response::HTTP_CREATED);
                } else {
                    Log::info('No order to create.');
                    $error['details'] = 'No order to create.';

                    return $error->response();
                }

            }

        } else {
            Log::error($user->id.'Address not found.');
            $error['details'] = 'Address not found';

            return $error->response();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
