<?php
namespace App\Repositories;

use App\Interfaces\ProductGalleryRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Traits\FileUploadTrait;

class ProductGalleryRepository implements ProductGalleryRepositoryInterface
{
    use FileUploadTrait;

    public function getProductGallery(Product $product)
    {
        return ProductGallery::where('product_id',$product->id)->get();

    }
    public function storeProductGallery($request): void
    {
        $imagePath = $this->updateImage($request,'image');

        ProductGallery::create([
            'image' => $imagePath,
            'product_id' => $request['product_id'],
        ]);
    }


    public function destroy(ProductGallery $product_gallery): void
    {
        $this->removeImage($product_gallery->image);
        $product_gallery->delete();
    }
}
