<?php

namespace App\Notifications;

use App\Models\SystemWalletNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DepositApprovedNotification extends Notification
{
    use Queueable;
    //thông báo duyệt nạp thành công
    public function __construct(
        public SystemWalletNotification $walletNotification,
        public int $bonusAmount = 0
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $message = 'Bạn đã nạp ' . number_format($this->walletNotification->amount) . 'VNĐ thành công.';

        if ($this->bonusAmount > 0) {
            $message .= ' Nạp đầu thưởng 10% giá trị. ' . number_format($this->bonusAmount, 0, ',', '.') . 'VNĐ ';
        }

        return [
            'title' => 'Nạp tiền thành công',
            'message' => $message,
            'url' => route('user.wallet.index'),
            'icon' => 'bi bi-check-circle-fill',
            'color' => 'success',
        ];
    }
}