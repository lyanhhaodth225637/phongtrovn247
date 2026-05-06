<?php

namespace App\Notifications;

use App\Models\PostReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostOwnerReportedNotification extends Notification
{
    use Queueable;
    //thông báo tố cáo cho chủ
    public function __construct(public PostReport $report)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Bài đăng của bạn vừa bị tố cáo',
            'message' => 'Một bài đăng của bạn vừa bị phản ánh và đang được quản trị viên xem xét.',
            'post_id' => $this->report->post_id,
            'url' => route('frontend.post.show', [
                'id' => $this->report->post->id,
                'slug' => $this->report->post->slug,
            ]),
        ];
    }
}