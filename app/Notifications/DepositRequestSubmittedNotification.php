<?php

namespace App\Notifications;

use App\Models\SystemWalletNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DepositRequestSubmittedNotification extends Notification
{
    use Queueable;
    //gởi yêu cầu nạp về admin
    public function __construct(public SystemWalletNotification $walletNotification)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Yêu cầu nạp mới',
            'message' => ($this->walletNotification->sender_name ?? 'Người dùng') .
                ' vừa gửi yêu cầu nạp ' .
                number_format($this->walletNotification->amount, 0, ',', '.') . 'đ.',
            'url' => route('admin.wallet_notifications.show', $this->walletNotification->id),
            'icon' => 'bi bi-wallet2',
            'color' => 'info',
        ];
    }
}