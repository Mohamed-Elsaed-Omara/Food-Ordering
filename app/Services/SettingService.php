<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    function getSetting()
    {
        return Cache::rememberForever('settings',function(){
            return Setting::pluck('value','key')->toArray(); // ['key' => 'value']
        });
    }
    
    function setGlobalSetting() : void
    {
        $settings = $this->getSetting();

        config()->set('settings',$settings);
    }

    function clearCacheSetting() : void
    {
        Cache::forget('settings');
    }
}
