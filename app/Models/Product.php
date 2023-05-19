<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Order;
use App\Models\Categories;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'url',
        'pic_url',
        'instock'
    ];
    public function order_item()
    {
      return $this->hasMany(Order_items::class);
    }
    public function user()
    {
      return $this->belongsTo(User::class);
    }
    public function order()
    {
      return $this->belongsTo(Order::class);
    }
    public function category()
    {
      return $this->belongsTo(Categories::class);
    }

}
