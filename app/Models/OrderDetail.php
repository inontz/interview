<?php

namespace App\Models;

use App\Events\OrderSaved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class OrderDetail extends BaseModel
{
    use HasFactory, Notifiable;

    protected $with = ['order_item'];

    protected $fillable = [
        'order_number',
        'total',
        'user_id',
    ];

    protected $dispatchesEvents = [
        'saved' => OrderSaved::class,
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
