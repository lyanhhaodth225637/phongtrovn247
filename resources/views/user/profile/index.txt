@extends('layouts.user.app')

@section('content')
    {{-- Page head --}}
    <div class="qltd-page-head">
        <h1 class="qltd-page-title">
            <span class="accent-line"></span>
            Danh sách tin đăng
        </h1>
        <a href="#" class="btn-new-post">
            <i class="bi bi-plus-circle-fill"></i> Đăng tin mới
        </a>
    </div>

    {{-- Status tabs --}}
    <div class="qltd-tabs">
        <button class="qltd-tab active" data-tab="all">
            Tất cả <span class="tab-count"></span>
        </button>
        <button class="qltd-tab" data-tab="active">
            Đang hiển thị <span class="tab-count"></span>
        </button>
        <button class="qltd-tab" data-tab="expired">
            Hết hạn <span class="tab-count"></span>
        </button>
        <button class="qltd-tab" data-tab="hidden">
            Tin ẩn <span class="tab-count"></span>
        </button>
        <button class="qltd-tab" data-tab="pending">
            Chờ duyệt <span class="tab-count"></span>
        </button>
    </div>

    {{-- Search bar --}}
    <div class="qltd-search-row">
        <div class="qltd-search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" class="qltd-search-input" id="postSearch" placeholder="Tìm theo mã tin hoặc tiêu đề…">
        </div>
    </div>
    {{-- ── Post list ── --}}
    @if(isset($posts) && $posts->count() > 0)
        @foreach($posts as $post)
            <div class="post-manage-card">
                <div class="post-manage-img">
                    <img src="{{ $post->thumbnail ?? 'https://placehold.co/140x110/e8f0fe/0d6efd?text=No+Image' }}"
                        alt="{{ $post->title }}">
                    {{-- VIP badge --}}
                    @if($post->vip_level > 0)
                        <span class="hot-tag">VIP {{ $post->vip_level }}</span>
                    @endif
                </div>
                <div class="post-manage-body">
                    <a href="#" class="post-manage-title">{{ $post->title }}</a>
                    <div class="post-manage-meta">
                        <span class="post-manage-price">{{ number_format($post->price) }}đ/tháng</span>
                        @php
                            $statusMap = [
                                'active' => ['class' => 'status-active', 'icon' => 'bi-check-circle-fill', 'label' => 'Đang hiển thị'],
                                'expired' => ['class' => 'status-expired', 'icon' => 'bi-clock-fill', 'label' => 'Hết hạn'],
                                'hidden' => ['class' => 'status-hidden', 'icon' => 'bi-eye-slash-fill', 'label' => 'Đang ẩn'],
                                'pending' => ['class' => 'status-pending', 'icon' => 'bi-hourglass-split', 'label' => 'Chờ duyệt'],
                            ];
                            $s = $statusMap[$post->status] ?? $statusMap['hidden'];
                        @endphp
                        <span class="post-status-badge {{ $s['class'] }}">
                            <i class="bi {{ $s['icon'] }}"></i> {{ $s['label'] }}
                        </span>
                    </div>
                    <div class="post-manage-info">
                        <span><i class="bi bi-geo-alt"></i> {{ $post->district }}, {{ $post->province }}</span>
                        <span><i class="bi bi-calendar3"></i> {{ $post->created_at->format('d/m/Y') }}</span>
                        <span><i class="bi bi-alarm"></i> Hết hạn:
                            {{ $post->expired_at?->format('d/m/Y') ?? '—' }}</span>
                        <span><i class="bi bi-eye"></i> {{ number_format($post->views ?? 0) }} lượt xem</span>
                    </div>
                    <div class="post-manage-actions">
                        <a href="#" class="btn-manage"><i class="bi bi-pencil"></i> Sửa tin</a>
                        <a href="#" class="btn-manage success"><i class="bi bi-arrow-repeat"></i> Gia hạn</a>
                        <a href="#" class="btn-manage"><i class="bi bi-rocket-takeoff"></i> Đẩy tin</a>
                        @if($post->status === 'active')
                            <a href="#" class="btn-manage"><i class="bi bi-eye-slash"></i> Ẩn</a>
                        @else
                            <a href="#" class="btn-manage"><i class="bi bi-eye"></i> Hiện</a>
                        @endif
                        <a href="#" class="btn-manage danger"><i class="bi bi-trash3"></i> Xóa</a>
                    </div>
                </div>
            </div>
            @if($post->status === 'expired')
                <div class="post-expire-bar">
                    <i class="bi bi-exclamation-triangle-fill" style="color:#d97706"></i>
                    Tin đã hết hạn — Gia hạn ngay để tiếp tục hiển thị và thu hút người thuê.
                    <a href="#" style="color:#0d6efd;font-weight:700;margin-left:4px">Gia hạn</a>
                </div>
            @endif
        @endforeach

        {{-- Pagination --}}
        <div class="d-flex justify-content-center align-items-center gap-1 mt-4 flex-wrap">
            {{ $posts->links() }}
        </div>

    @else
        {{-- Empty state --}}
        <div class="qltd-empty">
            <div class="qltd-empty-icon">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div class="qltd-empty-title">Bạn chưa có tin đăng nào</div>
            <div class="qltd-empty-sub">
                Hãy đăng tin ngay để cho thuê phòng trọ, nhà nguyên căn<br>
                hoặc căn hộ của bạn nhanh chóng và hiệu quả.
            </div>
            <a href="#" class="btn-new-post" style="display:inline-flex">
                <i class="bi bi-plus-circle-fill"></i> Đăng tin đầu tiên
            </a>
        </div>
    @endif
@endsection