<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable =
    [
            'thumb_image',
            'name',
            'slug',
            'category_id',
            'price' ,
            'offer_price' ,
            'quantity',
            'short_description',
            'long_description' ,
            'sku' ,
            'seo_title',
            'seo_description',
            'show_at_home',
            'status',
    ];

    public function category(): BelongsTo{

        return $this->belongsTo(Category::class,'category_id');
    }

    public function images(): HasMany{

        return $this->hasMany(ProductGallery::class,'product_id');
    }

    public function sizes(): HasMany{

        return $this->hasMany(ProductSize::class,'product_id');
    }

    public function options(): HasMany{

        return $this->hasMany(ProductOption::class,'product_id');
    }
}
