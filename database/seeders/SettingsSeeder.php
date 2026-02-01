<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'trial_days',
                'value' => '5',
                'type' => 'integer',
                'description' => 'Durasi trial gratis dalam hari',
            ],
            [
                'key' => 'trial_enabled',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Aktifkan/nonaktifkan fitur trial gratis',
            ],
            [
                'key' => 'package_basic_price',
                'value' => '0',
                'type' => 'integer',
                'description' => 'Harga paket Basic per bulan (Rp)',
            ],
            [
                'key' => 'package_premium_price',
                'value' => '0',
                'type' => 'integer',
                'description' => 'Harga paket Premium per bulan (Rp)',
            ],
            [
                'key' => 'package_enterprise_price',
                'value' => '0',
                'type' => 'integer',
                'description' => 'Harga paket Enterprise per bulan (Rp)',
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
