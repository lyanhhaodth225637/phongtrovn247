<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Membership;
use App\Models\MembershipPackage;
use App\Models\UserMembership;
use Carbon\Carbon;

class UserObserver
{
    public function updated(User $user): void
    {
        if (!config('app.auto_approve_landlord_demo')) {
            return;
        }

        if (!$user->wasChanged('email_verified_at')) {
            return;
        }

        if (!$user->email_verified_at) {
            return;
        }

        if (!$user->hasRole('landlord')) {
            $user->assignRole('landlord');
        }

        // Cấp gói miễn phí mặc định nếu chưa có
        $hasActiveMembership = UserMembership::where('user_id', $user->id)
            ->where('status', 'active')
            ->exists();

        if ($hasActiveMembership) {
            return;
        }

        $membership = Membership::where('slug', 'thuong')->first();

        if (!$membership) {
            return;
        }

        $package = MembershipPackage::where('membership_id', $membership->id)
            ->where('price', 0)
            ->where('is_active', true)
            ->first();

        if (!$package) {
            return;
        }

        $now = Carbon::now();

        UserMembership::create([
            'user_id' => $user->id,
            'membership_package_id' => $package->id,
            'start_date' => $now,
            'end_date' => $now->copy()->addDays($package->duration_days),
            'status' => 'active',
        ]);
    }
}