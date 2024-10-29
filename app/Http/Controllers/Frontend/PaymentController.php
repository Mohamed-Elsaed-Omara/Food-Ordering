<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PaymentController extends Controller
{
    function index() : View
    {
        if(!session()->has('delivery_fee') || !session()->has('address')) {
            throw ValidationException::withMessages(['Something went wrong!']);
        }
        $subTotal = calculateTotal();
        $discount = session()->has('coupon') ? session()->get('coupon')['discount'] : 0;
        $delivery = session()->has('delivery_fee') ? session()->get('delivery_fee') : 0;
        $total = grandCartTotal($delivery);
        return view('frontend.pages.payment',compact([
            'subTotal',
            'discount',
            'delivery',
            'total',
        ]));
    }

    public function makePayment(Request $request, OrderService $orderService)
    {
        $request->validate([
            'payment_gateway' => ['required', 'string', 'in:paypal']
        ]);

        if ($orderService->createOrder()) {

            switch ($request->payment_gateway) {
                case 'paypal':
                    return response()->json(['redirect_url' => route('paypal.payment')]);
                    break;

                default:
                    return response()->json(['message' => 'Invalid payment gateway'], 400);
                    break;
            }
        }

        return response()->json(['message' => 'Order creation failed'], 500);
    }

    function setPaypalConfig(): array
    {
        $config = [
            'mode'    => config('gatewaySetting.paypal_account_mode'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id'         => config('gatewaySetting.paypal_api_id'),
                'client_secret'     => config('gatewaySetting.paypal_secret_key'),
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'live' => [
                'client_id'         => config('gatewaySetting.paypal_api_id'),
                'client_secret'     => config('gatewaySetting.paypal_secret_key'),
                'app_id'            => env('PAYPAL_LIVE_APP_ID', ''),
            ],

            'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => config('gatewaySetting.paypal_currency'),
            'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
            'locale'         => 'en_US', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => true, // Validate SSL when creating api client.
        ];

        return $config;
    }


    public function payWithPaypal()
    {
        return 'done';
    }
}
