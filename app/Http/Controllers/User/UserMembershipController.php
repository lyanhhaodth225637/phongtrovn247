<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MembershipPackage;
use App\Models\UserMembership;
use App\Models\User;

use App\Models\WalletTransaction;
use App\Notifications\MembershipPurchasedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserMembershipController extends Controller
{
    //mua gói thành viên

    public function confirm($id)
    {
        $package = MembershipPackage::with('membership')->findOrFail($id);

        return view('user.membership.confirm', compact('package'));
    }

    public function purchase($id)
    {
        DB::beginTransaction();

        try {
            $authUser = Auth::user();

            $user = User::where('id', $authUser->id)
                ->lockForUpdate()
                ->firstOrFail();

            $package = MembershipPackage::with('membership')->findOrFail($id);

            // lấy gói active hiện tại của user
            $currentMembership = UserMembership::with('membershipPackage.membership')
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->lockForUpdate()
                ->latest('id')
                ->first();

            // nếu đang có gói active thì kiểm tra priority
            if ($currentMembership) {
                $currentPriority = $currentMembership->membershipPackage->membership->priority ?? 0;
                $newPriority = $package->membership->priority ?? 0;

                // đang có gói cao hơn hoặc bằng thì chặn mua gói thấp hơn / ngang
                if ($currentPriority >= $newPriority) {
                    DB::rollBack();

                    return back()->with(
                        'error',
                        'Bạn đang sử dụng gói ' . $currentMembership->membershipPackage->membership->name .
                        '. Không thể mua gói thấp hơn hoặc cùng cấp trong thời gian gói hiện tại còn hiệu lực.'
                    );
                }
            }

            // kiểm tra số dư
            if ($user->balance < $package->price) {
                DB::rollBack();

                return back()->with('error', 'Số dư không đủ để thanh toán gói dịch vụ này.');
            }

            $balanceBefore = $user->balance;
            $balanceAfter = $balanceBefore - $package->price;

            // hủy toàn bộ gói active cũ trước khi tạo gói mới
            UserMembership::where('user_id', $user->id)
                ->where('status', 'active')
                ->update([
                    'status' => 'cancelled',
                    'updated_at' => now(),
                ]);

            // trừ tiền
            $user->balance = $balanceAfter;
            $user->save();

            // lưu lịch sử thanh toán
            $transaction = WalletTransaction::create([
                'user_id' => $user->id,
                'transaction_code' => 'MEM' . now()->format('YmdHis') . strtoupper(Str::random(4)),
                'payment_code' => null,
                'type' => 'buy_membership',
                'amount' => $package->price,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'payment_gateway' => 'manual',
                'bank_name' => null,
                'bank_account_name' => null,
                'bank_account_number' => null,
                'transfer_content' => null,
                'status' => 'success',
                'description' => 'Thanh toán gói ' . $package->membership->name . ' - ' . $package->duration_days . ' ngày',
                'transactionable_type' => MembershipPackage::class,
                'transactionable_id' => $package->id,
                'approved_by' => null,
                'requested_at' => now(),
                'processed_at' => now(),
                'admin_note' => 'Người dùng thanh toán gói dịch vụ bằng số dư ví.',
            ]);

            // tạo gói mới
            $userMembership = UserMembership::create([
                'user_id' => $user->id,
                'membership_package_id' => $package->id,
                'start_date' => now(),
                'end_date' => now()->addDays($package->duration_days),
                'status' => 'active',
            ]);

            DB::commit();

            // gửi thông báo sau commit
            $user->notify(new MembershipPurchasedNotification(
                $package,
                $transaction,
                $userMembership
            ));

            return redirect()
                ->route('user.wallet.index')
                ->with('success', 'Thanh toán gói dịch vụ thành công!');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->with('error', 'Có lỗi xảy ra khi thanh toán gói dịch vụ!');
        }
    }
}
