@extends('layouts.user.app')

@php
    $postSource = $posts ?? collect();
    $postItems = $postSource instanceof \Illuminate\Contracts\Pagination\Paginator
        ? collect($postSource->items())
        : collect($postSource);

    $activeStatus = request('status', 'all');
    $keyword = trim((string) request('q', ''));

    $defaultStats = [
        'all' => $postItems->count(),
        'approved' => $postItems->where('status', 'approved')->count(),
        'pending' => $postItems->where('status', 'pending')->count(),
        'rejected' => $postItems->where('status', 'rejected')->count(),
        'hidden' => $postItems->where('is_visible_owner', 0)->count(),
    ];

    $stats = array_merge($defaultStats, $stats ?? []);

    $tabs = [
        'all' => ['label' => 'Tất cả', 'icon' => 'bi-grid-1x2'],
        'approved' => ['label' => 'Đã duyệt', 'icon' => 'bi-patch-check'],
        'pending' => ['label' => 'Chờ duyệt', 'icon' => 'bi-hourglass-split'],
        'rejected' => ['label' => 'Từ chối', 'icon' => 'bi-x-octagon'],
        'hidden' => ['label' => 'Đang ẩn', 'icon' => 'bi-eye-slash'],
    ];

    $statusMap = [
        'approved' => ['class' => 'status-active', 'label' => 'Đã duyệt', 'icon' => 'bi-check-circle-fill'],
        'pending' => ['class' => 'status-pending', 'label' => 'Chờ duyệt', 'icon' => 'bi-hourglass-split'],
        'rejected' => ['class' => 'status-expired', 'label' => 'Từ chối', 'icon' => 'bi-slash-circle-fill'],
    ];
@endphp

@section('content')
    <div class="qltd-page-head">
        <div>
            <h1 class="qltd-page-title">
                <span class="accent-line"></span>
                Quản lý tin đăng
            </h1>
            <div class="text-muted" style="font-size:.8rem">
                Theo dõi trạng thái duyệt, thời hạn hiển thị và thao tác nhanh với bài đăng của bạn.
            </div>
        </div>

        @if (Route::has('user.post.create'))
            <a href="{{ route('user.post.create') }}" class="btn-new-post">
                <i class="bi bi-plus-circle-fill"></i>
                Đăng tin mới
            </a>
        @endif
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-4 col-sm-6">
            <div class="post-summary-box">
                <div class="post-summary-icon"><i class="bi bi-file-earmark-text"></i></div>
                <div>
                    <div class="post-summary-label">Tổng số tin</div>
                    <div class="post-summary-value">{{ number_format($stats['all'] ?? 0) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="post-summary-box">
                <div class="post-summary-icon success"><i class="bi bi-patch-check-fill"></i></div>
                <div>
                    <div class="post-summary-label">Tin đã duyệt</div>
                    <div class="post-summary-value">{{ number_format($stats['approved'] ?? 0) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="post-summary-box">
                <div class="post-summary-icon warning"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <div class="post-summary-label">Tin chờ xử lý</div>
                    <div class="post-summary-value">{{ number_format(($stats['pending'] ?? 0) + ($stats['rejected'] ?? 0)) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="qltd-tabs">
        @foreach ($tabs as $key => $tab)
            <a
                href="{{ request()->fullUrlWithQuery(['status' => $key, 'page' => null]) }}"
                class="qltd-tab {{ $activeStatus === $key ? 'active' : '' }}"
            >
                <i class="bi {{ $tab['icon'] }}"></i>
                {{ $tab['label'] }}
                <span class="tab-count">{{ $stats[$key] ?? 0 }}</span>
            </a>
        @endforeach
    </div>

    <form method="GET" class="qltd-search-row">
        <input type="hidden" name="status" value="{{ $activeStatus }}">
        <div class="qltd-search-wrap">
            <i class="bi bi-search"></i>
            <input
                type="text"
                name="q"
                value="{{ $keyword }}"
                class="qltd-search-input"
                placeholder="Tìm theo tiêu đề, địa chỉ hoặc mã tin..."
            >
        </div>
        <button type="submit" class="btn-new-post">
            <i class="bi bi-funnel"></i>
            Lọc
        </button>
    </form>

    @include('components.alert')

    @if ($postItems->isEmpty())
        <div class="qltd-empty">
            <div class="qltd-empty-icon">
                <i class="bi bi-megaphone"></i>
            </div>
            <div class="qltd-empty-title">Chưa có bài đăng phù hợp</div>
            <div class="qltd-empty-sub">
                @if ($keyword !== '' || $activeStatus !== 'all')
                    Không tìm thấy tin đăng theo bộ lọc hiện tại. Hãy đổi từ khóa hoặc chuyển sang trạng thái khác.
                @else
                    Bạn chưa có tin đăng nào. Tạo bài đầu tiên để bắt đầu tiếp cận người thuê.
                @endif
            </div>

            @if (Route::has('user.post.create'))
                <a href="{{ route('user.post.create') }}" class="btn-new-post">
                    <i class="bi bi-plus-circle-fill"></i>
                    Đăng tin ngay
                </a>
            @endif
        </div>
    @else
        @foreach ($postItems as $post)
            @php
                $isHidden = (int) ($post->is_visible_owner ?? 1) === 0;
                $displayStatus = $isHidden ? 'hidden' : ($post->status ?? 'pending');
                $badge = $displayStatus === 'hidden'
                    ? ['class' => 'status-hidden', 'label' => 'Đang ẩn', 'icon' => 'bi-eye-slash-fill']
                    : ($statusMap[$displayStatus] ?? $statusMap['pending']);

                $imagePath = optional($post->images->sortBy('sort_order')->first())->image;
                $imageUrl = $imagePath ? asset('storage/' . $imagePath) : 'https://placehold.co/320x240/e2e8f0/475569?text=PhongTroVN247';

                $wardName = data_get($post, 'ward.name');
                $provinceName = data_get($post, 'ward.province.name');
                $postAddress = $post->address ?: collect([$wardName, $provinceName])->filter()->implode(', ');

                $detailUrl = '#';
                if (Route::has('frontend.post.show') && !empty($post->slug)) {
                    $detailUrl = route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]);
                }
            @endphp

            <article class="post-manage-card">
                <div class="post-manage-img">
                    <img src="{{ $imageUrl }}" alt="{{ $post->title }}">
                </div>

                <div class="post-manage-body">
                    <a href="{{ $detailUrl }}" class="post-manage-title">
                        {{ $post->title }}
                    </a>

                    <div class="post-manage-meta">
                        <span class="post-manage-price">
                            {{ number_format((float) ($post->price ?? 0)) }}đ/tháng
                        </span>
                        <span class="post-status-badge {{ $badge['class'] }}">
                            <i class="bi {{ $badge['icon'] }}"></i>
                            {{ $badge['label'] }}
                        </span>
                        @if ($post->category)
                            <span class="post-status-badge status-hidden">
                                <i class="bi bi-tag"></i>
                                {{ $post->category->name }}
                            </span>
                        @endif
                    </div>

                    <div class="post-manage-info">
                        @if ($postAddress)
                            <span><i class="bi bi-geo-alt"></i> {{ $postAddress }}</span>
                        @endif
                        @if (!empty($post->area))
                            <span><i class="bi bi-aspect-ratio"></i> {{ rtrim(rtrim(number_format((float) $post->area, 2), '0'), '.') }} m²</span>
                        @endif
                        <span><i class="bi bi-calendar3"></i> {{ optional($post->created_at)->format('d/m/Y') }}</span>
                        <span><i class="bi bi-clock-history"></i> Hết hạn: {{ optional($post->expires_at)->format('d/m/Y') ?? 'Chưa cập nhật' }}</span>
                    </div>

                    <div class="post-manage-actions">
                        <a href="{{ $detailUrl }}" class="btn-manage">
                            <i class="bi bi-eye"></i>
                            Xem tin
                        </a>

                        @if (Route::has('user.post.create'))
                            <a href="{{ route('user.post.create') }}" class="btn-manage">
                                <i class="bi bi-pencil"></i>
                                Sửa
                            </a>
                        @endif

                        <button type="button" class="btn-manage success">
                            <i class="bi bi-arrow-repeat"></i>
                            Gia hạn
                        </button>

                        <button type="button" class="btn-manage {{ $isHidden ? '' : 'danger' }}">
                            <i class="bi {{ $isHidden ? 'bi-eye' : 'bi-eye-slash' }}"></i>
                            {{ $isHidden ? 'Hiện tin' : 'Ẩn tin' }}
                        </button>
                    </div>
                </div>
            </article>

            @if (($post->status ?? null) === 'rejected')
                <div class="post-expire-bar">
                    <i class="bi bi-exclamation-triangle-fill" style="color:#dc2626"></i>
                    Tin này đã bị từ chối. Hãy kiểm tra lại nội dung, hình ảnh và thông tin liên hệ trước khi đăng lại.
                </div>
            @endif
        @endforeach

        @if ($postSource instanceof \Illuminate\Contracts\Pagination\Paginator)
            <div class="d-flex justify-content-center mt-4">
                {{ $postSource->appends(request()->query())->links() }}
            </div>
        @endif
    @endif
@endsection

@push('styles')
    <style>
        .post-summary-box {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            padding: 16px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            height: 100%;
        }

        .post-summary-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: var(--primary-light);
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .post-summary-icon.success {
            background: #ecfdf3;
            color: #15803d;
        }

        .post-summary-icon.warning {
            background: #fff7ed;
            color: #c2410c;
        }

        .post-summary-label {
            font-size: .74rem;
            color: var(--muted);
            margin-bottom: 2px;
        }

        .post-summary-value {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1.2;
        }
    </style>
@endpush
