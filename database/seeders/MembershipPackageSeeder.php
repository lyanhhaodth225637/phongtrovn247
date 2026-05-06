<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MembershipPackage;
use App\Models\Membership;
use Illuminate\Support\Str;

class MembershipPackageSeeder extends Seeder
{
    public function run(): void
    {
        // $packages = [
        //     // VIP 5
        //     ['membership' => 'vip-5', 'duration_days' => 7, 'price' => 100000],
        //     ['membership' => 'vip-5', 'duration_days' => 30, 'price' => 350000],

        //     // VIP 4
        //     ['membership' => 'vip-4', 'duration_days' => 7, 'price' => 80000],
        //     ['membership' => 'vip-4', 'duration_days' => 30, 'price' => 280000],

        //     // VIP 3
        //     ['membership' => 'vip-3', 'duration_days' => 7, 'price' => 60000],
        //     ['membership' => 'vip-3', 'duration_days' => 30, 'price' => 210000],

        //     // VIP 2
        //     ['membership' => 'vip-2', 'duration_days' => 7, 'price' => 40000],
        //     ['membership' => 'vip-2', 'duration_days' => 30, 'price' => 140000],

        //     // VIP 1 Free
        //     ['membership' => 'vip-1', 'duration_days' => 36500, 'price' => 0],


        // ];
        $packages = [
            
            ['membership' => 'de-xuat', 'duration_days' => 7, 'price' => 100000],
            ['membership' => 'de-xuat', 'duration_days' => 30, 'price' => 350000],

           
            ['membership' => 'noi-bat', 'duration_days' => 7, 'price' => 80000],
            ['membership' => 'noi-bat', 'duration_days' => 30, 'price' => 280000],


          
            ['membership' => 'thuong', 'duration_days' => 3, 'price' => 0],


        ];

        foreach ($packages as $item) {
            $membership = Membership::where('slug', $item['membership'])->first();

            if ($membership) {
                MembershipPackage::updateOrCreate(
                    [
                        'membership_id' => $membership->id,
                        'duration_days' => $item['duration_days'],
                    ],
                    [
                        'price' => $item['price'],
                        'is_active' => true,
                        'description' => 'Gói ' . $membership->name . ' trong ' . $item['duration_days'] . ' ngày',
                    ]
                );
            }
        }
    }
}
