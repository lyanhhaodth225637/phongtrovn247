<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{

    public function run(): void
    {
        $categories = [
            ['name' => 'Phòng trọ', 'image' => 'tro.png'],
            ['name' => 'Khách sạn', 'image' => 'khachsan.png'],
            ['name' => 'Nhà nghỉ', 'image' => 'nhanghi.png'],
            ['name' => 'Nhà nguyên căn', 'image' => 'nhanguyencan.png'],
            ['name' => 'Chung cư', 'image' => 'chungcu.png'],
        ];

        foreach ($categories as $item) {
            Category::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                [
                    'name' => $item['name'],
                    'image' => $item['image'],
                    'status' => 'show',
                ]
            );
        }
    }
}
