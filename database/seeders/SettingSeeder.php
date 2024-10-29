<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \App\Models\Setting::insert([
            [
                'key' => 'site_name',
                'value' => 'FoodOrder',
            ],
            [
                'key' => 'site_default_currency',
                'value' => 'USD',
            ],
            [
                'key' => 'site_currency_icon',
                'value' => '$',
            ],
            [
                'key' => 'site_currency_icon_position',
                'value' => 'left',
            ],
        ]);
    }
}
