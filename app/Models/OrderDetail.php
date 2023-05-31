<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class OrderDetail extends BaseModel
{
    use HasFactory;

    protected $with = ['order_item', 'user'];

    protected $fillable = [
        'order_number',
        'total',
        'user_id',
    ];

    public function order_item(): HasMany
    {
        return $this->HasMany(OrderItem::class);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
