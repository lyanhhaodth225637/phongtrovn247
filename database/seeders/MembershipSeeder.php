<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Membership;
use Illuminate\Support\Str;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        // $memberships = [
        //     ['name' => 'Vip 5', 'priority' => 50, 'color' => '#fb2c36'],
        //     ['name' => 'Vip 4', 'priority' => 40, 'color' => '#f6339a'],
        //     ['name' => 'Vip 3', 'priority' => 30, 'color' => '#ff5723'],
        //     ['name' => 'Vip 2', 'priority' => 20, 'color' => '#155dfc'],
        //     ['name' => 'Vip 1', 'priority' => 10, 'color' => '#0e4db3'],
        //     ['name' => 'Free', 'priority' => 0, 'color' => '#6c757d'],
        // ];
        $memberships = [
            ['name' => 'Đề Xuất', 'priority' => 50, 'color' => '#fb2c36'],
            ['name' => 'Nổi Bật', 'priority' => 40, 'color' => '#f6339a'],
            ['name' => 'Thường', 'priority' => 10, 'color' => '#0e4db3'],

        ];

        foreach ($memberships as $item) {
            Membership::create([
                'name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'priority' => $item['priority'],
                'color' => $item['color'],
                'description' => '',
            ]);
        }
    }
}
