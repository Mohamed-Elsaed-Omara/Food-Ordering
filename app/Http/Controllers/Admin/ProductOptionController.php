<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductOptionRepositoryInterface;
use App\Models\ProductOption;
use Illuminate\Http\Request;

class ProductOptionController extends Controller
{

    protected $productOptionRepository;

    public function __construct(ProductOptionRepositoryInterface $productOptionRepository)
    {
        $this->productOptionRepository = $productOptionRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => ['required', 'max:255'],
            'product_id' => ['required', 'integer'],
            'price' => ['required', 'numeric']
        ],[
            'name.required' => 'Product option name is required',
            'name.max' => 'Product option max length is 255',
            'price.required' => 'Product option price is required',
            'price.numeric' => 'Product option price have to be a numeric',
        ]);

        $this->productOptionRepository->storeProductOption($validateData);

        toastr()->success('Created Successfully');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductOption $product_option)
    {
        try {
            $this->productOptionRepository->destroy($product_option);
            return response(['status' => 'success' , 'message' => 'Deleted Successfully!']);

        } catch (\Exception $e) {
            return response(['status' => 'error' , 'message' => 'something went wrong!']);
        }
    }
}
