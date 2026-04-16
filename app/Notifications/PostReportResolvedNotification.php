<?php

namespace App\Notifications;

use App\Models\PostReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostReportResolvedNotification extends Notification
{
    use Queueable;
    //gửi tb về chủ khi bị khóa bài
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
            'title' => 'Bài đăng của bạn đã bị ẩn',
            'message' => 'Bài đăng của bạn đã bị ẩn sau khi quản trị viên xác nhận tố cáo hợp lệ.',
            'post_id' => $this->report->post_id,
            'report_id' => $this->report->id,
            'url' => route('user.post.index'),
        ];
    }
}