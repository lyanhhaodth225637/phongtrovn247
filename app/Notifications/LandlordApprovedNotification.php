<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LandlordApprovedNotification extends Notification
{
    use Queueable;

    public function __construct(public $user)
    {
    }
    //gửi thông báo khi user đã được duyệt landlord
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {

        return [
            'title' => 'Tài khoản của bạn đã được duyệt',
            'message' => 'Xin chúc mừng, tài khoản của bạn ' . $this->user->name . ' vừa được phê duyệt. Hãy góp phần cho cộng động PhongTroVN247 phát triễn',
            'user_id' => $this->user->id,
            'url' => route('verify.auth_landlord'),
            'icon' => 'fas fa-user-check',
            'color' => 'success',
        ];

    }
}