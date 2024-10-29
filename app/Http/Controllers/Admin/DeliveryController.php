<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeliveryAreaDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryAreaRequest;
use App\Interfaces\DeliveryAreaRepositoryInterface;
use App\Models\DeliveryArea;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{

    protected $DeliveryAreaRepository;

    public function __construct(DeliveryAreaRepositoryInterface $DeliveryAreaRepository)
    {
        $this->DeliveryAreaRepository = $DeliveryAreaRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(DeliveryAreaDataTable $dataTable)
    {
        return $dataTable->render('admin.delivery-area.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        return view('admin.delivery-area.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeliveryAreaRequest $request) : RedirectResponse
    {
        $validateData = $request->validated();

        $this->DeliveryAreaRepository->storeDeliveryArea($validateData);

        toastr()->success('Created Successfully');

        return to_route('admin.delivery-area.index');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryArea $deliveryArea)
    {
        return view('admin.delivery-area.edit',compact('deliveryArea'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DeliveryAreaRequest $request, DeliveryArea $deliveryArea)
    {
        $validateData = $request->validated();

        $this->DeliveryAreaRepository->updateDeliveryArea($validateData, $deliveryArea);

        toastr()->success('Updated Successfully');

        return to_route('admin.delivery-area.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryArea $deliveryArea)
    {
        try{
            $this->DeliveryAreaRepository->destroyDeliveryArea($deliveryArea);
            return response(['status' => 'success','message' => 'Deleted Successfully'],200);
        }catch(\Exception $e){
            return response(['status' => 'error','message' => 'something went wrong'],500);
        }
    }
}
