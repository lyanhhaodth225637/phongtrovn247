<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewPostPendingApprovalNotification extends Notification
{
    use Queueable;

    public $post;

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
            'title' => 'Có bài đăng mới chờ duyệt',
            'message' => $this->post->user->name . ' vừa đăng bài "' . $this->post->title . '"',
            'post_id' => $this->post->id,
            'url' => route('admin.post.show', [
                'id' => $this->post->id,
                'slug' => $this->post->slug
            ]),
            'type' => 'post_pending',
        ];
    }
}