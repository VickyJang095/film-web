<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            [
                'name' => 'Hàn Quốc',
                'code' => 'KR',
                'slug' => 'han-quoc'
            ],
            [
                'name' => 'Mỹ',
                'code' => 'US',
                'slug' => 'my'
            ],
            [
                'name' => 'Nhật Bản',
                'code' => 'JP',
                'slug' => 'nhat-ban'
            ],
            [
                'name' => 'Việt Nam',
                'code' => 'VN',
                'slug' => 'viet-nam'
            ],
            [
                'name' => 'Ấn Độ',
                'code' => 'IN',
                'slug' => 'an-do'
            ]
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
} 