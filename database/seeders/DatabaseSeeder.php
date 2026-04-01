<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([

                // 🔹 Danh mục - vị trí - tiện ích
            CategorySeeder::class,
            ProvinceSeeder::class,
            WardSeeder::class,
            LocationSeeder::class,
            AmenitySeeder::class,

                // 🔹 Membership
            MembershipSeeder::class,
            MembershipPackageSeeder::class,

                // 🔹 User + Role
            UserSeeder::class,

                // 🔹 Gán VIP cho user
            UserMembershipSeeder::class,

                // 🔹 Bài đăng
            PostSeeder::class,
            // PostImageSeeder::class,

        ]);
    }
}