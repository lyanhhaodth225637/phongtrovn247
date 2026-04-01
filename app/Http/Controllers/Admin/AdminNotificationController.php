<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->paginate(15);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function read($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return redirect($notification->data['url'] ?? route('admin.notifications.index'));
    }

    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Đã đánh dấu tất cả thông báo là đã đọc.');
    }
}