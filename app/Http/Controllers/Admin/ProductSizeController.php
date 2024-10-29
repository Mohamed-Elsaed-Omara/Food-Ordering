<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductSizeRepositoryInterface;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    protected $productSizeRepository;
    public function __construct(ProductSizeRepositoryInterface $productSizeRepository)
    {
        $this->productSizeRepository = $productSizeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $product = $this->productSizeRepository->getProductSize($product);
        return view('admin.product.size.index',compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'size' => ['required', 'max:255'],
            'product_id' => ['required', 'integer'],
            'price' => ['required', 'numeric']
        ]);

        $this->productSizeRepository->storeProductSize($validateData);

        toastr()->success('Created Successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSize $product_size)
    {
        try {
            $this->productSizeRepository->destroy($product_size);
            return response(['status' => 'success' , 'message' => 'Deleted Successfully!']);

        } catch (\Exception $e) {
            return response(['status' => 'error' , 'message' => 'something went wrong!']);
        }
    }
}
