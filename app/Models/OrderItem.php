<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class OrderItem extends BaseModel
{
    use HasFactory;

    protected $with = ['order_detail:order_number'];

    protected $fillable = [
        'order_detail_id',
        'product_id',
        'quantity',
    ];

    public function order_detail(): belongsTo
    {
        return $this->belongsTo(OrderDetail::class);
    }
}
