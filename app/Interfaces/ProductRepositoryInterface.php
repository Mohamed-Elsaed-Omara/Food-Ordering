<?php

namespace App\Interfaces;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function storeProduct($request);
    public function getById(Product $product);
    public function updateProduct($request, Product $product);
    public function destroy(Product $product);

}
