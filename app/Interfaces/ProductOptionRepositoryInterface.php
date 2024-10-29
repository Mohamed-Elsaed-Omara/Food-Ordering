<?php

namespace App\Interfaces;

use App\Models\ProductOption;

interface ProductOptionRepositoryInterface
{
    public function storeProductOption(array $validateDate): ProductOption;
    public function destroy(ProductOption $product_option) : void;

}
