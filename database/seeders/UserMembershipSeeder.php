<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\MembershipPackage;
use App\Models\UserMembership;
use Carbon\Carbon;

class UserMembershipSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Lấy tất cả user (trừ admin)
        $users = User::whereDoesntHave('roles', function ($q) {
            $q->where('name', 'admin');
        })->get();

        // 🔹 Lấy package active
        $packages = MembershipPackage::where('is_active', true)->get();

        // ⚠️ tránh lỗi nếu chưa có package
        if ($packages->isEmpty()) {
            return;
        }

        foreach ($users as $user) {

            // 🔹 random 1 gói
            $package = $packages->random();

            $startDate = now();
            $endDate = now()->addDays($package->duration_days);

            UserMembership::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'membership_package_id' => $package->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => 'active', // luôn active khi seed
                ]
            );
        }
    }
}