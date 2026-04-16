<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{


    // public function run()
    // //Tỉnh/TP AG
    // {
    //     $json = File::get(public_path('geojson/angiang_provinces.geojson'));

    //     $data = json_decode($json, true);

    //     foreach ($data['features'] as $feature) {

    //         $name = $feature['properties']['ten_tinh'];
    //         $code = $feature['properties']['ma_tinh'];

    //         Province::create([
    //             'name' => $name,
    //             'slug' => Str::slug($name),
    //             'code' => $code,
    //             'type' => 'province'
    //         ]);
    //     }
    // }

    public function run(): void
    {
        $files = [
            'angiang_provinces.geojson',
            'cantho_provinces.geojson',
            'hanoi_provinces.geojson',
            'tphcm_provinces.geojson',
        ];

        $count = 0;

        foreach ($files as $fileName) {
            $path = public_path("geojson/{$fileName}");

            if (!File::exists($path)) {
                $this->command->warn("Không tìm thấy file: {$fileName}");
                continue;
            }

            $json = File::get($path);
            $data = json_decode($json, true);

            if (!isset($data['features']) || !is_array($data['features'])) {
                $this->command->warn("File không đúng định dạng GeoJSON: {$fileName}");
                continue;
            }

            foreach ($data['features'] as $feature) {
                $properties = $feature['properties'] ?? [];

                $name = trim((string) ($properties['ten_tinh'] ?? ''));
                $code = trim((string) ($properties['ma_tinh'] ?? ''));

                if (!$name || !$code) {
                    continue;
                }

                $type = $this->detectProvinceType($name);

                Province::updateOrCreate(
                    ['code' => $code],
                    [
                        'name' => $name,
                        'slug' => Str::slug($name),
                        'type' => $type,
                    ]
                );

                $count++;
            }
        }

        $this->command->info("Đã seed {$count} tỉnh/thành.");
    }

    private function detectProvinceType(string $name): string
    {
        $cities = [
            'Hà Nội',
            'Cần Thơ',
            'Thành phố Hồ Chí Minh',
            'TP. Hồ Chí Minh',
            'TP Hồ Chí Minh',
            'Hồ Chí Minh',
        ];

        return in_array($name, $cities, true) ? 'city' : 'province';
    }
}
