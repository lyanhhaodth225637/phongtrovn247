<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>{{ config('app.name') }} - Tìm phòng trọ, căn hộ, nhà thuê nhanh nhất</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800;900&family=Sora:wght@700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/frontend/home.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800&family=Sora:wght@700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- test.css -->
</head>

<body>
    <!-- ═══ FILTER MODAL ═══ -->
    <div class="modal fade filter-modal" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">
                        <i class="bi bi-sliders2 me-2" style="color:var(--primary)"></i>Bộ lọc tìm kiếm
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <!-- Danh mục -->
                    <div class="filter-section">
                        <div class="filter-section-title">Danh mục cho thuê</div>
                        <div class="cat-grid">
                            <div class="cat-grid-item active" data-filter="category" data-value="Phòng trọ">
                                <i class="bi bi-door-open-fill"></i>Phòng trọ
                            </div>
                            <div class="cat-grid-item" data-filter="category" data-value="Nhà nguyên căn">
                                <i class="bi bi-house-fill"></i>Nhà nguyên căn
                            </div>
                            <div class="cat-grid-item" data-filter="category" data-value="Căn hộ">
                                <i class="bi bi-building"></i>Căn hộ
                            </div>
                            <div class="cat-grid-item" data-filter="category" data-value="Nhà nghỉ">
                                <i class="bi bi-moon-stars-fill"></i>Nhà nghỉ
                            </div>
                            <div class="cat-grid-item" data-filter="category" data-value="Ký túc xá">
                                <i class="bi bi-people-fill"></i>Ký túc xá
                            </div>
                            <div class="cat-grid-item" data-filter="category" data-value="Ở ghép">
                                <i class="bi bi-person-plus-fill"></i>Ở ghép
                            </div>
                        </div>
                    </div>

                    <!-- Vị trí -->
                    <div class="filter-section">
                        <div class="filter-section-title">Vị trí</div>
                        <div class="filter-select-row">
                            <div>
                                <label
                                    style="font-size:0.73rem;font-weight:600;color:var(--muted);margin-bottom:5px;display:block">Tỉnh/Thành
                                    phố</label>
                                <select class="form-select form-select-sm" id="filterProvince">
                                    <option value="">Tất cả</option>
                                    <option>An Giang</option>
                                    <option>TP. Hồ Chí Minh</option>
                                    <option>Hà Nội</option>
                                    <option>Đà Nẵng</option>
                                    <option>Cần Thơ</option>
                                    <option>Bình Dương</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    style="font-size:0.73rem;font-weight:600;color:var(--muted);margin-bottom:5px;display:block">Quận/Huyện</label>
                                <select class="form-select form-select-sm" id="filterDistrict">
                                    <option value="">Tất cả</option>
                                    <option>Quận 1</option>
                                    <option>Quận 3</option>
                                    <option>Bình Thạnh</option>
                                    <option>Gò Vấp</option>
                                    <option>Thủ Đức</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Khoảng giá -->
                    <div class="filter-section">
                        <div class="filter-section-title">Khoảng giá</div>
                        <div class="tag-chip-group">
                            <div class="tag-chip active-all" data-filter="price" data-value="all">Tất cả</div>
                            <div class="tag-chip" data-filter="price" data-value="Dưới 1 triệu">Dưới 1 triệu</div>
                            <div class="tag-chip" data-filter="price" data-value="1 - 2 triệu">1 – 2 triệu</div>
                            <div class="tag-chip" data-filter="price" data-value="2 - 3 triệu">2 – 3 triệu</div>
                            <div class="tag-chip" data-filter="price" data-value="3 - 5 triệu">3 – 5 triệu</div>
                            <div class="tag-chip" data-filter="price" data-value="5 - 7 triệu">5 – 7 triệu</div>
                            <div class="tag-chip" data-filter="price" data-value="7 - 10 triệu">7 – 10 triệu</div>
                            <div class="tag-chip" data-filter="price" data-value="Trên 10 triệu">Trên 10 triệu</div>
                        </div>
                    </div>

                    <!-- Diện tích -->
                    <div class="filter-section">
                        <div class="filter-section-title">Khoảng diện tích</div>
                        <div class="tag-chip-group">
                            <div class="tag-chip active-all" data-filter="area" data-value="all">Tất cả</div>
                            <div class="tag-chip" data-filter="area" data-value="Dưới 20m²">Dưới 20m²</div>
                            <div class="tag-chip" data-filter="area" data-value="20 - 30m²">20 – 30m²</div>
                            <div class="tag-chip" data-filter="area" data-value="30 - 50m²">30 – 50m²</div>
                            <div class="tag-chip" data-filter="area" data-value="50 - 70m²">50 – 70m²</div>
                            <div class="tag-chip" data-filter="area" data-value="Trên 70m²">Trên 70m²</div>
                        </div>
                    </div>

                    <!-- Tiện ích -->
                    <div class="filter-section">
                        <div class="filter-section-title">Đặc điểm nổi bật</div>
                        <div class="feature-grid">
                            <label class="feature-chip"><input type="checkbox" value="Đầy đủ nội thất">Đầy đủ nội
                                thất</label>
                            <label class="feature-chip"><input type="checkbox" value="Có gác">Có gác</label>
                            <label class="feature-chip"><input type="checkbox" value="Có máy lạnh">Có máy lạnh</label>
                            <label class="feature-chip"><input type="checkbox" value="Có máy giặt">Có máy giặt</label>
                            <label class="feature-chip"><input type="checkbox" value="Có tủ lạnh">Có tủ lạnh</label>
                            <label class="feature-chip"><input type="checkbox" value="Thang máy">Thang máy</label>
                            <label class="feature-chip"><input type="checkbox" value="Không chung chủ">Không chung
                                chủ</label>
                            <label class="feature-chip"><input type="checkbox" value="Tự do giờ giấc">Tự do giờ
                                giấc</label>
                            <label class="feature-chip"><input type="checkbox" value="Bảo vệ 24/7">Bảo vệ 24/7</label>
                            <label class="feature-chip"><input type="checkbox" value="Hầm để xe">Hầm để xe</label>
                            <label class="feature-chip"><input type="checkbox" value="Wifi miễn phí">Wifi miễn
                                phí</label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer d-flex">
                    <button class="btn-reset-filter" id="resetFilter">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>Đặt lại
                    </button>
                    <button class="btn-apply-filter" data-bs-dismiss="modal" id="applyFilter">
                        <i class="bi bi-check2 me-2"></i>Áp dụng
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══ HEADER ═══ -->
    <header class="site-header">
        <div class="container">
            <div class="header-inner">

                {{-- Logo --}}
                <a href="{{ route('frontend.home') }}" class="logo-text">PhongTro<span>VN</span>247</a>

                {{-- Desktop nav --}}
                <nav class="nav-desktop">
                    <a href="{{ route('frontend.home') }}" class="nav-link-custom">
                        <i class="bi bi-house me-1"></i>Trang chủ
                    </a>
                    <a href="#" class="nav-link-custom">
                        <i class="bi bi-newspaper me-1"></i>Tin tức
                    </a>
                    <a href="#" class="nav-link-custom">
                        <i class="bi bi-envelope me-1"></i>Liên hệ
                    </a>
                </nav>

                {{-- Actions --}}
                <div class="header-actions">

                    @auth
                        {{-- Chuông thông báo --}}
                        <div class="header-icon-btn" id="notifToggle">
                            <i class="bi bi-bell"></i>
                            {{-- Badge số thông báo chưa đọc --}}
                            <span class="header-icon-badge" id="notifCount" style="display:none">0</span>
                            {{-- Dropdown thông báo --}}
                            <div class="header-dropdown notif-dropdown" id="notifDropdown">
                                <div class="hdrop-head">
                                    <span>Thông báo</span>
                                    <a href="#" style="font-size:0.72rem;color:#1a56db;font-weight:600">Đánh dấu đã đọc</a>
                                </div>
                                <div class="hdrop-empty">
                                    <i class="bi bi-bell-slash"
                                        style="font-size:1.8rem;color:#cbd5e1;display:block;margin-bottom:6px"></i>
                                    Chưa có thông báo nào
                                </div>
                            </div>
                        </div>

                        {{-- Bài viết đã lưu --}}
                        <a href="#" class="header-icon-btn" title="Bài viết đã lưu">
                            <i class="bi bi-bookmark"></i>
                        </a>

                        {{-- Avatar + Dropdown --}}
                        <div class="header-avatar-wrap" id="avatarToggle">
                            <div class="nav-link-custom">{{ auth()->user()->name }}</div>
                            <img src="{{ asset('storage/' . (auth()->user()->avatar ?? 'default/avt_default.png')) }}"
                                class="header-avatar" alt="avatar">
                            <i class="bi bi-chevron-down header-chevron" id="avatarChevron"></i>

                            <div class="header-dropdown avatar-dropdown" id="avatarDropdown">
                                {{-- Profile info --}}
                                <div class="adrop-profile">
                                    <img src="{{ asset('storage/' . (auth()->user()->avatar ?? 'default/avt_default.png')) }}"
                                        class="adrop-avatar" alt="">
                                    <div>
                                        <div class="adrop-name">{{ auth()->user()->name }}</div>
                                        <div class="adrop-phone">{{ auth()->user()->phone ?? auth()->user()->email }}</div>
                                    </div>
                                </div>

                                {{-- Số dư --}}
                                <div class="adrop-balance">
                                    <div>
                                        <div class="adrop-balance-label">Số dư tài khoản</div>
                                        <div class="adrop-balance-num">
                                            {{ number_format(auth()->user()->balance ?? 0) }}đ
                                        </div>
                                    </div>
                                    <a href="#" class="adrop-topup">
                                        <i class="bi bi-credit-card-2-front"></i> Nạp tiền
                                    </a>
                                </div>

                                {{-- Quản lý tin đăng --}}
                                <div class="adrop-section-title">
                                    Quản lý tin đăng
                                    <a href="" class="adrop-viewall">Xem tất cả</a>
                                </div>
                                <div class="adrop-post-stats">
                                    <a href="" class="adrop-stat-item">
                                        <i class="bi bi-folder2"></i>
                                        <span>Tất cả</span>
                                    </a>
                                    <a href="" class="adrop-stat-item">
                                        <i class="bi bi-check-circle"></i>
                                        <span>Đang hiển thị</span>
                                    </a>
                                    <a href="" class="adrop-stat-item">
                                        <i class="bi bi-exclamation-triangle"></i>
                                        <span>Hết hạn</span>
                                    </a>
                                    <a href="?status=hidden" class="adrop-stat-item">
                                        <i class="bi bi-eye-slash"></i>
                                        <span>Tin ẩn</span>
                                    </a>
                                </div>

                                <div class="adrop-divider"></div>

                                {{-- Menu items --}}
                                <a href="#" class="adrop-menu-item">
                                    <i class="bi bi-tag"></i> Bảng giá dịch vụ
                                </a>
                                <a href="#" class="adrop-menu-item">
                                    <i class="bi bi-credit-card"></i> Quản lý giao dịch
                                </a>
                                <a href="#" class="adrop-menu-item">
                                    <i class="bi bi-person"></i> Quản lý tài khoản
                                </a>

                                <div class="adrop-divider"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="adrop-menu-item adrop-logout">
                                        <i class="bi bi-box-arrow-right"></i> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>

                    @else
                        <a href="{{ route('login') }}" class="nav-link-custom">
                            <i class="bi bi-person-circle me-1"></i>Đăng nhập
                        </a>
                    @endauth

                    <a href="#" class="btn-post">
                        <i class="bi bi-plus-circle"></i>
                        <span class="d-none d-sm-inline">Đăng tin</span>
                    </a>

                </div>
            </div>
        </div>
    </header>

    {{-- Overlay --}}
    <div id="headerOverlay"></div>

    {{-- ═══ SCRIPT ═══ --}}



    <div class="pd-wrap">

        {{-- Breadcrumb --}}
        <div class="pd-breadcrumb">
            <a href="{{ route('frontend.home') }}"><i class="bi bi-house-fill"></i> Trang chủ</a>
            <span class="sep"><i class="bi bi-chevron-right" style="font-size:.65rem"></i></span>
            <a href="{{ route('frontend.category.show', $post->category->slug ?? '#') }}">
                {{ $post->category->name ?? 'Danh mục' }}
            </a>
            <span class="sep"><i class="bi bi-chevron-right" style="font-size:.65rem"></i></span>
            <span
                style="color:#1e293b;font-weight:600;max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                {{ $post->title }}
            </span>
        </div>

        <div class="pd-grid">

            {{-- ══════════════ LEFT COLUMN ══════════════ --}}
            <div>

                {{-- ── GALLERY ── --}}
                @if($post->images->count())
                    @php
                        $thumbnail = $post->images->firstWhere('is_thumbnail', true) ?? $post->images->first();
                        $allImages = $post->images;
                    @endphp
                    <div class="gallery-main-wrap mb-2" id="galleryWrap">
                        <img id="mainImg" src="{{ asset('storage/' . $thumbnail->image) }}" alt="{{ $post->title }}">
                        <button class="gallery-arrow prev" onclick="galleryNav(-1)">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="gallery-arrow next" onclick="galleryNav(1)">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        <div class="gallery-counter">
                            <i class="bi bi-images"></i>
                            <span id="galleryCounter">1 / {{ $allImages->count() }}</span>
                        </div>
                    </div>
                    <div class="gallery-thumbs mb-4" id="thumbStrip">
                        @foreach($allImages as $idx => $img)
                            <img src="{{ asset('storage/' . $img->image) }}"
                                class="gallery-thumb {{ $idx === 0 ? 'active' : '' }}" data-idx="{{ $idx }}"
                                onclick="gallerySet({{ $idx }})" alt="">
                        @endforeach
                    </div>
                @else
                    <div
                        style="height:220px;background:#f1f5f9;border-radius:14px;display:flex;align-items:center;justify-content:center;color:#94a3b8;margin-bottom:20px">
                        <i class="bi bi-image" style="font-size:2.5rem"></i>
                    </div>
                @endif

                {{-- ── TITLE & META ── --}}
                <div class="pd-card">
                    <div class="pd-card-body">
                        <div class="post-vip-row">
                            @if($post->membership)
                                @php
                                    $vipClass = match ($post->membership->slug ?? '') {
                                        'vip-5' => 'vip-5',
                                        'vip-4' => 'vip-4',
                                        'vip-3' => 'vip-3',
                                        'vip-2' => 'vip-2',
                                        'vip-1' => 'vip-1',
                                        default => 'vip-free',
                                    };
                                    $vipLabel = strtoupper(str_replace('-', ' ', $post->membership->slug ?? 'Free'));
                                @endphp
                                <span class="vip-badge {{ $vipClass }}">
                                    <i class="bi bi-star-fill"></i> {{ $vipLabel }}
                                </span>
                            @endif
                            <span class="vip-badge vip-free">
                                <i class="bi bi-tag-fill"></i> {{ $post->category->name ?? '' }}
                            </span>
                            <span
                                style="margin-left:auto;font-size:0.76rem;color:#94a3b8;display:flex;align-items:center;gap:4px">
                                <i class="bi bi-clock"></i> {{ $post->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <h1 class="post-title">{{ $post->title }}</h1>

                        <div class="post-price-row">
                            <div>
                                <span class="post-price">{{ number_format($post->price) }}đ</span>
                                <span
                                    class="post-price-unit">/{{ $post->price_unit == 'month' ? 'tháng' : 'ngày' }}</span>
                            </div>
                        </div>

                        <div class="post-meta-chips">
                            <span class="meta-chip"><i class="bi bi-rulers"></i> {{ $post->area }} m²</span>
                            <span class="meta-chip"><i class="bi bi-geo-alt-fill"></i>
                                {{ $post->ward->name ?? '---' }}</span>
                            @if($post->ward->district->name ?? false)
                                <span class="meta-chip"><i class="bi bi-map"></i> {{ $post->ward->district->name }}</span>
                            @endif
                            <span class="meta-chip"><i class="bi bi-eye"></i> {{ number_format($post->view_count) }}
                                lượt xem</span>
                        </div>

                        <div class="address-line">
                            <i class="bi bi-geo-alt-fill"></i>
                            @if($post->latitude && $post->longitude)
                                <a href="https://www.google.com/maps?q={{ $post->latitude }},{{ $post->longitude }}&z=17"
                                    target="_blank">
                                    {{ $post->address }}
                                    <i class="bi bi-box-arrow-up-right" style="font-size:.7rem;margin-left:3px"></i>
                                </a>
                            @else
                                {{ $post->address }}
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ── MÔ TẢ ── --}}
                <div class="pd-card">
                    <div class="pd-card-head"><i class="bi bi-file-text"></i> Mô tả chi tiết</div>
                    <div class="pd-card-body">
                        <div class="post-desc">{!! $post->description !!}</div>
                    </div>
                </div>

                {{-- ── TIỆN ÍCH ── --}}
                @if($post->amenities->count())
                    <div class="pd-card">
                        <div class="pd-card-head"><i class="bi bi-stars"></i> Tiện ích</div>
                        <div class="pd-card-body">
                            <div class="amenity-list">
                                @foreach($post->amenities as $a)
                                    <span class="amenity-chip"><i class="bi bi-check-circle-fill"></i> {{ $a->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- ── BẢN ĐỒ ── --}}
                @if($post->latitude && $post->longitude)
                    <div class="pd-card" style="overflow:hidden">
                        <div class="pd-card-head"><i class="bi bi-map"></i> Vị trí trên bản đồ</div>
                        <div class="map-toolbar">
                            <button class="map-tb-btn active" data-layer="street">
                                <i class="bi bi-map"></i> Bản đồ
                            </button>
                            <button class="map-tb-btn" data-layer="satellite">
                                <i class="bi bi-globe"></i> Vệ tinh
                            </button>
                            <button class="map-tb-btn" data-layer="hybrid">
                                <i class="bi bi-layers"></i> Kết hợp
                            </button>
                        </div>
                        <div id="pd-map"></div>
                    </div>
                @endif

                {{-- ── THÔNG TIN BÀI ĐĂNG ── --}}
                <div class="pd-card">
                    <div class="pd-card-head"><i class="bi bi-info-circle"></i> Thông tin bài đăng</div>
                    <div class="pd-card-body">
                        <table class="info-table">
                            <tr>
                                <td>Mã tin</td>
                                <td><code
                                        style="background:#f1f5f9;padding:2px 7px;border-radius:5px;font-size:.82rem">#{{ $post->id }}</code>
                                </td>
                            </tr>
                            <tr>
                                <td>Loại tin</td>
                                <td>
                                    @if($post->membership)
                                        <span class="vip-badge {{ $vipClass ?? 'vip-free' }}" style="font-size:.72rem">
                                            {{ $post->membership->name ?? $vipLabel ?? '---' }}
                                        </span>
                                    @else
                                        <span class="vip-badge vip-free">Miễn phí</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Ngày đăng</td>
                                <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td>Hết hạn</td>
                                <td>
                                    @if($post->expires_at)
                                        @php $daysLeft = now()->diffInDays($post->expires_at, false); @endphp
                                        <span class="expires-chip {{ $daysLeft <= 3 ? 'soon' : '' }}">
                                            <i class="bi bi-calendar-check"></i>
                                            {{ \Carbon\Carbon::parse($post->expires_at)->format('d/m/Y') }}
                                            (còn {{ $daysLeft }} ngày)
                                        </span>
                                    @else
                                        ---
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Lượt xem</td>
                                <td>{{ number_format($post->view_count) }} lượt</td>
                            </tr>
                        </table>
                        <a href="#" class="report-link">
                            <i class="bi bi-flag"></i> Báo cáo tin đăng này
                        </a>
                    </div>
                </div>

            </div>{{-- /left col --}}

            {{-- ══════════════ SIDEBAR ══════════════ --}}
            <div class="sidebar-sticky">

                {{-- Contact card --}}
                <div class="contact-card">
                    <div class="contact-card-top">
                        <div class="contact-avatar-wrap">
                            <img src="{{ asset('storage/' . ($post->user->avatar ?? 'default/avt_default.png')) }}"
                                class="contact-avatar" alt="">
                            <div>
                                <div class="contact-name">{{ $post->user->name ?? 'Chủ nhà' }}</div>
                                <div class="contact-role">
                                    <i class="bi bi-patch-check-fill" style="font-size:.75rem;margin-right:2px"></i>
                                    Chủ nhà đã xác minh
                                </div>
                            </div>
                        </div>

                        {{-- Thông tin bổ sung: số bài đăng + ngày tham gia --}}
                        <div class="contact-user-meta">
                            <span class="contact-meta-item">
                                <i class="bi bi-file-earmark-text"></i>
                                {{ $post->user->posts()->where('status', 'approved')->count() }} bài đăng
                            </span>
                            <span class="contact-meta-item">
                                <i class="bi bi-calendar3"></i>
                                Tham gia {{ $post->user->created_at->format('m/Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="contact-card-body">
                        <button class="btn-phone" id="btnRevealPhone"
                            data-phone="{{ $post->user->phone ?? '0000000000' }}">
                            <i class="bi bi-telephone-fill"></i>
                            <span id="phoneText">
                                {{ substr($post->user->phone ?? '0000000000', 0, 3) }}*****{{ substr($post->user->phone ?? '0000000000', -2) }}
                            </span>
                            <span style="font-size:.75rem;font-weight:400;opacity:.85"> — Bấm để hiện số</span>
                        </button>

                        <a href="https://zalo.me/{{ $post->user->phone ?? '' }}" target="_blank" class="btn-zalo">
                            <i class="bi bi-chat-dots-fill"></i> Nhắn Zalo
                        </a>

                        <button class="btn-save-post" id="btnSave">
                            <i class="bi bi-bookmark"></i> Lưu tin này
                        </button>
                    </div>
                </div>

                {{-- Security note --}}
                <div class="security-note">
                    <i class="bi bi-shield-exclamation"></i>
                    <div>Không chuyển tiền đặt cọc khi chưa xem phòng trực tiếp. Nếu có dấu hiệu lừa đảo hãy <a href="#"
                            style="color:#d97706;font-weight:700">báo cáo ngay</a>.</div>
                </div>

                {{-- Related posts --}}
                @if(isset($relatedPosts) && $relatedPosts->count())
                    <div class="pd-card">
                        <div class="pd-card-head"><i class="bi bi-grid"></i> Tin cùng khu vực</div>
                        <div class="pd-card-body" style="padding-top:8px;padding-bottom:8px">
                            <div class="related-title">Gợi ý cho bạn</div>
                            @foreach($relatedPosts as $rp)
                                <a href="{{ route('posts.show', $rp->slug) }}" class="related-card">
                                    <img src="{{ asset('storage/' . ($rp->images->first()->image ?? 'default.jpg')) }}"
                                        class="related-img" alt="{{ $rp->title }}">
                                    <div class="related-info">
                                        <div class="related-post-title">{{ $rp->title }}</div>
                                        <div class="related-price">{{ number_format($rp->price) }}đ/tháng</div>
                                        <div class="related-meta">
                                            <i class="bi bi-geo-alt"></i> {{ $rp->ward->name ?? '' }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>{{-- /sidebar --}}

        </div>{{-- /grid --}}

    </div>{{-- /pd-wrap --}}



    </div>

    <!-- ═══ FOOTER ═══ -->
    <footer class="site-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-12">
                    <div class="footer-logo">PhongTro<span>VN</span>247</div>
                    <p style="font-size:0.78rem;line-height:1.75;margin-bottom:14px">
                        Nền tảng tìm kiếm phòng trọ, nhà thuê uy tín hàng đầu Việt Nam.<br>
                        Kết nối người thuê và chủ nhà nhanh chóng, tiện lợi.
                    </p>
                    <div class="footer-social d-flex gap-3">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                        <a href="#"><i class="bi bi-tiktok"></i></a>
                        <a href="#"><i class="bi bi-telegram"></i></a>
                    </div>
                </div>
                <div class="col-6 col-sm-4 col-lg-2">
                    <div class="footer-title">Danh mục</div>
                    <a href="#" class="footer-link">Phòng trọ</a>
                    <a href="#" class="footer-link">Nhà nguyên căn</a>
                    <a href="#" class="footer-link">Căn hộ dịch vụ</a>
                    <a href="#" class="footer-link">Nhà nghỉ</a>
                    <a href="#" class="footer-link">Ký túc xá</a>
                </div>
                <div class="col-6 col-sm-4 col-lg-2">
                    <div class="footer-title">Hỗ trợ</div>
                    <a href="#" class="footer-link">Hướng dẫn đăng tin</a>
                    <a href="#" class="footer-link">Bảng giá dịch vụ</a>
                    <a href="#" class="footer-link">Quy chế hoạt động</a>
                    <a href="#" class="footer-link">Chính sách riêng tư</a>
                    <a href="#" class="footer-link">Liên hệ</a>
                </div>
                <div class="col-12 col-sm-4 col-lg-4">
                    <div class="footer-title">Nhận tin phòng trọ mới</div>
                    <p style="font-size:0.77rem;margin-bottom:12px">Đăng ký để nhận thông báo phòng trọ phù hợp với bạn.
                    </p>
                    <div class="d-flex gap-2">
                        <input type="email" placeholder="Email của bạn"
                            class="form-control form-control-sm footer-input">
                        <button class="btn-post" style="white-space:nowrap;font-size:0.77rem;padding:6px 14px">Đăng
                            ký</button>
                    </div>
                </div>
            </div>
            <hr class="footer-divider">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2" style="font-size:0.76rem">
                <span>© 2024 PhongTroVN247. Bảo lưu mọi quyền.</span>
                <span>📞 Hotline: <strong style="color:#fff">1900 6868</strong></span>
            </div>
        </div>
    </footer>

    <nav class="mobile-nav">

        <a href="{{ route('frontend.home') }}" class="mobile-nav-item active">
            <i class="bi bi-house-fill"></i>
            <span>Trang chủ</span>
        </a>

        <button class="mobile-nav-item" data-bs-toggle="modal" data-bs-target="#filterModal">
            <i class="bi bi-sliders2"></i>
            <span>Lọc</span>
        </button>

        <a href="" class="mobile-nav-item btn-post-mobile">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Đăng tin</span>
        </a>

        <a href="#" class="mobile-nav-item">
            <i class="bi bi-bookmark"></i>
            <span>Đã lưu</span>
        </a>

        @auth
            <a href="" class="mobile-nav-item">
                <img src="{{ asset('storage/' . (auth()->user()->avatar ?? 'default/avt_default.png')) }}"
                    style="width:24px;height:24px;border-radius:50%">
                <span>{{ auth()->user()->name }}</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="mobile-nav-item">
                <i class="bi bi-person-circle"></i>
                <span>Đăng nhập</span>
            </a>
        @endauth

    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/frontend/home.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        /* ── Gallery ── */
        const galleryImages = @json($post->images->pluck('image'));
        let currentIdx = 0;

        function gallerySet(idx) {
            currentIdx = idx;
            const base = '{{ asset('storage/') }}/';
            document.getElementById('mainImg').src = base + galleryImages[idx];
            document.getElementById('galleryCounter').textContent = (idx + 1) + ' / ' + galleryImages.length;
            document.querySelectorAll('.gallery-thumb').forEach((t, i) => {
                t.classList.toggle('active', i === idx);
            });
            // scroll thumb into view
            const thumb = document.querySelector(`.gallery-thumb[data-idx="${idx}"]`);
            if (thumb) thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }

        function galleryNav(dir) {
            const len = galleryImages.length;
            gallerySet((currentIdx + dir + len) % len);
        }

        /* ── Reveal phone ── */
        const btnPhone = document.getElementById('btnRevealPhone');
        if (btnPhone) {
            btnPhone.addEventListener('click', function () {
                const phone = this.dataset.phone;
                document.getElementById('phoneText').textContent = phone;
                this.querySelector('span:last-child').style.display = 'none';
                this.classList.add('revealed');
                this.querySelector('i').className = 'bi bi-telephone-fill';
            });
        }

        /* ── Save button ── */
        const btnSave = document.getElementById('btnSave');
        if (btnSave) {
            btnSave.addEventListener('click', function () {
                this.classList.toggle('saved');
                const saved = this.classList.contains('saved');
                this.innerHTML = saved
                    ? '<i class="bi bi-bookmark-fill"></i> Đã lưu'
                    : '<i class="bi bi-bookmark"></i> Lưu tin này';
            });
        }

        /* ── Map ── */
        @if($post->latitude && $post->longitude)
            (function () {
                const lat = {{ $post->latitude }};
                const lng = {{ $post->longitude }};
                const address = @json($post->address ?? '');

                const map = L.map('pd-map', { center: [lat, lng], zoom: 17, scrollWheelZoom: false });

                const layers = {
                    street: L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', { attribution: '© Google', maxZoom: 20 }),
                    satellite: L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', { attribution: '© Google', maxZoom: 20 }),
                    hybrid: L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', { attribution: '© Google', maxZoom: 20 }),
                };
                let current = layers.street.addTo(map);

                L.marker([lat, lng]).addTo(map)
                    .bindPopup(`<div style="font-size:13px;max-width:200px">${address}</div>`)
                    .openPopup();

                document.querySelectorAll('.map-tb-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const key = this.dataset.layer;
                        if (layers[key] === current) return;
                        map.removeLayer(current);
                        current = layers[key].addTo(map);
                        document.querySelectorAll('.map-tb-btn').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                    });
                });
            })();
        @endif
    </script>

</body>

</html>