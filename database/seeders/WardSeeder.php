<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Ward;
class WardSeeder extends Seeder
{
    public function run()
    {
        $json = File::get(public_path('geojson/angiang_wards.geojson'));

        $data = json_decode($json, true);

        foreach ($data['features'] as $feature) {

            $name = $feature['properties']['ten_xa'];
            $code = $feature['properties']['ma_xa'];

            Ward::create([
                'province_id' => 1,
                'name' => $name,
                'slug' => Str::slug($name),
                'code' => $code,
                'type' => 'ward'
            ]);
        }
    }
}
