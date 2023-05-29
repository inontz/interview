<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends BaseModel
{
    use HasFactory;

    protected $with = ['category'];

    protected $fillable = [
        'name',
        'desc',
        'price',
        'category_id',
        'inventory_id',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
