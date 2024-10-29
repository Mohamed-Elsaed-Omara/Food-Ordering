<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\DeliveryArea;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    function index() : View
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        $deliveryAreas = DeliveryArea::where('status', 1)->get();
        return view('frontend.pages.check-out', compact(['addresses', 'deliveryAreas']));
    }

    public function checkoutDeliveryCal(string $id)
    {
        try{
            $deliveryFee = Address::findOrFail($id)->deliveryArea?->delivery_fee;
            $grandTotal = grandCartTotal($deliveryFee);

            return response()->json(['delivery_fee' => $deliveryFee, 'grand_total' => $grandTotal]);
        }catch (\Exception $e){
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

    public function redirectCheckout(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required',
        ]);

        $address = Address::with('deliveryArea')->findOrFail($validate['id']);
        $selectAddress = $address->address . ', Area: ' . $address->deliveryArea?->area_name;

        session()->put('address', $selectAddress);
        session()->put('delivery_fee', $address->deliveryArea?->delivery_fee);
        return response()->json(['redirect' => route('payment.index')]);
    }
}
