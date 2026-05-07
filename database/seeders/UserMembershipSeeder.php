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
       
        $users = User::whereDoesntHave('roles', function ($q) {
            $q->where('name', 'admin');
        })->get();

       
        $packages = MembershipPackage::where('is_active', true)->get();

    
        if ($packages->isEmpty()) {
            return;
        }

        foreach ($users as $user) {

          
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
                    'status' => 'active', 
                ]
            );
        }
    }
}