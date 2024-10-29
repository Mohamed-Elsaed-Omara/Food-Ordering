<?php
namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use App\Traits\FileUploadTrait;

class ProductRepository implements ProductRepositoryInterface
{
    use FileUploadTrait;
    public function storeProduct($request): void
    {
        $imagePath = $this->updateImage($request, 'image');

        $dataInput = $request->validated();
        $dataInput['thumb_image'] = $imagePath;
        $dataInput['category_id'] = $request->category;
        $dataInput['offer_price'] = $request->offer_price ?? 0;
        $dataInput['slug'] = generateUniqueSlug('Product', $request->name);

        Product::create($dataInput);
    }

    public function getById(Product $product)
    {
        $categories = Category::all();

        return compact('product', 'categories');
    }

    public function updateProduct($request, Product $product): void
    {
        $newPath = $this->updateImage($request,'image',$product->thumb_image);

        $dataInput = $request->validated();
        $dataInput['thumb_image'] = !empty($newPath) ? $newPath : $product->thumb_image;
        $dataInput['category_id'] = $request->category;
        //$dataInput['slug'] = generateUniqueSlug('Product', $request->name);

        $product->update($dataInput);

    }

    public function destroy(Product $product): void
    {
        $this->removeImage($product->thumb_image);
        $product->delete();
    }
}
