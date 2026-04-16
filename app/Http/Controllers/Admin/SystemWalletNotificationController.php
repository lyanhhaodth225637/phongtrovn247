<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemWalletNotification;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Notifications\DepositApprovedNotification;

use App\Notifications\ReferralRewardReceivedNotification;

use Throwable;


class SystemWalletNotificationController extends Controller
{
    public function index()
    {
        $notifications = SystemWalletNotification::with([
            'walletTransaction.user',
            'systemWallet',
            'handler',
        ])
            ->latest()
            ->paginate(15);

        $counts = SystemWalletNotification::selectRaw('match_status, count(*) as total')
            ->groupBy('match_status')
            ->pluck('total', 'match_status');

        return view('admin.wallet_notifications.index', compact('notifications', 'counts'));
    }

    public function show(SystemWalletNotification $notification)
    {
        $notification->load([
            'walletTransaction.user',
            'systemWallet',
            'handler',
        ]);

        return view('admin.wallet_notifications.show', compact('notification'));
    }

    public function approve(SystemWalletNotification $notification)
    {
        try {
            DB::transaction(function () use ($notification) {

                $lockedNotification = SystemWalletNotification::whereKey($notification->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($lockedNotification->match_status === 'approved') {
                    throw new \RuntimeException('Thông báo này đã được duyệt rồi.');
                }

                if ($lockedNotification->match_status === 'rejected') {
                    throw new \RuntimeException('Thông báo này đã bị từ chối trước đó, không thể duyệt lại.');
                }

                if (!$lockedNotification->wallet_transaction_id) {
                    throw new \RuntimeException('Thông báo này chưa liên kết với giao dịch nạp tiền nào.');
                }

                $transaction = WalletTransaction::with('user')
                    ->whereKey($lockedNotification->wallet_transaction_id)
                    ->lockForUpdate()
                    ->first();

                if (!$transaction) {
                    throw new \RuntimeException('Không tìm thấy giao dịch người dùng để đối soát.');
                }

                if ($transaction->type !== 'deposit') {
                    throw new \RuntimeException('Đây không phải giao dịch nạp tiền hợp lệ.');
                }

                if (!$transaction->user) {
                    throw new \RuntimeException('Không tìm thấy người dùng của giao dịch này.');
                }

                if ($transaction->status === 'success') {
                    throw new \RuntimeException('Giao dịch này đã được duyệt thành công trước đó.');
                }

                if ($transaction->status === 'failed') {
                    throw new \RuntimeException('Giao dịch này đã bị từ chối trước đó.');
                }

                if ($transaction->status !== 'processing') {
                    throw new \RuntimeException('Chỉ có thể duyệt giao dịch đang ở trạng thái chờ kiểm duyệt.');
                }

                $user = User::whereKey($transaction->user_id)
                    ->lockForUpdate()
                    ->first();

                if (!$user) {
                    throw new \RuntimeException('Không tìm thấy người dùng của giao dịch này.');
                }

                $amount = (int) $transaction->amount;
                $isFirstDeposit = !$user->has_deposited;

                $beforeUserBalance = (int) $user->balance;

                // =========================
                // TÍNH THƯỞNG CHO USER NẠP
                // =========================
                $firstDepositBonus = 0;       // +10% nạp đầu
                $referralBonusForUser = 0;    // +10% nếu có người giới thiệu
                $totalUserBonus = 0;

                if ($isFirstDeposit) {
                    $firstDepositBonus = (int) floor($amount * 0.10);

                    if (!empty($user->referred_by)) {
                        $referralBonusForUser = (int) floor($amount * 0.10);
                    }

                    $totalUserBonus = $firstDepositBonus + $referralBonusForUser;
                }

                $afterUserBalance = $beforeUserBalance + $amount + $totalUserBonus;

                // 1) Cộng tiền nạp + thưởng cho user nạp
                $user->update([
                    'balance' => $afterUserBalance,
                    'has_deposited' => true,
                ]);

                // 2) Cập nhật giao dịch nạp chính
                $transactionAdminNote = 'Admin đã duyệt giao dịch nạp tiền.';

                if ($isFirstDeposit) {
                    if ($referralBonusForUser > 0) {
                        $transactionAdminNote = 'Admin đã duyệt giao dịch nạp tiền. User được thưởng nạp đầu 10% và thêm 10% do có người giới thiệu.';
                    } else {
                        $transactionAdminNote = 'Admin đã duyệt giao dịch nạp tiền. User được thưởng nạp đầu 10%.';
                    }
                }

                $transaction->update([
                    'status' => 'success',
                    'balance_before' => $beforeUserBalance,
                    'balance_after' => $afterUserBalance,
                    'processed_at' => now(),
                    'approved_by' => Auth::id(),
                    'admin_note' => $transactionAdminNote,
                ]);

                // 3) Ghi lịch sử thưởng cho user nạp nếu có
                if ($totalUserBonus > 0) {
                    $bonusDescription = 'Thưởng nạp đầu 10%';

                    if ($referralBonusForUser > 0) {
                        $bonusDescription = 'Thưởng nạp đầu 10% + thêm 10% do có người giới thiệu';
                    }

                    WalletTransaction::create([
                        'user_id' => $user->id,
                        'transaction_code' => 'BONUS' . now()->format('YmdHis') . strtoupper(Str::random(4)),
                        'payment_code' => null,
                        'type' => 'promotion',
                        'amount' => $totalUserBonus,
                        'balance_before' => $beforeUserBalance + $amount,
                        'balance_after' => $afterUserBalance,
                        'payment_gateway' => null,
                        'bank_name' => null,
                        'bank_account_name' => null,
                        'bank_account_number' => null,
                        'transfer_content' => null,
                        'status' => 'success',
                        'description' => $bonusDescription,
                        'approved_by' => Auth::id(),
                        'requested_at' => now(),
                        'processed_at' => now(),
                        'admin_note' => $bonusDescription,
                    ]);
                }

                // =========================
                // THƯỞNG CHO NGƯỜI GIỚI THIỆU
                // =========================
                $referrerReward = 0;
                $referrer = null;

                if ($isFirstDeposit && !empty($user->referred_by)) {
                    $referrer = User::whereKey($user->referred_by)
                        ->lockForUpdate()
                        ->first();

                    if ($referrer) {
                        $referrerReward = (int) floor($amount * 0.10);

                        if ($referrerReward > 0) {
                            $beforeReferrerBalance = (int) $referrer->balance;
                            $afterReferrerBalance = $beforeReferrerBalance + $referrerReward;

                            $referrer->update([
                                'balance' => $afterReferrerBalance,
                            ]);

                            WalletTransaction::create([
                                'user_id' => $referrer->id,
                                'transaction_code' => 'REF' . now()->format('YmdHis') . strtoupper(Str::random(4)),
                                'payment_code' => null,
                                'type' => 'promotion',
                                'amount' => $referrerReward,
                                'balance_before' => $beforeReferrerBalance,
                                'balance_after' => $afterReferrerBalance,
                                'payment_gateway' => null,
                                'bank_name' => null,
                                'bank_account_name' => null,
                                'bank_account_number' => null,
                                'transfer_content' => null,
                                'status' => 'success',
                                'description' => 'Thưởng giới thiệu: ' . $user->name . ' nạp tiền lần đầu',
                                'approved_by' => Auth::id(),
                                'requested_at' => now(),
                                'processed_at' => now(),
                                'admin_note' => 'Người được giới thiệu nạp lần đầu thành công, thưởng 10%.',
                            ]);
                        }
                    }
                }

                // 4) Cập nhật notification nạp thành đã duyệt
                $notificationAdminNote = 'Đã duyệt biến động số dư và cộng tiền cho người dùng.';

                if ($isFirstDeposit) {
                    if ($referralBonusForUser > 0 && $referrerReward > 0) {
                        $notificationAdminNote = 'Đã duyệt biến động số dư, cộng tiền nạp cho user, thưởng user 20% (10% nạp đầu + 10% có người giới thiệu) và thưởng người giới thiệu 10%.';
                    } elseif ($referralBonusForUser > 0) {
                        $notificationAdminNote = 'Đã duyệt biến động số dư, cộng tiền nạp cho user và thưởng user 20% (10% nạp đầu + 10% có người giới thiệu).';
                    } else {
                        $notificationAdminNote = 'Đã duyệt biến động số dư, cộng tiền nạp và thưởng nạp đầu 10% cho user.';
                    }
                }

                $lockedNotification->update([
                    'match_status' => 'approved',
                    'handled_by' => Auth::id(),
                    'handled_at' => now(),
                    'admin_note' => $notificationAdminNote,
                ]);

                // =========================
                // GỬI NOTIFICATION
                // =========================

                // Gửi cho user nạp
                $user->notify(new DepositApprovedNotification($lockedNotification, $totalUserBonus));

                // Nếu có người giới thiệu thì gửi thêm cho người giới thiệu
                if ($referrer && $referrerReward > 0) {
                    $referrer->notify(new ReferralRewardReceivedNotification($user, $referrerReward));
                }
            });

            return redirect()->route('admin.wallet_notifications.index')
                ->with('success', 'Đã duyệt giao dịch và cộng tiền thành công.');
        } catch (\RuntimeException $e) {
            return redirect()->route('admin.wallet_notifications.index')
                ->with('error', $e->getMessage());
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('admin.wallet_notifications.index')
                ->with('error', 'Không thể duyệt giao dịch lúc này. Vui lòng thử lại.');
        }
    }

    //từ chối
    public function reject(Request $request, SystemWalletNotification $notification)
    {
        $request->validate([
            'admin_note' => ['required', 'string', 'max:1000'],
        ]);
        try {
            DB::transaction(function () use ($notification, $request) {
                $lockedNotification = SystemWalletNotification::whereKey($notification->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($lockedNotification->match_status === 'approved') {
                    throw new \RuntimeException('Thông báo này đã được duyệt, không thể từ chối.');
                }

                if ($lockedNotification->match_status === 'rejected') {
                    throw new \RuntimeException('Thông báo này đã bị từ chối trước đó.');
                }

                $transaction = null;

                if ($lockedNotification->wallet_transaction_id) {
                    $transaction = WalletTransaction::whereKey($lockedNotification->wallet_transaction_id)
                        ->lockForUpdate()
                        ->first();
                }

                if ($transaction) {
                    if ($transaction->type !== 'deposit') {
                        throw new \RuntimeException('Đây không phải giao dịch nạp tiền hợp lệ.');
                    }

                    if ($transaction->status === 'success') {
                        throw new \RuntimeException('Giao dịch này đã thành công, không thể từ chối.');
                    }

                    if ($transaction->status === 'failed') {
                        throw new \RuntimeException('Giao dịch này đã bị từ chối trước đó.');
                    }

                    if (!in_array($transaction->status, ['processing', 'pending'])) {
                        throw new \RuntimeException('Trạng thái giao dịch hiện tại không hợp lệ để từ chối.');
                    }

                    $transaction->update([
                        'status' => 'failed',
                        'processed_at' => now(),
                        'approved_by' => Auth::id(),
                        'admin_note' => $request->admin_note,
                    ]);
                }

                $lockedNotification->update([
                    'match_status' => 'rejected',
                    'handled_by' => Auth::id(),
                    'handled_at' => now(),
                    'admin_note' => $request->admin_note,
                ]);
            });

            return redirect()->route('admin.wallet_notifications.index')
                ->with('success', 'Đã từ chối giao dịch nạp tiền.');
        } catch (\RuntimeException $e) {
            return redirect()->route('admin.wallet_notifications.index')
                ->with('error', $e->getMessage());
        } catch (Throwable $e) {
            report($e);

            return redirect()->route('admin.wallet_notifications.index')
                ->with('error', 'Không thể từ chối giao dịch lúc này. Vui lòng thử lại.');
        }
    }
}