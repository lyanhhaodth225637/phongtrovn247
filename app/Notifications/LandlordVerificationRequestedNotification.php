<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LandlordVerificationRequestedNotification extends Notification
{
    use Queueable;
    //thông báo về admin khu yêu cầu quyền landlord
    public function __construct(public User $user)
    {

    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Đăng ký chủ cho thuê',
            'message' => 'Người dùng ' . $this->user->name . ' vừa xác thực email và xin quyền chủ cho thuê.',
            'user_id' => $this->user->id,
            'url' => route('admin.approve_landlord.index'),
            'icon' => 'fas fa-user-check',
            'color' => 'warning',
            'type' => 'landlord_verification_requested',
        ];
    }
}