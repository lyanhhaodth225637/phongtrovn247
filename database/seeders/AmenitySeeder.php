<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Amenity;


class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            'Wifi',
            'Máy lạnh',
            'Chỗ để xe',
            'Gác lửng',
            'Nhà vệ sinh riêng',
            'Tủ lạnh',
            'Máy giặt',
            'Camera an ninh',
            'Giờ giấc tự do',
            'Có hầm xe',
        ];

        foreach ($amenities as $name) {
            Amenity::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                ]
            );
        }
    }
}