<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Location;
use App\Models\Category;
use Illuminate\Support\Str;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(public_path('json/location.json'));
        $locations = json_decode($json, true);

        // lấy id category
        $tro = Category::where('slug', 'phong-tro')->first()->id;
        $khachsan = Category::where('slug', 'khach-san')->first()->id;
        $nhanghi = Category::where('slug', 'nha-nghi')->first()->id;

        foreach ($locations as $item) {

            $name = $item['TenDiaDiem'];

           
            $category_id = $tro;

            if (Str::contains(Str::lower($name), 'khách sạn')) {
                $category_id = $khachsan;
            }

            if (Str::contains(Str::lower($name), 'nhà nghỉ')) {
                $category_id = $nhanghi;
            }

           
            $baseSlug = Str::slug($name);
            $slug = $baseSlug;
            $count = 1;

            while (Location::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count;
                $count++;
            }

            Location::create([
                'category_id' => $category_id,
                'name' => $name,
                'slug' => $slug,
                'address' => $item['DiaChi'],
                'latitude' => $item['ViDo'],
                'longitude' => $item['KinhDo'],
            ]);
        }
    }
}