<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'user_id',
    ];

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }

        public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
