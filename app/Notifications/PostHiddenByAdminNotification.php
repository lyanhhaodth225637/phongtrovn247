<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostHiddenByAdminNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Tin đăng đã bị ẩn',
            'message' => 'Một tin đăng của bạn đã bị quản trị viên ẩn.',
            'icon' => 'bi bi-exclamation-triangle-fill text-warning',
            'url' => route('user.post.index'),
        ];
    }
}