<?php

namespace App\Notifications;

use App\Models\PostReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostReportedNotification extends Notification
{
    use Queueable;

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
            'title' => 'Có tố cáo bài viết mới',
            'message' => 'Bài viết "' . $this->report->post->title . '" vừa bị người dùng tố cáo.',
            'post_id' => $this->report->post_id,
            'report_id' => $this->report->id,
            'reporter_id' => $this->report->reporter_id,
            'reason_type' => $this->report->reason_type,
            'url' => route('admin.post_reports.show', $this->report->id),
        ];
    }
}