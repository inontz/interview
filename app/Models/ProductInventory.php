<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class ProductInventory extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'product_id',
        'user_id',
    ];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
