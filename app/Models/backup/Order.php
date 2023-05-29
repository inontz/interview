<?php

namespace App\Models;

use App\Events\OrderSaved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends BaseModel
{
    use HasFactory, Notifiable;


    protected $with = ['user'];

    protected $fillable = [
        'order_number',
        'user_id',
        'summary_price',
        'item_count',
        'status',
    ];

    protected $dispatchesEvents = [
        'saved' => OrderSaved::class,
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
