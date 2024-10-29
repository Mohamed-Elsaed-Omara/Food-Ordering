<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AddressRequest;
use App\Http\Requests\Frontend\UpdateAddressRequest;
use App\Models\Address;
use App\Models\DeliveryArea;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index(): View
    {

        $deliveryAreas = DeliveryArea::where('status', 1)->get();
        $addresses = Address::where('user_id', auth()->user()->id)->get();
        return view('frontend.dashboard.index', compact(['deliveryAreas', 'addresses']));
    }

    public function createAddress(AddressRequest $request)
    {

        $validatedData = $request->validated();

        $validatedData['user_id'] = auth()->user()->id;
        Address::create($validatedData);

        return response(['status' => 'success', 'message' => 'Address Added Successfully!'], 200);
    }

    public function updateAddress(UpdateAddressRequest $request, string $id)
    {
        try {
            $validatedData = $request->validated();

            $filteredData = [];
            foreach ($validatedData as $key => $value) {
                $newKey = str_replace('update_', '', $key);
                $filteredData[$newKey] = $value;
            }

            $address = Address::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();

            if (!$address) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Address not found or does not belong to you.'
                ], 403);
            }

            $address->update($filteredData);

            return response()->json([
                'status' => 'success',
                'message' => 'Address updated successfully!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating the address. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteAddress(string $id)
    {
        $address = Address::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
        if (!$address) {
            return response()->json([
                'status' => 'error',
                'message' => 'Address not found or does not belong to you.'
            ], 403);
        }
        $address->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Address deleted successfully!'
        ], 200);
    }
}
