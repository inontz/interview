<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Events\OrderSaved;

class Order extends BaseModel
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'order_number',
        'user_id',
        'summary_price',
        'item_count',
        'phone',
        'address',
        'tax_address',
        'status',
    ];

    protected $dispatchesEvents = [
        'saved' => OrderSaved::class,
    ];

    public function order_item()
    {
        return $this->hasMany(Order_item::class);
    }
}
