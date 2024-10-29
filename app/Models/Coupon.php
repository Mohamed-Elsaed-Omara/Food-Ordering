<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'min_purchase_amount',
        'discount',
        'discount_type',
        'expiry_date',
        'status',
        'quantity',
    ];
}
