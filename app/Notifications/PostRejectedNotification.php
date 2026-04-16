<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostRejectedNotification extends Notification
{
    use Queueable;

    protected $post;
    protected $reasonType;
    protected $reasonDetail;

    public function __construct(Post $post, string $reasonType, ?string $reasonDetail = null)
    {
        $this->post = $post;
        $this->reasonType = $reasonType;
        $this->reasonDetail = $reasonDetail;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $reasonMap = [
            'spam' => 'Nội dung spam',
            'scam' => 'Nội dung lừa đảo',
            'false_info' => 'Thông tin không chính xác',
            'duplicate' => 'Bài đăng trùng lặp',
            'other' => 'Lý do khác',
        ];

        return [
            'title' => 'Bài đăng bị từ chối',
            'message' => 'Bài đăng "' . $this->post->title . '" đã bị từ chối.',
            'reason_type' => $this->reasonType,
            'reason_text' => $reasonMap[$this->reasonType] ?? $this->reasonType,
            'reason_detail' => $this->reasonDetail,
            'post_id' => $this->post->id,
            'type' => 'post_rejected',
            'url' => route('user.post.create', [
                'id' => $this->post->id,
                'slug' => $this->post->slug
            ]),
        ];
    }
}