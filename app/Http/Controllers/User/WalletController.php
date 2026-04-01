<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SystemWallet;
use App\Models\SystemWalletNotification;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class WalletController extends Controller
{
    public function index()
    {
        // $transactions = WalletTransaction::where('user_id', Auth::id())
        //     ->latest()
        //     ->paginate(10);

        return view('user.wallet.index');
    }

    // public function createDeposit()
    // {
    //     // Chặn vào form nạp nếu đã có giao dịch nạp chưa hoàn tất
    //     $hasOpenDeposit = WalletTransaction::where('user_id', Auth::id())
    //         ->where('type', 'deposit')
    //         ->whereIn('status', ['pending', 'processing'])
    //         ->exists();

    //     if ($hasOpenDeposit) {
    //         return redirect()->route('user.wallet.index')
    //             ->with('error', 'Bạn đang có một giao dịch nạp tiền chưa hoàn tất. Chỉ có thể nạp tiếp khi giao dịch trước đã được duyệt hoặc bị từ chối.');
    //     }

    //     return view('user.wallet.deposit');
    // }

    public function storeDeposit(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'integer', 'min:10000'],
        ]);

        try {
            $user = Auth::user();

            $transaction = DB::transaction(function () use ($request, $user) {
                // Khóa user transactions để tránh spam submit tạo nhiều giao dịch
                $hasOpenDeposit = SystemWalletNotification::whereHas('walletTransaction', function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->where('type', 'deposit');
                })
                    ->whereIn('match_status', ['unmatched', 'matched'])
                    ->lockForUpdate()
                    ->exists();

                if ($hasOpenDeposit) {
                    throw ValidationException::withMessages([
                        'amount' => 'Bạn đang có giao dịch nạp tiền chưa được duyệt. Vui lòng chờ hệ thống xử lý.',
                    ]);
                }

                if ($hasOpenDeposit) {
                    throw new \RuntimeException('Bạn đang có một giao dịch nạp tiền chưa hoàn tất. Chỉ có thể nạp tiếp khi giao dịch trước đã được duyệt hoặc bị từ chối.');
                }

                $systemWallet = SystemWallet::where('is_active', true)
                    ->lockForUpdate()
                    ->first();

                if (!$systemWallet) {
                    throw new \RuntimeException('Hiện chưa có ví hệ thống hoạt động.');
                }

                return WalletTransaction::create([
                    'user_id' => $user->id,
                    'transaction_code' => 'NAP' . now()->format('YmdHis') . strtoupper(Str::random(4)),
                    'payment_code' => null,
                    'type' => 'deposit',
                    'amount' => (int) $request->amount,
                    'balance_before' => (int) $user->balance,
                    'balance_after' => (int) $user->balance,
                    'payment_gateway' => 'bank_transfer',
                    'bank_name' => $systemWallet->bank_name,
                    'bank_account_name' => $systemWallet->account_name,
                    'bank_account_number' => $systemWallet->account_number,
                    'transfer_content' => 'NAPTIEN-' . $user->id . '-' . strtoupper(Str::random(6)),
                    'status' => 'pending',
                    'description' => 'Tạo yêu cầu nạp tiền, chờ xác nhận tại ngân hàng giả lập',
                    'requested_at' => now(),
                    'processed_at' => null,
                    'admin_note' => null,
                ]);
            });

            return redirect()->route('user.wallet.fake.bank', $transaction->id);
        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        } catch (Throwable $e) {
            report($e);

            return back()->withInput()->with('error', 'Không thể tạo yêu cầu nạp tiền lúc này. Vui lòng thử lại.');
        }
    }

    public function fakeBank(WalletTransaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        if ($transaction->type !== 'deposit') {
            abort(404);
        }

        // Chỉ cho vào fake bank khi giao dịch còn chờ xác nhận
        if ($transaction->status !== 'pending') {
            return redirect()->route('user.wallet.index')
                ->with('error', 'Giao dịch này không còn ở trạng thái chờ xác nhận.');
        }

        return view('user.wallet.fake-bank', compact('transaction'));
    }

    public function confirmTransfer(WalletTransaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        if ($transaction->type !== 'deposit') {
            abort(404);
        }

        try {
            DB::transaction(function () use ($transaction) {
                // Khóa lại transaction để chống bấm 2 lần
                $lockedTransaction = WalletTransaction::whereKey($transaction->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($lockedTransaction->status !== 'pending') {
                    throw new \RuntimeException('Giao dịch này không hợp lệ hoặc đã được xử lý.');
                }

                $systemWallet = SystemWallet::where('is_active', true)
                    ->lockForUpdate()
                    ->first();

                if (!$systemWallet) {
                    throw new \RuntimeException('Hiện chưa có ví hệ thống hoạt động.');
                }

                // Chống tạo notification trùng nếu có lỗi submit lặp
                $existingNotification = SystemWalletNotification::where('wallet_transaction_id', $lockedTransaction->id)
                    ->lockForUpdate()
                    ->first();

                if ($existingNotification) {
                    throw new \RuntimeException('Giao dịch này đã được ghi nhận trước đó và đang chờ admin kiểm duyệt.');
                }

                $beforeSystemBalance = (int) $systemWallet->balance;
                $amount = (int) $lockedTransaction->amount;
                $afterSystemBalance = $beforeSystemBalance + $amount;

                // 1) Cộng tiền vào ví hệ thống tại fake bank
                $systemWallet->update([
                    'balance' => $afterSystemBalance,
                ]);

                // 2) Tạo biến động số dư để admin kiểm duyệt
                SystemWalletNotification::create([
                    'system_wallet_id' => $systemWallet->id,
                    'wallet_transaction_id' => $lockedTransaction->id,
                    'sender_name' => Auth::user()->name,
                    'sender_account_number' => null,
                    'receiver_account_number' => $systemWallet->account_number,
                    'bank_name' => $systemWallet->bank_name,
                    'amount' => $amount,
                    'transfer_content' => $lockedTransaction->transfer_content,
                    'raw_message' => 'FakeBank: +' . number_format($amount, 0, ',', '.') .
                        ' VND | Ví hệ thống: ' . number_format($beforeSystemBalance, 0, ',', '.') .
                        ' -> ' . number_format($afterSystemBalance, 0, ',', '.') .
                        ' | ND: ' . $lockedTransaction->transfer_content,
                    'match_status' => 'matched',
                    'notified_at' => now(),
                    'handled_at' => null,
                    'admin_note' => null,
                ]);

                // 3) Đánh dấu giao dịch user đang chờ admin duyệt
                $lockedTransaction->update([
                    'status' => 'processing',
                    'description' => 'Đã xác nhận nạp tại ngân hàng giả lập, chờ admin duyệt',
                    'processed_at' => null,
                ]);
            });

            return redirect()->route('user.wallet.index')
                ->with('success', 'Đã ghi nhận nạp tiền vào ví hệ thống. Vui lòng chờ admin kiểm duyệt.');
        } catch (\RuntimeException $e) {
            return redirect()->route('user.wallet.index')
                ->with('error', $e->getMessage());
        } catch (Throwable $e) {
            report($e);

            return redirect()->route('user.wallet.index')
                ->with('error', 'Không thể xác nhận giao dịch lúc này. Vui lòng thử lại.');
        }
    }

    public function cancelDeposit(WalletTransaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        if ($transaction->type !== 'deposit') {
            abort(404);
        }

        try {
            DB::transaction(function () use ($transaction) {
                $lockedTransaction = WalletTransaction::whereKey($transaction->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($lockedTransaction->status === 'processing') {
                    throw new \RuntimeException('Giao dịch đã được gửi chờ admin kiểm duyệt, không thể hủy.');
                }

                if ($lockedTransaction->status !== 'pending') {
                    throw new \RuntimeException('Không thể hủy giao dịch này.');
                }

                $lockedTransaction->update([
                    'status' => 'cancelled',
                    'processed_at' => now(),
                    'admin_note' => 'Người dùng hủy giao dịch nạp tiền trước khi xác nhận ở fake bank',
                ]);
            });

            return redirect()->route('user.wallet.index')
                ->with('success', 'Đã hủy giao dịch nạp tiền.');
        } catch (\RuntimeException $e) {
            return redirect()->route('user.wallet.index')
                ->with('error', $e->getMessage());
        } catch (Throwable $e) {
            report($e);

            return redirect()->route('user.wallet.index')
                ->with('error', 'Không thể hủy giao dịch lúc này. Vui lòng thử lại.');
        }
    }


    public function depositHistory()
    {
        $transactions = WalletTransaction::where('user_id', Auth::id())
            ->whereIn('type', ['deposit', 'promotion'])
            ->latest()
            ->paginate(10);

        return view('user.wallet.history', compact('transactions'));
    }
}