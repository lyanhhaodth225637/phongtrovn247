<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Ward;
use App\Models\Province;

use Illuminate\Support\Facades\DB;

use SplFileObject;

class WardSeeder extends Seeder
{
    // public function run()
    // //phường/xã AG
    // {
    //     $json = File::get(public_path('geojson/angiang_wards.geojson'));

    //     $data = json_decode($json, true);

    //     foreach ($data['features'] as $feature) {

    //         $name = $feature['properties']['ten_xa'];
    //         $code = $feature['properties']['ma_xa'];

    //         Ward::create([
    //             'province_id' => 1,
    //             'name' => $name,
    //             'slug' => Str::slug($name),
    //             'code' => $code,
    //             'type' => 'ward'
    //         ]);
    //     }
    // }

    public function run(): void
    {
        $files = [
            'angiang_wards.geojson',
            'cantho_wards.geojson',
            'hanoi_wards.geojson',
            'tphcm_wards.geojson',
        ];

        $provinceMap = Province::pluck('id', 'code')->toArray();
        $count = 0;
        $skipped = 0;

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

                $provinceCode = trim((string) ($properties['ma_tinh'] ?? ''));
                $wardCode = trim((string) ($properties['ma_xa'] ?? ''));
                $wardName = trim((string) ($properties['ten_xa'] ?? ''));

                if (!$provinceCode || !$wardCode || !$wardName) {
                    continue;
                }

                $provinceId = $provinceMap[$provinceCode] ?? null;

                if (!$provinceId) {
                    continue;
                }

                $rawType = mb_strtolower(trim((string) ($properties['loai'] ?? '')));

                $type = match ($rawType) {
                    'phường', 'phuong' => 'ward',
                    'xã', 'xa' => 'commune',
                    'đặc khu', 'dac khu' => 'special_zone',
                    default => 'ward',
                };

              
                $byCode = Ward::where('code', $wardCode)->first();

                if ($byCode) {
                    $byCode->update([
                        'province_id' => $provinceId,
                        'name' => $wardName,
                        'slug' => Str::slug($wardName),
                        'type' => $type,
                    ]);

                    $count++;
                    continue;
                }

               
                $duplicateByName = Ward::where('province_id', $provinceId)
                    ->where('name', $wardName)
                    ->first();

                if ($duplicateByName) {
                    $skipped++;
                    $this->command->warn("Bỏ qua bản ghi trùng tên: {$wardName} (province_id={$provinceId}, code={$wardCode})");
                    continue;
                }

               
                Ward::create([
                    'province_id' => $provinceId,
                    'code' => $wardCode,
                    'name' => $wardName,
                    'slug' => Str::slug($wardName),
                    'type' => $type,
                ]);

                $count++;
            }
        }

        $this->command->info("Đã seed {$count} phường/xã.");
        $this->command->warn("Đã bỏ qua {$skipped} bản ghi trùng tên trong cùng tỉnh.");
    }
}
