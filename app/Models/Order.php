<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'summary_price',
        'item_count',
        'phone',
        'address',
        'tax_address',
    ];

    public function order_item()
    {
        return $this->hasMany(Order_items::class);
    }
}
