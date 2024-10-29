<?php
namespace App\Repositories;

use App\Interfaces\ProductSizeRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\ProductSize;
use App\Traits\FileUploadTrait;

class ProductSizeRepository implements ProductSizeRepositoryInterface
{

    public function getProductSize(Product $product)
    {
        /* return Product::with([
        'sizes' => function ($query) use ($product) {
            $query->where('product_id', $product->id);
        },
        'options' => function ($query) use ($product) {
            $query->where('product_id', $product->id);
        }])
        ->find($product->id); */

        return $product->load(['sizes', 'options']);

    }
    public function storeProductSize(array $validateDate) : ProductSize
    {
        return ProductSize::create([
            'size' => $validateDate['size'],
            'price' => $validateDate['price'],
            'product_id' => $validateDate['product_id'],
        ]);
    }


    public function destroy(ProductSize $product_size): void
    {
        $product_size->delete();
    }
}
