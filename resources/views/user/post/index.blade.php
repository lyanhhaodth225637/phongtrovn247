@extends('layouts.user.app')

@push('styles')
<style>
    .accent-line {
        display: inline-block;
        width: 4px;
        height: 22px;
        background: var(--primary);
        border-radius: 4px;
        flex-shrink: 0;
    }

    /* —— STATS —— */
    .stat-box {
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: var(--radius);
        padding: 12px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        height: 100%;
        transition: box-shadow .15s, transform .15s;
    }

    .stat-box:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-1px);
    }

    .stat-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
        background: var(--primary-light);
        color: var(--primary);
    }

    .stat-icon.success {
        background: #ecfdf3;
        color: #15803d;
    }

    .stat-icon.warning {
        background: #fff7ed;
        color: #c2410c;
    }

    .stat-label {
        font-size: .7rem;
        color: var(--muted);
        margin-bottom: 1px;
    }

    .stat-value {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--text);
        line-height: 1.2;
    }

    /* —— POST ROW —— */
    .post-row {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        background: var(--surface);
        border: 1.5px solid var(--border);
        border-radius: var(--radius);
        padding: 10px 12px;
        margin-bottom: 8px;
        transition: box-shadow .15s;
    }

    .post-row:hover {
        box-shadow: var(--shadow-hover);
    }

    .post-row.admin-hidden {
        border-color: #fca5a5;
        background: #fff8f8;
        opacity: .92;
    }

    .post-row-thumb {
        width: 72px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .post-row.admin-hidden .post-row-thumb {
        filter: grayscale(40%) opacity(.75);
    }

    .post-row-body {
        flex: 1;
        min-width: 0;
    }

    .post-row-title {
        font-size: .85rem;
        font-weight: 700;
        color: var(--text);
        text-decoration: none;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 4px;
    }

    .post-row-title:hover {
        color: var(--primary);
    }

    .post-row-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 6px;
        margin-bottom: 5px;
    }

    .post-row-price {
        font-size: .78rem;
        font-weight: 700;
        color: var(--primary);
    }

    .post-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        font-size: .67rem;
        font-weight: 600;
        padding: 2px 7px;
        border-radius: 20px;
    }

    .status-active {
        background: #ecfdf3;
        color: #15803d;
    }

    .status-pending {
        background: #fefce8;
        color: #a16207;
    }

    .status-expired {
        background: #fef2f2;
        color: #b91c1c;
    }

    .status-hidden {
        background: #f1f5f9;
        color: #475569;
    }

    .status-admin-off {
        background: #fef2f2;
        color: #b91c1c;
    }

    .post-row-info {
        font-size: .7rem;
        color: var(--muted);
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 6px;
    }

    .post-row-info span {
        display: flex;
        align-items: center;
        gap: 3px;
    }

    /* —— ADMIN HIDDEN NOTICE —— */
    .admin-hidden-notice {
        font-size: .72rem;
        font-weight: 600;
        color: #b91c1c;
        background: #fef2f2;
        border: 1px solid #fca5a5;
        border-radius: 8px;
        padding: 6px 10px;
        margin-bottom: 7px;
        display: flex;
        align-items: flex-start;
        gap: 6px;
    }

    .admin-hidden-notice i {
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* —— ACTIONS —— */
    .post-row-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .btn-manage {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: .7rem;
        font-weight: 600;
        padding: 4px 9px;
        border-radius: 6px;
        border: 1.5px solid var(--border);
        background: var(--surface);
        color: var(--text);
        cursor: pointer;
        text-decoration: none;
        transition: all .13s;
    }

    .btn-manage:hover {
        background: var(--border);
    }

    .btn-manage.danger {
        border-color: #fca5a5;
        color: #b91c1c;
        background: #fef2f2;
    }

    .btn-manage.danger:hover {
        background: #fee2e2;
    }

    .btn-manage.success {
        border-color: #86efac;
        color: #15803d;
        background: #f0fdf4;
    }

    .btn-manage.success:hover {
        background: #dcfce7;
    }

    .btn-manage.renew {
        border-color: #93c5fd;
        color: #1d4ed8;
        background: #eff6ff;
    }

    .btn-manage.renew:hover {
        background: #dbeafe;
    }

    .btn-manage.contact-admin {
        border-color: #f97316;
        color: #c2410c;
        background: #fff7ed;
        font-weight: 700;
    }

    .btn-manage.contact-admin:hover {
        background: #ffedd5;
    }

    .post-expire-bar {
        font-size: .73rem;
        color: #b91c1c;
        background: #fef2f2;
        border-left: 3px solid #dc2626;
        border-radius: 0 6px 6px 0;
        padding: 6px 12px;
        margin: 0 0 8px;
        display: flex;
        gap: 6px;
        align-items: flex-start;
    }

    @media (max-width: 576px) {
        .post-row-thumb {
            width: 60px;
            height: 52px;
        }

        .post-row-title {
            font-size: .8rem;
        }
    }
</style>
@endpush

@section('content')

<div class="qltd-page-head">
    <div>
        <h1 class="qltd-page-title">
            <span class="accent-line"></span>
            Quản lý tin đăng
        </h1>
        <div class="text-muted" style="font-size:.78rem;margin-top:3px">
            Theo dõi trạng thái duyệt, thời hạn hiển thị và thao tác nhanh với bài đăng của bạn.
        </div>
    </div>

    @if(Route::has('user.post.create'))
        <a href="{{ route('user.post.create') }}" class="btn-new-post">
            <i class="bi bi-plus-circle-fill"></i> Đăng tin mới
        </a>
    @endif
</div>

{{-- Stats --}}
<div class="row g-2 mb-3">
    @foreach([
        ['icon' => 'bi-file-earmark-text', 'class' => '',        'label' => 'Tổng số tin', 'key' => 'all'],
        ['icon' => 'bi-patch-check-fill',  'class' => 'success', 'label' => 'Đã duyệt',   'key' => 'approved'],
        ['icon' => 'bi-hourglass-split',   'class' => 'warning', 'label' => 'Chờ xử lý',  'key' => 'pending'],
    ] as $s)
    <div class="col-4">
        <div class="stat-box">
            <div class="stat-icon {{ $s['class'] }}"><i class="bi {{ $s['icon'] }}"></i></div>
            <div>
                <div class="stat-label">{{ $s['label'] }}</div>
                <div class="stat-value">{{ number_format($stats[$s['key']] ?? 0) }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Tabs --}}
<div class="qltd-tabs">
    @foreach([
        'all'      => ['label' => 'Tất cả',      'icon' => 'bi-grid-1x2'],
        'approved' => ['label' => 'Đã duyệt',    'icon' => 'bi-patch-check'],
        'pending'  => ['label' => 'Chờ duyệt',   'icon' => 'bi-hourglass-split'],
        'rejected' => ['label' => 'Từ chối',     'icon' => 'bi-x-octagon'],
        'hidden'   => ['label' => 'Đang ẩn',     'icon' => 'bi-eye-slash'],
    ] as $key => $tab)
        <a href="{{ request()->fullUrlWithQuery(['status' => $key, 'page' => null]) }}"
           class="qltd-tab {{ $activeStatus === $key ? 'active' : '' }}">
            <i class="bi {{ $tab['icon'] }}"></i>
            <span class="d-none d-sm-inline">{{ $tab['label'] }}</span>
            <span class="tab-count">{{ $stats[$key] ?? 0 }}</span>
        </a>
    @endforeach
</div>

{{-- Search --}}
<form method="GET" class="qltd-search-row">
    <input type="hidden" name="status" value="{{ $activeStatus }}">
    <div class="qltd-search-wrap">
        <i class="bi bi-search"></i>
        <input type="text"
               name="q"
               value="{{ $keyword }}"
               class="qltd-search-input"
               placeholder="Tìm theo tiêu đề, địa chỉ hoặc mã tin...">
    </div>
    <button type="submit" class="btn-new-post">
        <i class="bi bi-funnel"></i>
        <span class="d-none d-sm-inline">Lọc</span>
    </button>
</form>

@include('components.alert')

@if($posts->isEmpty())
    <div class="qltd-empty">
        <div class="qltd-empty-icon"><i class="bi bi-megaphone"></i></div>
        <div class="qltd-empty-title">Chưa có bài đăng phù hợp</div>
        <div class="qltd-empty-sub">
            @if($keyword !== '' || $activeStatus !== 'all')
                Không tìm thấy tin theo bộ lọc hiện tại. Thử đổi từ khóa hoặc trạng thái khác.
            @else
                Bạn chưa có tin đăng nào. Tạo bài đầu tiên để bắt đầu tiếp cận người thuê.
            @endif
        </div>

        @if(Route::has('user.post.create'))
            <a href="{{ route('user.post.create') }}" class="btn-new-post">
                <i class="bi bi-plus-circle-fill"></i> Đăng tin ngay
            </a>
        @endif
    </div>
@else

    @foreach($posts as $post)
        @php
            $isHiddenByAdmin = (int)($post->is_visible_admin ?? 1) === 0;
            $isHiddenByOwner = (int)($post->is_visible_owner ?? 1) === 0;

            $isExpired  = $post->expires_at && \Carbon\Carbon::now()->gt($post->expires_at);
            $expiresIn  = $post->expires_at
                ? \Carbon\Carbon::now()->diffInDays($post->expires_at, false)
                : null;
            $nearExpiry = !$isExpired && $expiresIn !== null && $expiresIn <= 3 && $expiresIn >= 0;

            $currentMembershipId      = data_get($currentUserMembership ?? null, 'membershipPackage.membership_id');
            $currentMembershipEndDate = data_get($currentUserMembership ?? null, 'end_date');
            $hasNewerMembership       = $currentMembershipEndDate
                && (!$post->expires_at || \Carbon\Carbon::parse($currentMembershipEndDate)->gt($post->expires_at));

            $canRepublish = !$isHiddenByOwner
                && $currentMembershipId
                && (
                    $isExpired
                    || (int)($post->membership_id ?? 0) !== (int)$currentMembershipId
                    || $hasNewerMembership
                );

            if ($isHiddenByAdmin) {
                $badgeClass = 'status-admin-off';
                $badgeLabel = 'Admin ẩn';
                $badgeIcon = 'bi-shield-x';
            } elseif ($isHiddenByOwner) {
                $badgeClass = 'status-hidden';
                $badgeLabel = 'Đang ẩn';
                $badgeIcon = 'bi-eye-slash-fill';
            } elseif ($isExpired) {
                $badgeClass = 'status-expired';
                $badgeLabel = 'Hết hạn';
                $badgeIcon = 'bi-calendar-x-fill';
            } elseif (($post->status ?? 'pending') === 'approved') {
                $badgeClass = 'status-active';
                $badgeLabel = 'Đã duyệt';
                $badgeIcon = 'bi-check-circle-fill';
            } elseif (($post->status ?? 'pending') === 'rejected') {
                $badgeClass = 'status-expired';
                $badgeLabel = 'Từ chối';
                $badgeIcon = 'bi-slash-circle-fill';
            } else {
                $badgeClass = 'status-pending';
                $badgeLabel = 'Chờ duyệt';
                $badgeIcon = 'bi-hourglass-split';
            }

            $imagePath = optional($post->images->sortBy('sort_order')->first())->image;
            $imageUrl = $imagePath
                ? asset('storage/' . $imagePath)
                : 'https://placehold.co/320x240/e2e8f0/475569?text=No+Image';

            $postAddress = $post->address
                ?: collect([data_get($post, 'ward.name'), data_get($post, 'ward.province.name')])->filter()->implode(', ');

            $detailUrl = (Route::has('frontend.post.show') && !empty($post->slug))
                ? route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug])
                : '#';
        @endphp

        <article class="post-row {{ $isHiddenByAdmin ? 'admin-hidden' : '' }}">
            <img src="{{ $imageUrl }}" alt="{{ $post->title }}" class="post-row-thumb">

            <div class="post-row-body">
                <a href="{{ $detailUrl }}" class="post-row-title">{{ $post->title }}</a>

                <div class="post-row-meta">
                    <span class="post-row-price">{{ number_format($post->price, 0, ',', '.') }}đ/tháng</span>

                    <span class="post-status-badge {{ $badgeClass }}">
                        <i class="bi {{ $badgeIcon }}"></i> {{ $badgeLabel }}
                    </span>

                    @if($post->category)
                        <span class="post-status-badge status-hidden">
                            <i class="bi bi-tag"></i> {{ $post->category->name }}
                        </span>
                    @endif
                </div>

                <div class="post-row-info">
                    @if($postAddress)
                        <span><i class="bi bi-geo-alt"></i> {{ $postAddress }}</span>
                    @endif

                    @if(!empty($post->area))
                        <span>
                            <i class="bi bi-aspect-ratio"></i>
                            {{ rtrim(rtrim(number_format((float)$post->area, 2), '0'), '.') }} m²
                        </span>
                    @endif

                    <span><i class="bi bi-calendar3"></i> {{ optional($post->created_at)->format('d/m/Y') }}</span>

                    <span>
                        <i class="bi bi-clock-history"></i>
                        @if($isExpired)
                            <span style="color:#b91c1c;font-weight:600">
                                Hết hạn {{ optional($post->expires_at)->format('d/m/Y') }}
                            </span>
                        @elseif($nearExpiry)
                            <span style="color:#c2410c;font-weight:600">
                                Còn {{ $expiresIn }} ngày ({{ optional($post->expires_at)->format('d/m/Y') }})
                            </span>
                        @else
                            Hết hạn: {{ optional($post->expires_at)->format('d/m/Y') ?? 'Chưa cập nhật' }}
                        @endif
                    </span>
                </div>

                @if($isHiddenByAdmin)
                    <div class="admin-hidden-notice">
                        <i class="bi bi-shield-exclamation"></i>
                        <span>Tin này đang bị ẩn. Vui lòng liên hệ quản trị viên để biết thêm chi tiết.</span>
                    </div>

                    <div class="post-row-actions">
                        <a href="{{ route('frontend.contact.index') }}" class="btn-manage contact-admin">
                            <i class="bi bi-headset"></i>
                            <span>Liên hệ Quản trị viên</span>
                        </a>
                    </div>
                @else
                    @if($isExpired)
                        <div style="font-size:.72rem;color:#b91c1c;margin-bottom:6px;">
                            <i class="bi bi-calendar-x-fill me-1"></i>Gói thành viên đã hết hạn
                        </div>
                    @endif

                    <div class="post-row-actions">
                        @if($canRepublish)
                            <a href="{{ route('user.post.repost', ['id' => $post->id, 'slug' => $post->slug]) }}"
                               class="btn-manage renew">
                                <i class="bi bi-arrow-clockwise"></i>
                                <span class="d-none d-sm-inline">Đăng lại</span>
                            </a>
                        @endif

                        <a href="{{ $detailUrl }}" class="btn-manage">
                            <i class="bi bi-eye"></i>
                            <span class="d-none d-sm-inline">Xem</span>
                        </a>

                        <a href="{{ route('user.post.edit', ['id' => $post->id, 'slug' => $post->slug]) }}"
                           class="btn-manage">
                            <i class="bi bi-pencil"></i>
                            <span class="d-none d-sm-inline">Sửa</span>
                        </a>

                        <button type="button"
                                class="btn-manage {{ $isHiddenByOwner ? 'success' : 'danger' }}"
                                onclick="toggleVisibility(
                                    {{ $post->id }},
                                    '{{ $isHiddenByOwner
                                        ? route('user.post.show-owner', $post->id)
                                        : route('user.post.hide', $post->id) }}',
                                    {{ $isHiddenByOwner ? 'true' : 'false' }}
                                )">
                            <i class="bi {{ $isHiddenByOwner ? 'bi-eye' : 'bi-eye-slash' }}"></i>
                            <span class="d-none d-sm-inline">{{ $isHiddenByOwner ? 'Hiện' : 'Ẩn' }}</span>
                        </button>

                        <form id="toggle-form-{{ $post->id }}" method="POST" style="display:none;">
                            @csrf
                            @method('PUT')
                        </form>

                        @if($post->status === 'approved' && $post->membership && $post->membership->slug === 'de-xuat')
                            <button type="button"
                                    class="btn-manage success"
                                    data-bs-toggle="modal"
                                    data-bs-target="#pushPostModal{{ $post->id }}">
                                <i class="bi bi-arrow-up-circle"></i>
                                <span class="d-none d-sm-inline">Đẩy tin</span>
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </article>

        @if(!$isHiddenByAdmin && $post->status === 'approved' && $post->membership && $post->membership->slug === 'de-xuat')
        <div class="modal fade" id="pushPostModal{{ $post->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="modal-header bg-warning text-dark border-0">
                        <h5 class="modal-title fw-bold">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>Xác nhận đẩy tin
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body px-4 py-4 text-center">
                        <i class="bi bi-arrow-up-circle-fill text-warning" style="font-size:2.5rem"></i>
                        <h6 class="fw-bold mt-3 mb-2">{{ $post->title }}</h6>
                        <p class="text-muted small mb-1">Mỗi lần đẩy tin sẽ tốn:</p>
                        <div class="fs-4 fw-bold text-danger mb-3">10.000đ</div>

                        <div class="alert alert-light border text-start small mb-0">
                            <div class="mb-1">
                                <i class="bi bi-info-circle text-primary me-1"></i>
                                Tin sẽ được ưu tiên hiển thị lên đầu danh sách.
                            </div>
                            <div class="mb-1">
                                <i class="bi bi-clock-history text-warning me-1"></i>
                                Mỗi tin chỉ được đẩy tối đa 1 lần trong 24 giờ.
                            </div>
                            <div>
                                <i class="bi bi-wallet2 text-success me-1"></i>
                                Số tiền trừ trực tiếp trong ví của bạn.
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 pb-4">
                        <button type="button" class="btn btn-light border rounded-pill px-4" data-bs-dismiss="modal">
                            Hủy
                        </button>

                        <form action="{{ route('user.post.push-post', ['id' => $post->id, 'slug' => $post->slug]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning text-dark fw-bold rounded-pill px-4">
                                <i class="bi bi-arrow-up-circle me-1"></i>Xác nhận đẩy tin
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(!$isHiddenByAdmin && ($post->status ?? null) === 'rejected')
            <div class="post-expire-bar">
                <i class="bi bi-exclamation-triangle-fill" style="color:#dc2626;flex-shrink:0"></i>
                Tin này đã bị từ chối. Kiểm tra lại nội dung, hình ảnh và thông tin liên hệ trước khi đăng lại.
            </div>
        @endif
    @endforeach

    <div class="d-flex justify-content-center mt-4">
        {{ $posts->appends(request()->query())->links() }}
    </div>

@endif

@endsection

@push('scripts')
<script>
    function toggleVisibility(postId, url, isHidden) {
        const message = isHidden
            ? 'Bạn có muốn hiển thị lại bài viết này không?'
            : 'Bạn có chắc muốn ẩn bài viết này không?';

        if (!confirm(message)) return;

        const form = document.getElementById('toggle-form-' + postId);
        form.action = url;
        form.submit();
    }
</script>
@endpush