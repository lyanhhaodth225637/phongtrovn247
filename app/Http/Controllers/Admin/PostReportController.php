<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostReportController extends Controller
{
    public function index(Request $request): View
    {
        $query = PostReport::with(['post.user', 'reporter', 'handler'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->paginate(15)->withQueryString();

        return view('admin.post_reports.index', compact('reports'));
    }

    public function show($id): View
    {
        $report = PostReport::with(['post.images', 'post.user', 'reporter', 'handler'])
            ->findOrFail($id);

        return view('admin.post_reports.show', compact('report'));
    }

    public function resolve(Request $request, $id): RedirectResponse
    {
        $data = $request->validate([
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $report = PostReport::with('post.user')->findOrFail($id);

        // Nếu report đã xử lý rồi thì không xử lý lại
        if ($report->status !== 'pending') {
            return redirect()
                ->route('admin.post_reports.show', $report->id)
                ->with('error', 'Tố cáo này đã được xử lý trước đó.');
        }

        // Cập nhật trạng thái report
        $report->update([
            'status' => 'resolved',
            'handled_by' => auth()->id(),
            'handled_at' => now(),
            'admin_note' => $data['admin_note'] ?? null,
        ]);

        // Ẩn bài viết
        if ($report->post) {
            $report->post->update([
                'is_visible_admin' => false,
            ]);
        }

        // Gửi thông báo cho chủ bài đăng
        if ($report->post && $report->post->user) {
            $report->post->user->notify(
                new \App\Notifications\PostReportResolvedNotification($report)
            );
        }

        return redirect()
            ->route('admin.post_reports.show', $report->id)
            ->with('success', 'Đã xác nhận tố cáo hợp lệ, bài viết đã bị ẩn.');
    }

    public function reject(Request $request, $id): RedirectResponse
    {
        $data = $request->validate([
            'admin_note' => 'nullable|string|max:1000',
        ]);

        $report = PostReport::findOrFail($id);

        $report->update([
            'status' => 'rejected',
            'handled_by' => auth()->id(),
            'handled_at' => now(),
            'admin_note' => $data['admin_note'] ?? null,
        ]);

        return redirect()
            ->route('admin.post_reports.show', $report->id)
            ->with('success', 'Đã từ chối tố cáo này.');
    }
}