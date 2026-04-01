<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title>{{ config('app.name') }} - Tìm phòng trọ, căn hộ, nhà thuê nhanh nhất</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800;900&family=Sora:wght@700;800&display=swap"
        rel="stylesheet">

    {{-- CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('css/frontend/home.css') }}">

    {{-- CSS từ trang con --}}
    <style>
        .qltd-wrap {
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 20px;
            align-items: start;
            padding: 24px 0 48px;
        }

        /* ══ SIDEBAR ══ */
        .qltd-sidebar {
            position: sticky;
            top: 76px;
        }

        /* Profile card */
        .sidebar-profile {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: 12px;
        }

        .sidebar-profile-top {
            background: linear-gradient(135deg, #0f1e4a 0%, #0d6efd 100%);
            padding: 20px 16px 16px;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .sidebar-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            object-fit: cover;
            border: 2.5px solid rgba(255, 255, 255, .55);
            flex-shrink: 0;
        }

        .sidebar-name {
            font-size: .9rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 2px;
        }

        .sidebar-phone {
            font-size: .72rem;
            color: rgba(255, 255, 255, .75);
        }

        .sidebar-code {
            font-size: .68rem;
            color: rgba(255, 255, 255, .55);
            margin-top: 1px;
        }

        /* Balance strip */
        .sidebar-balance {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 14px;
            background: #fffbeb;
            border-bottom: 1px solid #fde68a;
        }

        .sidebar-balance-label {
            font-size: .68rem;
            font-weight: 600;
            color: #92400e;
            margin-bottom: 2px;
        }

        .sidebar-balance-num {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text);
        }

        .sidebar-topup {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--gold);
            color: #fff;
            font-size: .72rem;
            font-weight: 700;
            padding: 6px 12px;
            border-radius: 8px;
            text-decoration: none;
            white-space: nowrap;
            transition: filter .15s;
        }

        .sidebar-topup:hover {
            filter: brightness(1.08);
            color: #fff;
        }

        /* Nav menu */
        .sidebar-nav {
            padding: 6px 0;
        }

        .sidebar-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            font-size: .83rem;
            font-weight: 500;
            color: var(--text2);
            text-decoration: none;
            transition: background .12s, color .12s;
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }

        .sidebar-nav-item i {
            font-size: .95rem;
            color: var(--muted);
            width: 18px;
            flex-shrink: 0;
        }

        .sidebar-nav-item:hover {
            background: #f8fafc;
            color: var(--primary);
        }

        .sidebar-nav-item:hover i {
            color: var(--primary);
        }

        .sidebar-nav-item.active {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 700;
        }

        .sidebar-nav-item.active i {
            color: var(--primary);
        }

        .sidebar-nav-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 4px 0;
        }

        .sidebar-nav-item.logout {
            color: #e02424;
        }

        .sidebar-nav-item.logout i {
            color: #e02424;
        }

        .sidebar-nav-item.logout:hover {
            background: #fff1f2;
        }

        /* Support strip */
        .sidebar-support {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 12px 14px;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 12px;
        }

        .sidebar-support-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .sidebar-support-label {
            font-size: .65rem;
            color: var(--muted);
            margin-bottom: 1px;
        }

        .sidebar-support-name {
            font-size: .78rem;
            font-weight: 700;
            color: var(--text);
        }

        /* ══ MAIN CONTENT ══ */
        .qltd-main {}

        /* Page header */
        .qltd-page-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .qltd-page-title {
            font-family: 'Sora', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .qltd-page-title .accent-line {
            width: 4px;
            height: 22px;
        }

        /* Status tabs */
        .qltd-tabs {
            display: flex;
            border-bottom: 2px solid var(--border);
            margin-bottom: 16px;
            overflow-x: auto;
            scrollbar-width: none;
            gap: 0;
        }

        .qltd-tabs::-webkit-scrollbar {
            display: none;
        }

        .qltd-tab {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            font-size: .83rem;
            font-weight: 700;
            color: var(--muted);
            border: none;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            background: none;
            cursor: pointer;
            white-space: nowrap;
            transition: color .18s, border-color .18s;
            font-family: 'Be Vietnam Pro', sans-serif;
            text-decoration: none;
        }

        .qltd-tab:hover {
            color: var(--text);
        }

        .qltd-tab.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        .qltd-tab .tab-count {
            background: var(--border);
            color: var(--muted);
            font-size: .65rem;
            font-weight: 800;
            padding: 1px 7px;
            border-radius: 10px;
            min-width: 20px;
            text-align: center;
        }

        .qltd-tab.active .tab-count {
            background: var(--primary);
            color: #fff;
        }

        /* Search bar */
        .qltd-search-row {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .qltd-search-wrap {
            flex: 1;
            min-width: 200px;
            position: relative;
        }

        .qltd-search-wrap i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: .9rem;
            pointer-events: none;
        }

        .qltd-search-input {
            width: 100%;
            padding: 9px 12px 9px 36px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: .83rem;
            color: var(--text);
            background: var(--surface);
            transition: border-color .18s, box-shadow .18s;
            outline: none;
        }

        .qltd-search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, .1);
        }

        .qltd-search-input::placeholder {
            color: #94a3b8;
        }

        .btn-new-post {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-family: 'Be Vietnam Pro', sans-serif;
            font-weight: 700;
            font-size: .83rem;
            padding: 9px 16px;
            cursor: pointer;
            transition: background .18s;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-new-post:hover {
            background: var(--primary-dark);
            color: #fff;
        }

        /* Empty state */
        .qltd-empty {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 60px 24px;
            text-align: center;
            box-shadow: var(--shadow-sm);
        }

        .qltd-empty-icon {
            width: 90px;
            height: 90px;
            background: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 2.2rem;
            color: var(--primary);
        }

        .qltd-empty-title {
            font-family: 'Sora', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 6px;
        }

        .qltd-empty-sub {
            font-size: .8rem;
            color: var(--muted);
            margin-bottom: 20px;
            line-height: 1.7;
        }

        /* Post list card */
        .post-manage-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            display: flex;
            margin-bottom: 12px;
            transition: box-shadow .2s, transform .2s;
        }

        .post-manage-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-1px);
        }

        .post-manage-img {
            width: 140px;
            min-width: 140px;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .post-manage-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .3s;
        }

        .post-manage-card:hover .post-manage-img img {
            transform: scale(1.05);
        }

        .post-manage-body {
            flex: 1;
            min-width: 0;
            padding: 12px 14px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .post-manage-title {
            font-weight: 700;
            font-size: .88rem;
            color: var(--text);
            text-decoration: none;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.45;
            transition: color .15s;
        }

        .post-manage-title:hover {
            color: var(--primary);
        }

        .post-manage-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            align-items: center;
        }

        .post-manage-price {
            font-size: .95rem;
            font-weight: 800;
            color: var(--primary);
        }

        .post-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: .65rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .status-active {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .status-expired {
            background: #fff7ed;
            color: #c2410c;
            border: 1px solid #fed7aa;
        }

        .status-hidden {
            background: #f8fafc;
            color: #64748b;
            border: 1px solid var(--border);
        }

        .status-pending {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .post-manage-info {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            font-size: .72rem;
            color: var(--muted);
        }

        .post-manage-info span {
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .post-manage-actions {
            display: flex;
            gap: 6px;
            margin-top: auto;
            flex-wrap: wrap;
        }

        .btn-manage {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: .73rem;
            font-weight: 600;
            padding: 5px 11px;
            border-radius: 6px;
            border: 1.5px solid var(--border);
            background: var(--surface);
            color: var(--text2);
            cursor: pointer;
            transition: border-color .15s, color .15s, background .15s;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-manage:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .btn-manage.danger:hover {
            border-color: #e02424;
            color: #e02424;
            background: #fff1f2;
        }

        .btn-manage.success {
            border-color: #15803d;
            color: #15803d;
            background: #f0fdf4;
        }

        .btn-manage.success:hover {
            background: #dcfce7;
        }

        /* Expire warning */
        .post-expire-bar {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #fffbeb;
            border-top: 1px solid #fde68a;
            padding: 6px 14px;
            font-size: .72rem;
            color: #92400e;
            font-weight: 500;
        }

        /* ══ MOBILE: sidebar → bottom sheet / drawer ══ */
        .mobile-sidebar-btn {
            display: none;
            position: fixed;
            bottom: 70px;
            right: 16px;
            z-index: 998;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            border: none;
            font-size: 1.1rem;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(13, 110, 253, .35);
            align-items: center;
            justify-content: center;
            transition: transform .15s;
        }

        .mobile-sidebar-btn:hover {
            transform: scale(1.08);
        }

        .sidebar-drawer-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 1040;
        }

        .sidebar-drawer-overlay.show {
            display: block;
        }

        .sidebar-drawer {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 280px;
            background: var(--surface);
            z-index: 1050;
            transform: translateX(-100%);
            transition: transform .28s cubic-bezier(.4, 0, .2, 1);
            overflow-y: auto;
            box-shadow: 4px 0 24px rgba(0, 0, 0, .12);
        }

        .sidebar-drawer.open {
            transform: translateX(0);
        }

        .sidebar-drawer-close {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(0, 0, 0, .06);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8rem;
            color: var(--text2);
        }

        /* ══ RESPONSIVE ══ */
        @media (max-width: 900px) {
            .qltd-wrap {
                grid-template-columns: 1fr;
            }

            .qltd-sidebar {
                display: none;
                /* ẩn, dùng drawer thay thế */
            }

            .mobile-sidebar-btn {
                display: flex;
            }
        }

        @media (max-width: 576px) {
            .qltd-page-title {
                font-size: 1.05rem;
            }

            .post-manage-img {
                width: 100px;
                min-width: 100px;
            }

            .post-manage-body {
                padding: 10px 11px;
            }

            .post-manage-price {
                font-size: .85rem;
            }

            .btn-manage {
                font-size: .68rem;
                padding: 4px 9px;
            }

            .qltd-tabs {
                gap: 0;
            }

            .qltd-tab {
                padding: 9px 12px;
                font-size: .78rem;
            }
        }

        @media (max-width: 400px) {
            .post-manage-img {
                width: 88px;
                min-width: 88px;
            }

            .post-manage-actions {
                gap: 4px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- ═══ HEADER ═══ -->
    <header class="site-header" style="z-index: 9999;">
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
                            <span class="header-icon-badge" id="notifCount" style="display:none">0</span>
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

                        {{-- Avatar + Bootstrap Dropdown --}}
                        <div class="dropdown">
                            <div class="header-avatar-wrap" id="avatarToggle" data-bs-toggle="dropdown" data-bs-offset="0,8"
                                aria-expanded="false">
                                <div class="nav-link-custom">{{ auth()->user()->name }}</div>
                                <img src="{{ asset('storage/' . (auth()->user()->avatar ?? 'default/avt_default.png')) }}"
                                    class="header-avatar" alt="avatar">
                                <i class="bi bi-chevron-down header-chevron" id="avatarChevron"></i>
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

    <div id="headerOverlay"></div>

    <!-- ═══ MAIN CONTENT ═══ -->
    <div class="container section-wrap">

        <div id="activeFiltersRow" class="active-filters d-none"></div>

        {{-- Mobile sidebar toggle --}}
        <button class="mobile-sidebar-btn" id="sidebarBtn" title="Menu tài khoản">
            <i class="bi bi-person-circle"></i>
        </button>

        {{-- Mobile sidebar drawer --}}
        <div class="sidebar-drawer-overlay" id="sidebarOverlay"></div>
        <div class="sidebar-drawer" id="sidebarDrawer">
            <button class="sidebar-drawer-close" id="sidebarClose"><i class="bi bi-x"></i></button>
            <div class="sidebar-profile">
                <div class="sidebar-profile-top">
                    <img src="{{ asset('storage/' . (auth()->user()->avatar ?? 'default/avt_default.png')) }}"
                        class="sidebar-avatar" alt="">
                    <div>
                        <div class="sidebar-name">{{ auth()->user()->name }}</div>
                        <div class="sidebar-phone">{{ auth()->user()->phone ?? '' }}</div>
                        <div class="sidebar-code">Mã tài khoản: {{ auth()->user()->id }}</div>
                    </div>
                </div>
                <div class="sidebar-balance">
                    <div>
                        <div class="sidebar-balance-label">Số dư tài khoản</div>
                        <div class="sidebar-balance-num">{{ number_format(auth()->user()->balance ?? 0) }}đ</div>
                    </div>
                    <a href="{{ route('user.wallet.index') }}" class="sidebar-topup"><i class="bi bi-lightning-fill"></i> Nạp tiền</a>
                </div>
                <nav class="sidebar-nav">
                    <a href="#" class="sidebar-nav-item"><i class="bi bi-award"></i> Hạng thành viên</a>
                    <a href="{{ route('user.post.create') }}" class="sidebar-nav-item"><i
                            class="bi bi-pencil-square"></i> Đăng tin mới</a>
                    <a href="#" class="sidebar-nav-item active"><i class="bi bi-list-ul"></i> Danh sách tin đăng</a>
                    <a href="#" class="sidebar-nav-item"><i class="bi bi-wallet2"></i> Nạp tiền vào tài khoản</a>
                    <a href="#" class="sidebar-nav-item"><i class="bi bi-clock-history"></i> Lịch sử nạp tiền</a>
                    <a href="#" class="sidebar-nav-item"><i class="bi bi-receipt"></i> Lịch sử thanh toán</a>
                    <a href="#" class="sidebar-nav-item"><i class="bi bi-tag"></i> Bảng giá dịch vụ</a>
                    <a href="#" class="sidebar-nav-item"><i class="bi bi-person"></i> Quản lý tài khoản</a>
                    <a href="#" class="sidebar-nav-item"><i class="bi bi-gift"></i> Giới thiệu bạn bè</a>
                    <hr class="sidebar-nav-divider">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sidebar-nav-item logout">
                            <i class="bi bi-box-arrow-right"></i> Đăng xuất
                        </button>
                    </form>
                </nav>
            </div>
        </div>

        {{-- Main grid --}}
        <div class="qltd-wrap">

            {{-- Sidebar Desktop --}}
            <aside class="qltd-sidebar">
                <div class="sidebar-profile">
                    <div class="sidebar-profile-top">
                        <img src="{{ asset('storage/' . (auth()->user()->avatar ?? 'default/avt_default.png')) }}"
                            class="sidebar-avatar" alt="">
                        <div>
                            <div class="sidebar-name">{{ auth()->user()->name }}</div>
                            <div class="sidebar-phone">{{ auth()->user()->phone ?? '' }}</div>
                            <div class="sidebar-code">Mã TK: {{ auth()->user()->id }}</div>
                        </div>
                    </div>
                    <div class="sidebar-balance">
                        <div>
                            <div class="sidebar-balance-label">Số dư tài khoản</div>
                            <div class="sidebar-balance-num">{{ number_format(auth()->user()->balance ?? 0) }}đ</div>
                        </div>
                        <a href="{{ route('user.wallet.index') }}" class="sidebar-topup"><i class="bi bi-lightning-fill"></i> Nạp tiền</a>
                    </div>
                    <nav class="sidebar-nav">
                        <a href="#" class="sidebar-nav-item"><i class="bi bi-award"></i> Hạng thành viên</a>
                        <a href="{{ route('user.post.create') }}" class="sidebar-nav-item"><i
                                class="bi bi-pencil-square"></i> Đăng tin mới</a>
                        <a href="#" class="sidebar-nav-item active"><i class="bi bi-list-ul"></i> Danh sách tin đăng</a>
                        <a href="#" class="sidebar-nav-item"><i class="bi bi-wallet2"></i> Nạp tiền vào tài khoản</a>
                        <a href="{{ route('user.wallet.deposit-histor') }}" class="sidebar-nav-item"><i class="bi bi-clock-history"></i> Lịch sử nạp tiền</a>
                        <a href="#" class="sidebar-nav-item"><i class="bi bi-receipt"></i> Lịch sử thanh toán</a>
                        <a href="#" class="sidebar-nav-item"><i class="bi bi-tag"></i> Bảng giá dịch vụ</a>
                        <a href="#" class="sidebar-nav-item"><i class="bi bi-person"></i> Quản lý tài khoản</a>
                        <a href="#" class="sidebar-nav-item"><i class="bi bi-gift"></i> Giới thiệu bạn bè</a>
                        <hr class="sidebar-nav-divider">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="sidebar-nav-item logout">
                                <i class="bi bi-box-arrow-right"></i> Đăng xuất
                            </button>
                        </form>
                    </nav>
                </div>

                <div class="sidebar-support">
                    <img src="{{ asset('images/support.jpg') }}" class="sidebar-support-avatar"
                        onerror="this.src='https://ui-avatars.com/api/?name=Support&background=0d6efd&color=fff&size=36'"
                        alt="">
                    <div>
                        <div class="sidebar-support-label">Nhân viên hỗ trợ riêng của bạn:</div>
                        <div class="sidebar-support-name">CSKH PhongTroVN247</div>
                    </div>
                </div>
            </aside>

            {{-- Main content --}}
            <main class="qltd-main">
                @yield('content')
            </main>
        </div>
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

    <!-- ═══ MOBILE BOTTOM NAV ═══ -->
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

    <!-- ═══ SCRIPTS — THỨ TỰ QUAN TRỌNG ═══ -->

    {{-- 1. Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- 2. Leaflet JS (phải trước bất kỳ code nào dùng L.*) --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- 3. Scripts thư viện từ trang con (vd: CKEditor) — phải trước home.js và user.js --}}
    @stack('lib-scripts')

    {{-- 4. App JS chung --}}
    <script src="{{ asset('js/frontend/home.js') }}"></script>

    {{-- 5. Scripts logic của trang con --}}
    @stack('scripts')

</body>

</html>