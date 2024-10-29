<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewaySetting;
use App\Services\PaymentGatewaySettingService;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentGatewaySettingController extends Controller
{
    use FileUploadTrait;
    function index() : View
    {
        $paymentGatewaySettings = PaymentGatewaySetting::pluck('value','key');

        return view('admin.payment-setting.index',compact('paymentGatewaySettings'));
    }

    function paypalSettingUpdate(Request $request)
    {
        $validateData = $request->validate([
            'paypal_status' => ['required','boolean'],
            'paypal_account_mode' => ['required', 'in:sandbox,live'],
            'paypal_country' => ['required'],
            'paypal_currency' => ['required'],
            'paypal_rate' => ['required','numeric'],
            'paypal_api_id' => ['required'],
            'paypal_secret_key' => ['required'],
            'paypal_logo' =>   ['nullable','image'],
        ]);

        if ($request->hasFile('paypal_logo')) {
            $oldLogo = PaymentGatewaySetting::where('key', 'paypal_logo')->value('value');
            $newLogoPath = $this->updateImage($request, 'paypal_logo', $oldLogo, '/uploads/paypal_logos');
            $validateData['paypal_logo'] = $newLogoPath;
        }


        foreach ($validateData as $key => $value) {
            PaymentGatewaySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        //clear paymentSetting cache
        $paymentGateway = app(PaymentGatewaySettingService::class);
        $paymentGateway->clearCachedPaymentSetting();
        
        toastr()->success('Payment gateway setting updated successfully.');

        return redirect()->back();
    }
}
