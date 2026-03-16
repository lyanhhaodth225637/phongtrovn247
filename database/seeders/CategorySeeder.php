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
        Category::insert([
            [
                'name' => 'Phòng trọ',
                'slug' => Str::slug('Phòng trọ'),
                'image' => 'tro.png',
                'status' => 'show'
            ],
            [
                'name' => 'Khách sạn',
                'slug' => Str::slug('Khách sạn'),
                'image' => 'khachsan.png',
                'status' => 'show'
            ],
            [
                'name' => 'Nhà nghỉ',
                'slug' => Str::slug('Nhà nghỉ'),
                'image' => 'nhanghi.png',
                'status' => 'show'
            ]
        ]);
    }
}
