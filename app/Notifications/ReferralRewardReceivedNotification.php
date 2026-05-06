<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReferralRewardReceivedNotification extends Notification
{
    use Queueable;
    //thông báo km giới thiệu
    public function __construct(
        public User $referredUser,
        public int $rewardAmount
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Thưởng giới thiệu',
            'message' => 'Bạn nhận được ' . number_format($this->rewardAmount, 0, ',', '.') . 'VNĐ từ mã giới thiệu' .
                $this->referredUser->name . ' đã nạp tiền lần đầu thành công.',
            'url' => route('user.wallet.index'),
            'icon' => 'bi bi-gift-fill',
            'color' => 'success',
        ];
    }
}