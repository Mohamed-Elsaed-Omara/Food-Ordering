<?php

namespace App\Services;

use App\Models\PaymentGatewaySetting;
use Illuminate\Support\Facades\Cache;

class PaymentGatewaySettingService {

    function getPaymentSettings(){
        return Cache::rememberForever('gatewaySetting', function() {
            return PaymentGatewaySetting::pluck('value','key')->toArray();
        });
    }

    function setGlobalPaymentSetting() : void {
        $paymentGateway = $this->getPaymentSettings();
        config()->set('gatewaySetting',$paymentGateway);
    }

    function clearCachedPaymentSetting() : void {
        Cache::forget('gatewaySetting');
    }
}
