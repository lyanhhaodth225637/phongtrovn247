<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\LandlordApprovedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

use App\Models\Membership;
use App\Models\MembershipPackage;
use App\Models\UserMembership;



use Carbon\Carbon;


class LandlordApprovalController extends Controller
{
    // public function index()
    // {
    //     $notifications = auth()->user()
    //         ->notifications()
    //         ->where('type', \App\Notifications\LandlordVerificationRequestedNotification::class)
    //         ->latest()
    //         ->paginate(10);

    //     return view('admin.landlord_approval.index', compact('notifications'));
    // }

    public function index()
    {
        $users = User::role('user')
            ->whereNotNull('email_verified_at')
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'landlord');
            })
            ->latest()
            ->get();
        return view('admin.user.landlord_approval', compact('users'));
    }

    public function indexApproved()
    {
        $users = User::role('landlord')
            ->whereNotNull('email_verified_at')
            ->latest()
            ->get();

        return view('admin.user.landlord_approved', compact('users'));
    }


    public function approveLandlord(string $id)
    {
        DB::beginTransaction();

        try {
            $user = User::lockForUpdate()->findOrFail($id);

            // 1) Nếu chưa có role landlord thì gán thêm
            if (!$user->hasRole('landlord')) {
                $user->assignRole('landlord');
            }

            // 2) Tìm gói thường
            $membership = Membership::where('slug', 'thuong')->first();

            if (!$membership) {
                throw new \RuntimeException('Không tìm thấy gói thường.');
            }

            $freePackage = MembershipPackage::where('membership_id', $membership->id)
                ->where('price', 0)
                ->where('is_active', true)
                ->orderByDesc('duration_days')
                ->first();

            if (!$freePackage) {
                throw new \RuntimeException('Không tìm thấy gói VIP 1 Free.');
            }

            // 3) Kiểm tra user đã có gói free này còn hiệu lực chưa
            $existingMembership = UserMembership::where('user_id', $user->id)
                ->where('membership_package_id', $freePackage->id)
                ->where('status', 'active')
                ->where('end_date', '>', now())
                ->first();

            if (!$existingMembership) {
                $startDate = now();
                $endDate = Carbon::parse($startDate)->addDays((int) $freePackage->duration_days);

                UserMembership::create([
                    'user_id' => $user->id,
                    'membership_package_id' => $freePackage->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => 'active',
                ]);
            }

            // 4) Gửi thông báo về user
            $user->notify(new LandlordApprovedNotification($user));

            DB::commit();

            return redirect()
                ->route('admin.user.show', [
                    'id' => $user->id,
                    'slug' => $user->slug
                ])
                ->with('success', 'Đã duyệt tài khoản thành công, người dùng hiện là "Chủ cho thuê" và đã được cấp gói VIP 1 Free.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Có lỗi xảy ra khi duyệt landlord!');
        }
    }

    public function revokeLandlord(string $id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);

            if ($user->hasRole('landlord')) {
                $user->removeRole('landlord');
            }

            DB::commit();

            return redirect()
                ->route('admin.user.show', ['id' => $user->id, 'slug' => $user->slug])
                ->with('success', 'Đã gỡ quyền landlord của người dùng.');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Có lỗi xảy ra khi gỡ quyền landlord!');
        }
    }

    public function lock(string $id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);

            // tránh tự khóa chính mình nếu muốn
            if (auth()->id() == $user->id) {
                return back()->with('error', 'Bạn không thể tự khóa tài khoản của chính mình.');
            }

            $user->update([
                'status' => 'locked',
            ]);

            DB::commit();

            return redirect()
                ->route('admin.user.show', ['id' => $user->id, 'slug' => $user->slug])
                ->with('success', 'Đã khóa tài khoản người dùng.');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Có lỗi xảy ra khi khóa tài khoản.');
        }
    }

    public function unlock(string $id)
    {

        // dd('đã vào đây');

        $user = User::findOrFail($id);

        $user->update([
            'status' => 'active',
        ]);

        DB::commit();

        return redirect()
            ->route('admin.user.show', ['id' => $user->id, 'slug' => $user->slug])
            ->with('success', 'Đã mở khóa tài khoản người dùng.');

    }
}