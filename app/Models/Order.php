<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order_items;

class Order extends Model
{
    use HasFactory;
    public function order_item()
    {
      return $this->hasMany(Order_items::class);
    }
}
