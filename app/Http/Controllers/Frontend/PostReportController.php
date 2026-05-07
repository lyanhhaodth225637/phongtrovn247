<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostReport;
use App\Models\User;
use App\Notifications\PostOwnerReportedNotification;
use App\Notifications\PostReportedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PostReportController extends Controller
{
    public function store(Request $request, $id): RedirectResponse
    {
        $post = Post::with('user')->findOrFail($id);

        if (!auth()->check()) {
            return back()->with('error', 'Bạn cần đăng nhập để tố cáo bài viết.');
        }

        if ($post->user_id === auth()->id()) {
            return back()->with('error', 'Bạn không thể tố cáo bài viết của chính mình.');
        }

        if ($post->status !== 'approved' || !$post->is_visible_admin || !$post->is_visible_owner) {
            return back()->with('error', 'Bài viết này hiện không thể tố cáo.');
        }

        $data = $request->validate([
            'reason_type' => 'required|in:spam,scam,false_info,duplicate,inappropriate,wrong_price,other',
            'reason_detail' => 'nullable|string|max:1000',
        ], [
            'reason_type.required' => 'Vui lòng chọn lý do tố cáo.',
            'reason_type.in' => 'Lý do tố cáo không hợp lệ.',
            'reason_detail.max' => 'Nội dung tố cáo tối đa 1000 ký tự.',
        ]);

        $existsPending = PostReport::where('post_id', $post->id)
            ->where('reporter_id', auth()->id())
            ->where('status', 'pending')
            ->exists();

        if ($existsPending) {
            return back()->with('error', 'Bạn đã gửi tố cáo cho bài viết này và đang chờ xử lý.');
        }

        $report = PostReport::create([
            'post_id' => $post->id,
            'reporter_id' => auth()->id(),
            'reason_type' => $data['reason_type'],
            'reason_detail' => $data['reason_detail'] ?? null,
            'status' => 'pending',
        ]);

        $report->load(['post', 'reporter']);

        // Gửi cho admin: có đầy đủ thông tin để xử lý
        $admins = User::role('admin')->get();
        Notification::send($admins, new PostReportedNotification($report));

        // Gửi cho chủ bài đăng: không lộ người tố cáo
        if ($post->user) {
            $post->user->notify(new PostOwnerReportedNotification($report));
        }

        return back()->with('success', 'Đã gửi tố cáo. Quản trị viên sẽ xem xét bài viết này.');
    }
}