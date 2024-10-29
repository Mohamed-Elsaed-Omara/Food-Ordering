<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'delivery_area_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'type',
    ];

    //relationship
    function deliveryArea() : BelongsTo
    {
        return $this->belongsTo(DeliveryArea::class, 'delivery_area_id', 'id');
    }
}
