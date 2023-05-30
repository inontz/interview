<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'address_line_1',
        'address_line_2',
        'city',
        'postal_code',
        'country',
        'tel_phone',
        'tax_request',
        'tax_identification',
        'tax_address_line_1',
        'tax_address_line_2',
        'tax_city',
        'tax_postal_code',
        'tax_country',
        'tax_tel_phone',
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
