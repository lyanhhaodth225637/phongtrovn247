<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light" data-pwa="true">

<head>
    <meta charset="utf-8" />
    <!-- Viewport -->
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Title -->
    <title>@yield('title', 'Trang chủ') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon / App icons -->
    <!-- <link rel="icon" type="image/png" href="{{ asset('assets/img/app-icons/icon-32x32.png') }}" sizes="32x32" />
    <link rel="apple-touch-icon" href="{{ asset('assets/img/app-icons/icon-180x180.png') }}" /> -->

    <!-- Theme switcher (color modes) -->
    <script src="{{ asset('assets/js/theme-switcher.js') }}"></script>

    <!-- Preloaded local web font (Inter) -->
    <link rel="preload" href="{{ asset('assets/fonts/inter-variable-latin.woff2') }}" as="font" type="font/woff2"
        crossorigin />

    <!-- Font icons -->
    <link rel="preload" href="{{ asset('assets/icons/cartzilla-icons.woff2') }}" as="font" type="font/woff2"
        crossorigin />
    <link rel="stylesheet" href="{{ asset('assets/icons/cartzilla-icons.min.css') }}" />

    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/simplebar/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/choices.js/choices.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/flatpickr.min.css') }}" />

    <!-- Bootstrap + Theme styles -->
    <link rel="preload" href="{{ asset('assets/css/theme.min.css') }}" as="style" />
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}" id="theme-styles" />
    @yield('css')
    <style>
        .navbar-brand {
            font-family: 'Arial Rounded MT Bold', 'Arial Black', sans-serif;
            font-size: 1.6rem;
            font-weight: 900;
            letter-spacing: -0.5px;
            background: linear-gradient(180deg, #4a90d9 0%, #1a3a8c 50%, #0d1f5c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(1px 1px 0px rgba(255, 255, 255, 0.3)) drop-shadow(-0.5px -0.5px 0px rgba(0, 30, 100, 0.4));
            text-decoration: none;
        }
    </style>
</head>

<body>
    <!-- Search offcanvas -->
    <div class="offcanvas offcanvas-top" id="searchBox" data-bs-backdrop="static" tabindex="-1">
        <div class="offcanvas-header border-bottom p-0 py-lg-1">
            <form class="container d-flex align-items-center">
                <input type="search" class="form-control form-control-lg fs-lg border-0 rounded-0 py-3 ps-0"
                    placeholder="Bạn muốn tìm gì?" data-autofocus="offcanvas" />
                <button type="reset" class="btn-close fs-lg" data-bs-dismiss="offcanvas"></button>
            </form>
        </div>
        <div class="offcanvas-body px-0">
            <div class="container text-center">
                <img src="{{ asset('assets/img/icons/search.svg') }}" class="text-body-tertiary opacity-60 mb-4"
                    alt="Search" />
                <h6 class="mb-2">Kết quả tìm kiếm của bạn sẽ xuất hiện ở đây</h6>
                <p class="fs-sm mb-0">Bắt đầu nhập vào trường tìm kiếm ở trên để xem kết quả tìm kiếm ngay lập tức.</p>
            </div>
        </div>
    </div>

    <!-- Bộ lọc offcanvas -->
    <div class="offcanvas offcanvas-end pb-sm-2 px-sm-2" id="shoppingCart" tabindex="-1" style="width:420px">

        <!-- Header -->
        <div class="offcanvas-header py-3 pt-lg-4">
            <h4 class="offcanvas-title">Bộ lọc</h4>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <!-- Body -->
        <div class="offcanvas-body pt-2 pb-5">

            <!-- Danh mục cho thuê -->
            <div class="mb-4">
                <h6 class="fw-semibold mb-3">Danh mục cho thuê</h6>
                <div class="d-flex flex-wrap gap-2">
                    <label class="d-flex flex-column align-items-center gap-1 cursor-pointer">
                        <input type="radio" name="danhmuc" class="d-none" checked />
                        <span class="filter-cat-btn border rounded-3 px-2 py-2 text-center active"
                            style="min-width:68px; font-size:11px;">
                            <i class="ci-home d-block fs-5 mb-1"></i>Phòng trọ
                        </span>
                    </label>
                    <label class="d-flex flex-column align-items-center gap-1 cursor-pointer">
                        <input type="radio" name="danhmuc" class="d-none" />
                        <span class="filter-cat-btn border rounded-3 px-2 py-2 text-center"
                            style="min-width:68px; font-size:11px;">
                            <i class="ci-building d-block fs-5 mb-1"></i>Nhà riêng
                        </span>
                    </label>
                    <label class="d-flex flex-column align-items-center gap-1 cursor-pointer">
                        <input type="radio" name="danhmuc" class="d-none" />
                        <span class="filter-cat-btn border rounded-3 px-2 py-2 text-center"
                            style="min-width:68px; font-size:11px;">
                            <i class="ci-users d-block fs-5 mb-1"></i>Ở ghép
                        </span>
                    </label>
                    <label class="d-flex flex-column align-items-center gap-1 cursor-pointer">
                        <input type="radio" name="danhmuc" class="d-none" />
                        <span class="filter-cat-btn border rounded-3 px-2 py-2 text-center"
                            style="min-width:68px; font-size:11px;">
                            <i class="ci-layout d-block fs-5 mb-1"></i>Mặt bằng
                        </span>
                    </label>
                    <label class="d-flex flex-column align-items-center gap-1 cursor-pointer">
                        <input type="radio" name="danhmuc" class="d-none" />
                        <span class="filter-cat-btn border rounded-3 px-2 py-2 text-center"
                            style="min-width:68px; font-size:11px;">
                            <i class="ci-apartment d-block fs-5 mb-1"></i>Căn hộ chung cư
                        </span>
                    </label>
                    <label class="d-flex flex-column align-items-center gap-1 cursor-pointer">
                        <input type="radio" name="danhmuc" class="d-none" />
                        <span class="filter-cat-btn border rounded-3 px-2 py-2 text-center"
                            style="min-width:68px; font-size:11px;">
                            <i class="ci-home d-block fs-5 mb-1"></i>Căn hộ mini
                        </span>
                    </label>
                    <label class="d-flex flex-column align-items-center gap-1 cursor-pointer">
                        <input type="radio" name="danhmuc" class="d-none" />
                        <span class="filter-cat-btn border rounded-3 px-2 py-2 text-center"
                            style="min-width:68px; font-size:11px;">
                            <i class="ci-building d-block fs-5 mb-1"></i>Căn hộ dịch vụ
                        </span>
                    </label>
                </div>
            </div>

            <hr class="my-3" />

            <!-- Lọc theo khu vực -->
            <div class="mb-4">
                <h6 class="fw-semibold mb-3">Lọc theo khu vực</h6>
                <div class="row g-2">
                    <!-- <div class="col-12">
                        <label class="form-label fs-xs text-body-secondary mb-1">Tỉnh thành</label>
                        <select class="form-select form-select-sm rounded-3">
                            <option>Toàn quốc</option>
                            <option>Hồ Chí Minh</option>
                            <option>Hà Nội</option>
                            <option>Đà Nẵng</option>
                            <option>Cần Thơ</option>
                            <option selected>An Giang</option>
                        </select>
                    </div> -->
                    <div class="col-6">
                        <label class="form-label fs-xs text-body-secondary mb-1">Tỉnh thành</label>
                        <select class="form-select form-select-sm rounded-3">
                            <option>Tất cả</option>
                            <option>Long Xuyên</option>
                            <option>Châu Đốc</option>
                            <option>Tân Châu</option>
                            <option>An Phú</option>
                            <option>Châu Phú</option>
                            <option>Tịnh Biên</option>
                            <option>Tri Tôn</option>
                            <option>Chợ Mới</option>
                            <option>Phú Tân</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fs-xs text-body-secondary mb-1">Phường xã</label>
                        <select class="form-select form-select-sm rounded-3">
                            <option>Tất cả</option>
                            <option>Phường Mỹ Bình</option>
                            <option>Phường Mỹ Long</option>
                            <option>Phường Đông Xuyên</option>
                            <option>Phường Mỹ Xuyên</option>
                            <option>Phường Bình Đức</option>
                            <option>Phường Bình Khánh</option>
                            <option>Phường Mỹ Phước</option>
                            <option>Phường Mỹ Quý</option>
                            <option>Phường Mỹ Thạnh</option>
                            <option>Xã Núi Sam</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr class="my-3" />

            <!-- Khoảng giá -->
            <div class="mb-4">
                <h6 class="fw-semibold mb-3">Khoảng giá</h6>
                <div class="d-flex flex-wrap gap-2">
                    <label>
                        <input type="radio" name="gia" class="d-none" checked />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs active">Tất cả</span>
                    </label>
                    <label>
                        <input type="radio" name="gia" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Dưới 1 triệu</span>
                    </label>
                    <label>
                        <input type="radio" name="gia" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">1 - 2 triệu</span>
                    </label>
                    <label>
                        <input type="radio" name="gia" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">2 - 3 triệu</span>
                    </label>
                    <label>
                        <input type="radio" name="gia" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">3 - 5 triệu</span>
                    </label>
                    <label>
                        <input type="radio" name="gia" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">5 - 7 triệu</span>
                    </label>
                    <label>
                        <input type="radio" name="gia" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">7 - 10 triệu</span>
                    </label>
                    <label>
                        <input type="radio" name="gia" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">10 - 15 triệu</span>
                    </label>
                    <label>
                        <input type="radio" name="gia" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Trên 15 triệu</span>
                    </label>
                </div>
            </div>

            <hr class="my-3" />

            <!-- Khoảng diện tích -->
            <div class="mb-4">
                <h6 class="fw-semibold mb-3">Khoảng diện tích</h6>
                <div class="d-flex flex-wrap gap-2">
                    <label>
                        <input type="radio" name="dientich" class="d-none" checked />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs active">Tất cả</span>
                    </label>
                    <label>
                        <input type="radio" name="dientich" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Dưới 20m²</span>
                    </label>
                    <label>
                        <input type="radio" name="dientich" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Từ 20m² - 30m²</span>
                    </label>
                    <label>
                        <input type="radio" name="dientich" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Từ 30m² - 50m²</span>
                    </label>
                    <label>
                        <input type="radio" name="dientich" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Từ 50m² - 70m²</span>
                    </label>
                    <label>
                        <input type="radio" name="dientich" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Từ 70m² - 90m²</span>
                    </label>
                    <label>
                        <input type="radio" name="dientich" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Trên 90m²</span>
                    </label>
                </div>
            </div>

            <hr class="my-3" />

            <!-- Đặc điểm nổi bật -->
            <div class="mb-4">
                <h6 class="fw-semibold mb-3">Đặc điểm nổi bật</h6>
                <div class="d-flex flex-wrap gap-2">
                    <label>
                        <input type="checkbox" name="dacbiet" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Đầy đủ nội thất</span>
                    </label>
                    <label>
                        <input type="checkbox" name="dacbiet" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Có gác</span>
                    </label>
                    <label>
                        <input type="checkbox" name="dacbiet" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Kệ bếp</span>
                    </label>
                    <label>
                        <input type="checkbox" name="dacbiet" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Có máy lạnh</span>
                    </label>
                    <label>
                        <input type="checkbox" name="dacbiet" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Có máy giặt</span>
                    </label>
                    <label>
                        <input type="checkbox" name="dacbiet" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Có tủ lạnh</span>
                    </label>
                    <label>
                        <input type="checkbox" name="dacbiet" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Có thang máy</span>
                    </label>
                    <label>
                        <input type="checkbox" name="dacbiet" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Không chung chủ</span>
                    </label>
                    <label>
                        <input type="checkbox" name="dacbiet" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Giờ giấc tự do</span>
                    </label>
                    <label>
                        <input type="checkbox" name="dacbiet" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Có bảo vệ 24/24</span>
                    </label>
                    <label>
                        <input type="checkbox" name="dacbiet" class="d-none" />
                        <span class="filter-tag-btn border rounded-pill px-3 py-1 fs-xs">Có hầm để xe</span>
                    </label>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="offcanvas-header border-top">
            <button class="btn btn-lg btn-primary w-100 rounded-pill">Áp dụng</button>
        </div>

    </div>

    <style>
        /* Tag buttons (giá, diện tích, đặc điểm) */
        .filter-tag-btn {
            display: inline-block;
            cursor: pointer;
            transition: all .18s ease;
            color: var(--cz-body-color);
            background: transparent;
            user-select: none;
            white-space: nowrap;
        }

        .filter-tag-btn:hover {
            border-color: var(--cz-primary) !important;
            color: var(--cz-primary);
        }

        input:checked+.filter-tag-btn,
        .filter-tag-btn.active {
            background: color-mix(in srgb, var(--cz-primary) 10%, transparent);
            border-color: var(--cz-primary) !important;
            color: var(--cz-primary);
            font-weight: 600;
        }

        /* Category icon buttons */
        .filter-cat-btn {
            display: inline-block;
            cursor: pointer;
            transition: all .18s ease;
            color: var(--cz-body-color);
            background: transparent;
            user-select: none;
            line-height: 1.3;
        }

        .filter-cat-btn:hover {
            border-color: var(--cz-primary) !important;
            color: var(--cz-primary);
        }

        input:checked+.filter-cat-btn,
        .filter-cat-btn.active {
            background: color-mix(in srgb, var(--cz-primary) 10%, transparent);
            border-color: var(--cz-primary) !important;
            color: var(--cz-primary);
            font-weight: 600;
        }
    </style>

    <!-- Navigation bar (Page header) -->
    <header class="navbar navbar-expand-lg bg-body navbar-sticky sticky-top z-fixed px-0" data-sticky-element>
        <div class="container flex-nowrap">
            <!-- Mobile toggler -->
            <button type="button" class="navbar-toggler me-4 me-lg-0" data-bs-toggle="offcanvas"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar brand (Logo) -->
            <a class="navbar-brand py-1 py-md-2 py-xl-1" href="{{ route('frontend.home') }}">
                <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo" style="height:40px;">
                {{ config('app.name', 'Laravel') }}
            </a>

            <!-- Main navigation -->
            <nav class="offcanvas offcanvas-start" id="navbarNav" tabindex="-1">
                <div class="offcanvas-header py-3">
                    <a class="navbar-brand py-1 py-md-2 py-xl-1" href="{{ route('frontend.home') }}">
                        <img src="{{ asset('storage/logo/logo.png') }}" alt="Logo" style="height:40px;">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body pt-3 pb-4 py-lg-0 mx-lg-auto">
                    <ul class="navbar-nav align-items-lg-center">

                        <!-- Đề xuất -->
                        <li class="nav-item py-lg-2">
                            <a class="nav-link d-flex align-items-center" href="{{ route('frontend.home') }}">
                                <i class="ci-home me-2"></i> Đề xuất
                            </a>
                        </li>

                        <!-- mới nhất -->
                        <li class="nav-item py-lg-2">
                            <a class="nav-link d-flex align-items-center" href="{{ route('frontend.new_post') }}">
                                <i class="ci-home me-2"></i> Mới nhất
                            </a>
                        </li>

                        <!-- Sản phẩm -->
                        <li class="nav-item dropdown py-lg-2">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                <i class="ci-gift me-2"></i> Danh mục
                            </a>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Điện thoại</a></li>
                                <li><a class="dropdown-item" href="#">Máy tính bảng</a></li>
                                <li><a class="dropdown-item" href="#">Máy tính xách tay</a></li>
                            </ul>
                        </li>

                        <!-- Tin tức -->
                        <li class="nav-item py-lg-2">
                            <a class="nav-link d-flex align-items-center" href="#">
                                <i class="ci-globe me-2"></i> Tin tức
                            </a>
                        </li>

                        <!-- Tuyển dụng -->
                        <li class="nav-item py-lg-2">
                            <a class="nav-link d-flex align-items-center" href="#">
                                <i class="ci-target me-2"></i> Tuyển dụng
                            </a>
                        </li>

                        <!-- Bộ lọc -->
                        <li class="nav-item py-lg-2 ms-lg-2">
                            <button type="button"
                                class="btn btn-outline-secondary rounded-pill d-flex align-items-center px-3"
                                data-bs-toggle="offcanvas" data-bs-target="#shoppingCart">
                                <i class="ci-filter me-2"></i> Bộ lọc
                            </button>
                        </li>

                    </ul>
                </div>
                <div class="offcanvas-header nav border-top px-0 py-3 mt-3 d-md-none">
                    <a class="nav-link justify-content-center w-100" href="">
                        <i class="ci-user fs-lg opacity-60 ms-n2 me-2"></i>
                        Tài khoản
                    </a>
                </div>
            </nav>

            <!-- Button group -->
            <div class="d-flex align-items-center">
                <!-- Theme switcher (light/dark/auto) -->
                <div class="dropdown">
                    <button type="button"
                        class="theme-switcher btn btn-icon btn-lg btn-outline-secondary fs-lg border-0 rounded-circle animate-scale"
                        data-bs-toggle="dropdown">
                        <span class="theme-icon-active d-flex animate-target">
                            <i class="ci-sun"></i>
                        </span>
                    </button>
                    <ul class="dropdown-menu" style="--cz-dropdown-min-width:9rem">
                        <li>
                            <button type="button" class="dropdown-item active" data-bs-theme-value="light">
                                <span class="theme-icon d-flex fs-base me-2"><i class="ci-sun"></i></span>
                                <span class="theme-label">Sáng</span>
                                <i class="item-active-indicator ci-check ms-auto"></i>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item" data-bs-theme-value="dark">
                                <span class="theme-icon d-flex fs-base me-2"><i class="ci-moon"></i></span>
                                <span class="theme-label">Tối</span>
                                <i class="item-active-indicator ci-check ms-auto"></i>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item" data-bs-theme-value="auto">
                                <span class="theme-icon d-flex fs-base me-2"><i class="ci-auto"></i></span>
                                <span class="theme-label">Tự động</span>
                                <i class="item-active-indicator ci-check ms-auto"></i>
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Search toggle button -->
                <button type="button"
                    class="btn btn-icon btn-lg fs-xl btn-outline-secondary border-0 rounded-circle animate-shake"
                    data-bs-toggle="offcanvas" data-bs-target="#searchBox">
                    <i class="ci-search animate-target"></i>
                </button>

                <!-- Account button visible on screens > 768px wide (md breakpoint) -->
                <a class="btn btn-icon btn-lg fs-lg btn-outline-secondary border-0 rounded-circle animate-shake d-none d-md-inline-flex"
                    href="">
                    <i class="ci-user animate-target"></i>
                    <span class="visually-hidden">Tài khoản</span>
                </a>

                <!-- Cart button -->

            </div>
        </div>
    </header>

    <!-- Page content -->
    @yield('content')

    <!-- Page footer -->
    <footer class="footer pb-4">
        <div class="container pt-sm-2 pt-md-3 pt-lg-4">
            <div class="d-lg-flex align-items-center border-top pt-4 mt-3">
                <div class="d-flex gap-2 gap-sm-3 justify-content-center ms-lg-auto mb-3 mb-md-4 mb-lg-0 order-lg-2">
                    <div>
                        <img src="{{ asset('assets/img/payment-methods/visa-light-mode.svg') }}" class="d-none-dark"
                            alt="Visa" />
                        <img src="{{ asset('assets/img/payment-methods/visa-dark-mode.svg') }}"
                            class="d-none d-block-dark" alt="Visa" />
                    </div>
                    <div>
                        <img src="{{ asset('assets/img/payment-methods/paypal-light-mode.svg') }}" class="d-none-dark"
                            alt="PayPal" />
                        <img src="{{ asset('assets/img/payment-methods/paypal-dark-mode.svg') }}"
                            class="d-none d-block-dark" alt="PayPal" />
                    </div>
                    <div>
                        <img src="{{ asset('assets/img/payment-methods/mastercard.svg') }}" alt="Mastercard" />
                    </div>
                    <div>
                        <img src="{{ asset('assets/img/payment-methods/google-pay-light-mode.svg') }}"
                            class="d-none-dark" alt="Google Pay" />
                        <img src="{{ asset('assets/img/payment-methods/google-pay-dark-mode.svg') }}"
                            class="d-none d-block-dark" alt="Google Pay" />
                    </div>
                    <div>
                        <img src="{{ asset('assets/img/payment-methods/apple-pay-light-mode.svg') }}"
                            class="d-none-dark" alt="Apple Pay" />
                        <img src="{{ asset('assets/img/payment-methods/apple-pay-dark-mode.svg') }}"
                            class="d-none d-block-dark" alt="Apple Pay" />
                    </div>
                </div>
                <div class="d-md-flex justify-content-center order-lg-1">
                    <ul class="nav justify-content-center gap-4 order-md-3 mb-4 mb-md-0">
                        <li class="animate-underline">
                            <a class="nav-link fs-xs fw-normal p-0 animate-target" href="#">Chính sách</a>
                        </li>
                        <li class="animate-underline">
                            <a class="nav-link fs-xs fw-normal p-0 animate-target" href="#">Điều khoản sử dụng</a>
                        </li>
                        <li class="animate-underline">
                            <a class="nav-link fs-xs fw-normal p-0 animate-target" href="#">Hợp tác quảng cáo</a>
                        </li>
                    </ul>
                    <div class="vr text-body-secondary opacity-25 mx-4 d-none d-md-inline-block order-md-2"></div>
                    <p class="fs-xs text-center text-lg-start mb-0 order-md-1">
                        Bản quyền &copy; bởi <span class="animate-underline"><a
                                class="animate-target text-dark-emphasis text-decoration-none" href="#"
                                target="_blank">{{ config('app.name', 'Laravel') }}</a></span>.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to top button -->
    <div class="floating-buttons position-fixed top-50 end-0 z-sticky me-3 me-xl-4 pb-4">
        <a class="btn-scroll-top btn btn-sm bg-body border-0 rounded-pill shadow animate-slide-end" href="#top">
            Top
            <i class="ci-arrow-right fs-base ms-1 me-n1 animate-target"></i>
            <span class="position-absolute top-0 start-0 w-100 h-100 border rounded-pill z-0"></span>
            <svg class="position-absolute top-0 start-0 w-100 h-100 z-1" viewBox="0 0 62 32" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect x=".75" y=".75" width="60.5" height="30.5" rx="15.25" stroke="currentColor" stroke-width="1.5"
                    stroke-miterlimit="10" />
            </svg>
        </a>
    </div>

    @yield('floating-button')

    <!-- Vendor scripts -->
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/choices.js/choices.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/cleave.js/cleave.min.js') }}"></script>
    @yield('javascript')

    <!-- Bootstrap + Theme scripts -->
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>
</body>

</html>