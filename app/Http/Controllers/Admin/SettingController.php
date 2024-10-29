<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Interfaces\SettingRepositoryInterface;
use App\Services\SettingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingRepository;
    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }
    function index() : View
    {
        return view('admin.setting.index');
    }

    function updateGeneralSetting(SettingRequest $request) /* : RedirectResponse */
    {
        $attribute = $request->except(array_merge(['_token', '_method']));

        $this->settingRepository->updateSetting($attribute);

        //forget cache
        $settings = app(SettingService::class);
        $settings->clearCacheSetting();

        toastr()->success('Settings updated successfully');

        return redirect()->back();
    }
}
