<?php

namespace Database\Seeders;

use App\Models\Setting;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'option_name' => 'Logo',
                'option_key' => 'website.logo',
                'option_value' => 'settings/logo.png',
            ],
            [
                'option_name' => 'Slogan',
                'option_key' => 'website.slogan',
                'option_value' => 'Your slogan here',
            ],
        ];

        $rows = [];
        $now = now();
        foreach ($data as $key => $value) {
            $rows[] = [
                'option_name' => $value['option_name'],
                'option_key' => $value['option_key'],
                'option_value' => $value['option_value'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        Setting::insert($rows);

        try {
            File::copy(asset('assets/images/favicon/favicon.png'), public_path('storage/settings/logo.png'));
        } catch (Exception $ex) {
            //
        }
    }
}
