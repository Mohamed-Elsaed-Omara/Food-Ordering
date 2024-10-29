<?php

namespace App\Interfaces;

use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductSize;

interface ProductSizeRepositoryInterface
{
    public function getProductSize(Product $product);
    public function storeProductSize(array $validateDate);
    public function destroy(ProductSize $product_size);

}
