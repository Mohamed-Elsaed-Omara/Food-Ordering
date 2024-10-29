<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponCreateRequest;
use App\Interfaces\CouponRepositoryInterface;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $couponRepository;

    public function __construct(CouponRepositoryInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }
    public function index(CouponDataTable $dataTable)
    {
        return $dataTable->render('admin.coupon.index');
    }

    public function create()
    {
        return view('admin.coupon.create');
    }

    public function store(CouponCreateRequest $request) : RedirectResponse
    {
        $validateData = $request->validated();

        $this->couponRepository->storeCoupon($validateData);

        toastr()->success('Created Successfully');

        return to_route('admin.coupon.index');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupon.edit',compact('coupon'));
    }

    public function update(CouponCreateRequest $request, Coupon $coupon) : RedirectResponse
    {
        $validateData = $request->validated();

        $this->couponRepository->updateCoupon($coupon, $validateData);

        toastr()->success('Updated Successfully');

        return to_route('admin.coupon.index');
    }

    public function destroy(Coupon $coupon)
    {
        try{
            $this->couponRepository->destroyCoupon($coupon);
            return response(['status' => 'success', 'message' => 'Deleted Successfully'],200);
        }catch(\Exception $e){
            return response(['status' => 'error', 'message' => 'something went wrong!'],500);
        }
    }
}
