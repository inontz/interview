<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductInventory extends BaseModel
{
    use HasFactory;


    protected $fillable = [
        'quantity',
        'product_id'
    ];
}
