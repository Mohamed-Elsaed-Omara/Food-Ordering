<?php
namespace App\Repositories;

use App\Interfaces\ProductOptionRepositoryInterface;
use App\Interfaces\ProductSizeRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductOption;
use App\Traits\FileUploadTrait;

class ProductOptionRepository implements ProductOptionRepositoryInterface
{

    public function getProductOption(Product $product)
    {
        //return ::where('product_id',$product->id)->get();

    }
    public function storeProductOption(array $validateDate) : ProductOption
    {
        return ProductOption::create([
            'name' => $validateDate['name'],
            'price' => $validateDate['price'],
            'product_id' => $validateDate['product_id'],
        ]);
    }


    public function destroy(ProductOption $product_option): void
    {
        $product_option->delete();
    }
}
