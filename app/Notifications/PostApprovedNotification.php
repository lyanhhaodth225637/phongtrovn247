<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostApprovedNotification extends Notification
{
    use Queueable;

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Bài đăng đã được duyệt',
            'message' => 'Bài đăng "' . $this->post->title . '" của bạn đã được duyệt và đang hiển thị trên hệ thống.',
            'post_id' => $this->post->id,
            'type' => 'post_approved',
            'url' => route('frontend.post.show', [
                'id' => $this->post->id,
                'slug' => $this->post->slug
            ]),
        ];
    }
}