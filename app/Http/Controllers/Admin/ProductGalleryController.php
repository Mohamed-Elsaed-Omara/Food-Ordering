<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductGalleryRepositoryInterface;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{

    protected $productGalleryRepository;

    public function __construct(ProductGalleryRepositoryInterface $productGalleryRepository)
    {
        $this->productGalleryRepository = $productGalleryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $gallerys = $this->productGalleryRepository->getProductGallery($product);
        return view('admin.product.gallery.index',compact('product','gallerys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:3000'],
            'product_id' => ['required', 'integer']
        ]);

        $this->productGalleryRepository->storeProductGallery($request);

        toastr()->success('Created Successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductGallery $product_gallery)
    {
        try {
            $this->productGalleryRepository->destroy($product_gallery);
            return response(['status' => 'success' , 'message' => 'Deleted Successfully!']);

        } catch (\Exception $e) {
            return response(['status' => 'error' , 'message' => 'something went wrong!']);
        }
    }
}
