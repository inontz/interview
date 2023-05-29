<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order_item extends BaseModel
{
    use HasFactory;

    protected $with = ['user', 'product'];

    protected $fillable = [
        'order_number',
        'user_id',
        'product_id',
        'price',
        'quantity',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
