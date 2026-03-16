<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{


    public function run()
    {
        $json = File::get(public_path('geojson/angiang_provinces.geojson'));

        $data = json_decode($json, true);

        foreach ($data['features'] as $feature) {

            $name = $feature['properties']['ten_tinh'];
            $code = $feature['properties']['ma_tinh'];

            Province::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'code' => $code,
                'type' => 'province'
            ]);
        }
    }
}
