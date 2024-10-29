<?php

namespace App\Repositories;

use App\Interfaces\SettingRepositoryInterface;
use App\Models\Setting;

class SettingRepository implements SettingRepositoryInterface
{
    protected $model;

    public function __construct() {

        $this->model = new Setting;
    }
    public function updateSetting($attr) {

        foreach($attr as $key => $value) {

            $this->model->where('key',$key)->update(['value' => $value]);
        }

    }
}
