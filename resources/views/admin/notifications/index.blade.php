@extends('layouts.admin.app')

@section('content')
    <style>
        .notif-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 14px 20px;
            border-bottom: 1px solid #f0f0f0;
            text-decoration: none;
            color: inherit;
            transition: background .1s;
            position: relative;
        }

        .notif-item:last-child {
            border-bottom: none;
        }

        .notif-item:hover {
            background: #f8f9fc;
            text-decoration: none;
            color: inherit;
        }

        .notif-item.unread {
            background: #fff8f8;
        }

        .unread-dot {
            position: absolute;
            top: 18px;
            right: 16px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #e74a3b;
            flex-shrink: 0;
        }

        .notif-icon-wrap {
            flex-shrink: 0;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 2px;
        }

        .notif-body {
            flex: 1;
            min-width: 0;
            padding-right: 20px;
        }

        .notif-title {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .notif-item.unread .notif-title {
            color: #1a202c;
        }

        .notif-msg {
            font-size: 13px;
            color: #718096;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .notif-time {
            font-size: 11px;
            color: #a0aec0;
        }
    </style>

    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tất cả thông báo</h1>

            <form action="{{ route('admin.notifications.read_all') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-check-double fa-sm mr-1"></i> Đánh dấu tất cả đã đọc
                </button>
            </form>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Thông báo</h6>
                @php $unreadCount = $notifications->getCollection()->whereNull('read_at')->count(); @endphp
                @if($unreadCount > 0)
                    <span class="badge badge-danger">{{ $unreadCount }} chưa đọc</span>
                @endif
            </div>

            <div class="card-body p-0">
                @forelse($notifications as $notification)
                    @php $unread = is_null($notification->read_at); @endphp
                    <a href="{{ route('admin.notifications.read', $notification->id) }}"
                        class="notif-item {{ $unread ? 'unread' : '' }}">

                        <div class="notif-icon-wrap bg-{{ $notification->data['color'] ?? 'primary' }}">
                            <i class="{{ $notification->data['icon'] ?? 'fas fa-bell' }} text-white" style="font-size:15px"></i>
                        </div>

                        <div class="notif-body">
                            <div class="notif-title">{{ $notification->data['title'] ?? 'Thông báo' }}</div>
                            <div class="notif-msg">{{ $notification->data['message'] ?? '' }}</div>
                            <div class="notif-time">
                                <i class="fas fa-clock fa-xs mr-1"></i>
                                {{ $notification->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        @if($unread)
                            <span class="unread-dot" title="Chưa đọc"></span>
                        @endif
                    </a>
                @empty
                    <div class="p-5 text-center text-muted">
                        <i class="fas fa-bell-slash fa-2x mb-3 d-block text-gray-300"></i>
                        Không có thông báo nào
                    </div>
                @endforelse
            </div>

            <div class="card-footer bg-white">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
@endsection