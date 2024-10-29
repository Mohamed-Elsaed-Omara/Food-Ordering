<?php

namespace App\Interfaces;

use App\Models\Product;
use App\Models\ProductGallery;

interface ProductGalleryRepositoryInterface
{
    public function getProductGallery(Product $product);
    public function storeProductGallery($request);
    public function destroy(ProductGallery $product_gallery);

}
