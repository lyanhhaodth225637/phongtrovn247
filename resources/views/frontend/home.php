@extends('layouts.frontend.app')
@section('content')
    <main class="content-wrapper">
        <section class="container pt-3 mb-4">
            <div class="row">
                <div class="col-12">
                    <div class="position-relative">
                        <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none-dark rtl-flip"
                            style="background:linear-gradient(90deg, #e8f4fd 0%, #eaf7ec 100%)"></span>
                        <span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none d-block-dark rtl-flip"
                            style="background:linear-gradient(90deg, #1a2a1e 0%, #1a2632 100%)"></span>
                        <div class="row justify-content-center position-relative z-2">
                            <div class="col-xl-5 col-xxl-4 offset-xxl-1 d-flex align-items-center mt-xl-n3">
                                <div class="swiper px-5 pe-xl-0 ps-xxl-0 me-xl-n5"
                                    data-swiper='{"spaceBetween": 64, "loop": true, "speed": 400, "controlSlider": "#sliderImages", "autoplay": {"delay": 5500, "disableOnInteraction": false}, "scrollbar": {"el": ".swiper-scrollbar"}}'>
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide text-center text-xl-start pt-5 py-xl-5">
                                            <p class="text-body">🏠 Phòng trọ giá tốt - Ký ngay hôm nay</p>
                                            <h2 class="display-4 pb-2 pb-xl-4">Phòng Trọ Cao Cấp<br>Giá Tốt Nhất</h2>
                                            <a class="btn btn-lg btn-primary" href="#">
                                                Tìm phòng ngay <i class="ci-arrow-up-right fs-lg ms-2 me-n1"></i>
                                            </a>
                                        </div>
                                        <div class="swiper-slide text-center text-xl-start pt-5 py-xl-5">
                                            <p class="text-body">🏢 Căn hộ mini - Full nội thất</p>
                                            <h2 class="display-4 pb-2 pb-xl-4">Căn Hộ Studio<br>Full Tiện Nghi</h2>
                                            <a class="btn btn-lg btn-primary" href="#">
                                                Xem căn hộ <i class="ci-arrow-up-right fs-lg ms-2 me-n1"></i>
                                            </a>
                                        </div>
                                        <div class="swiper-slide text-center text-xl-start pt-5 py-xl-5">
                                            <p class="text-body">🏡 Nhà nguyên căn - Cho gia đình</p>
                                            <h2 class="display-4 pb-2 pb-xl-4">Nhà Nguyên Căn<br>Giá Hợp Lý</h2>
                                            <a class="btn btn-lg btn-primary" href="#">
                                                Thuê ngay <i class="ci-arrow-up-right fs-lg ms-2 me-n1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9 col-sm-7 col-md-6 col-lg-5 col-xl-7">
                                <div class="swiper user-select-none" id="sliderImages"
                                    data-swiper='{"allowTouchMove": false, "loop": true, "effect": "fade", "fadeEffect": {"crossFade": true}}'>
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide d-flex justify-content-end">
                                            <div class="ratio rtl-flip"
                                                style="max-width:495px; --cz-aspect-ratio:calc(537 / 495 * 100%)">
                                                <img src="assets/img/slider/01.png" alt="Phòng trọ" />
                                            </div>
                                        </div>
                                        <div class="swiper-slide d-flex justify-content-end">
                                            <div class="ratio rtl-flip"
                                                style="max-width:495px; --cz-aspect-ratio:calc(537 / 495 * 100%)">
                                                <img src="assets/img/slider/02.png" alt="Căn hộ studio" />
                                            </div>
                                        </div>
                                        <div class="swiper-slide d-flex justify-content-end">
                                            <div class="ratio rtl-flip"
                                                style="max-width:495px; --cz-aspect-ratio:calc(537 / 495 * 100%)">
                                                <img src="assets/img/slider/03.png" alt="Nhà nguyên căn" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center" data-bs-theme="dark">
                            <div class="col-xxl-10">
                                <div class="position-relative mx-5 mx-xxl-0">
                                    <div class="swiper-scrollbar mb-4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="position-sticky z-3 bg-body shadow-sm" style="top: var(--cz-header-height, 75px)">
            <section class="container mb-2">
                <div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false">
                    <div class="row row-cols-5 g-0" style="min-width:480px">
                        @foreach ($categories as $category)
                            <div class="col">
                                <a class="d-flex flex-column align-items-center justify-content-center py-3 px-2 text-decoration-none gap-1"
                                    href="#">
                                    <span class="fs-xs fw-bold text-body text-center">{{ $category->name }}</span>
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>
            </section>

            <section class="container pt-2 mt-2 mb-0">
                <ul class="nav nav-tabs" id="listingTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-medium px-4" id="tab-dexuat" data-bs-toggle="tab"
                            data-bs-target="#panel-dexuat" type="button" role="tab">
                            <i class="ci-star me-2"></i>Đề xuất
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-medium px-4" id="tab-moidang" data-bs-toggle="tab"
                            data-bs-target="#panel-moidang" type="button" role="tab">
                            <i class="ci-clock me-2"></i>Mới đăng
                        </button>
                    </li>
                </ul>
            </section>
        </div>



        <div class="tab-content" id="listingTabContent">

            <!-- ==========================================
                                             TAB ĐỀ XUẤT: VIP 5 → 1 theo độ ưu tiên
                                        =========================================== -->
            <div class="tab-pane fade show active" id="panel-dexuat" role="tabpanel">

                <!-- TIN VIP 5 -->
                <section class="container pt-3 mb-4">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 pb-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge px-2 py-1 fs-xs fw-bold"
                                style="background:linear-gradient(135deg,#ff6b00,#ff9a00);color:#fff;border-radius:6px;">⭐⭐⭐
                                VIP 5</span>
                            <h2 class="h3 mb-0">Tin Kim Cương Đặc Biệt</h2>
                        </div>
                        <div class="nav ms-3">
                            <a class="nav-link animate-underline px-0 py-2" href="#">
                                <span class="animate-target">Xem tất cả</span> <i class="ci-chevron-right fs-base ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row g-3 pt-4">

                        <!-- VIP5 Item 1 -->
                        <div class="col-12 col-md-6">
                            <div class="card border-0 rounded-4 overflow-hidden h-100 position-relative"
                                style="box-shadow:0 4px 24px rgba(255,107,0,.18);">
                                <div class="position-absolute top-0 start-0 z-2 m-2">
                                    <span class="badge px-2 py-1 fs-xs fw-bold"
                                        style="background:linear-gradient(135deg,#ff6b00,#ff9a00);color:#fff;">⭐ VIP 5
                                        ⭐</span>
                                </div>
                                <button type="button"
                                    class="btn btn-icon btn-sm btn-light position-absolute top-0 end-0 m-2 z-2 rounded-circle">
                                    <i class="ci-heart fs-sm"></i>
                                </button>
                                <a href="#" class="d-block overflow-hidden" style="height:220px;">
                                    <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                        alt="Căn hộ Bình Thạnh" />
                                </a>
                                <div class="card-body px-3 py-3">
                                    <h3 class="fs-sm fw-semibold mb-2 lh-base">
                                        <a href="#" class="text-body text-decoration-none">
                                            Cho thuê căn hộ cao cấp 2PN full nội thất tại Q.Bình Thạnh, TP.HCM
                                        </a>
                                    </h3>
                                    <div class="mb-2"><span class="text-primary fw-bold fs-5">6.500.000 đ/tháng</span></div>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="badge bg-light text-body fs-xs"><i class="ci-map-pin me-1"></i>Bình
                                            Thạnh, HCM</span>
                                        <span class="badge bg-light text-body fs-xs"><i
                                                class="ci-maximize me-1"></i>35m²</span>
                                        <span class="badge bg-light text-body fs-xs"><i class="ci-home me-1"></i>2 phòng
                                            ngủ</span>
                                        <span class="badge bg-light text-body fs-xs">Full nội thất</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                                style="width:22px;height:22px;font-size:11px;color:#fff;">A</div>
                                            <span class="fs-xs text-body-secondary">Nguyễn Văn A</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fs-xs text-body-tertiary"><i class="ci-clock me-1"></i>Hôm
                                                nay</span>
                                            <a href="tel:0901234567"
                                                class="btn btn-sm btn-primary rounded-pill py-0 px-2 fs-xs">
                                                <i class="ci-phone me-1"></i>Gọi ngay
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP5 Item 2 -->
                        <div class="col-12 col-md-6">
                            <div class="card border-0 rounded-4 overflow-hidden h-100 position-relative"
                                style="box-shadow:0 4px 24px rgba(255,107,0,.18);">
                                <div class="position-absolute top-0 start-0 z-2 m-2">
                                    <span class="badge px-2 py-1 fs-xs fw-bold"
                                        style="background:linear-gradient(135deg,#ff6b00,#ff9a00);color:#fff;">⭐ VIP 5
                                        ⭐</span>
                                </div>
                                <button type="button"
                                    class="btn btn-icon btn-sm btn-light position-absolute top-0 end-0 m-2 z-2 rounded-circle">
                                    <i class="ci-heart fs-sm"></i>
                                </button>
                                <a href="#" class="d-block overflow-hidden" style="height:220px;">
                                    <img src="assets/img/shop/03.png" class="w-100 h-100 object-fit-cover"
                                        alt="Studio Q.7" />
                                </a>
                                <div class="card-body px-3 py-3">
                                    <h3 class="fs-sm fw-semibold mb-2 lh-base">
                                        <a href="#" class="text-body text-decoration-none">
                                            Studio cao cấp full đồ, ban công thoáng mát Q.7 gần Lotte Mart
                                        </a>
                                    </h3>
                                    <div class="mb-2"><span class="text-primary fw-bold fs-5">5.200.000 đ/tháng</span></div>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="badge bg-light text-body fs-xs"><i class="ci-map-pin me-1"></i>Quận 7,
                                            HCM</span>
                                        <span class="badge bg-light text-body fs-xs"><i
                                                class="ci-maximize me-1"></i>28m²</span>
                                        <span class="badge bg-light text-body fs-xs"><i
                                                class="ci-home me-1"></i>Studio</span>
                                        <span class="badge bg-light text-body fs-xs">Ban công</span>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                                style="width:22px;height:22px;font-size:11px;color:#fff;">B</div>
                                            <span class="fs-xs text-body-secondary">Trần Thị B</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fs-xs text-body-tertiary"><i class="ci-clock me-1"></i>2 giờ
                                                trước</span>
                                            <a href="tel:0912345678"
                                                class="btn btn-sm btn-primary rounded-pill py-0 px-2 fs-xs">
                                                <i class="ci-phone me-1"></i>Gọi ngay
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- TIN VIP 4 -->
                <section class="container pt-2 mb-4">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 pb-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge px-2 py-1 fs-xs fw-bold"
                                style="background:linear-gradient(135deg,#c0392b,#e74c3c);color:#fff;border-radius:6px;">⭐⭐
                                VIP 4</span>
                            <h2 class="h3 mb-0">Tin Nổi Bật</h2>
                        </div>
                        <div class="nav ms-3">
                            <a class="nav-link animate-underline px-0 py-2" href="#">
                                <span class="animate-target">Xem tất cả</span> <i class="ci-chevron-right fs-base ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3 pt-4">

                        <!-- VIP4 Item 1 -->
                        <div class="col">
                            <div class="card border-0 rounded-4 overflow-hidden h-100 position-relative"
                                style="box-shadow:0 2px 16px rgba(192,57,43,.12);">
                                <div class="position-absolute top-0 start-0 z-2 m-2">
                                    <span class="badge px-2 py-1 fs-xs fw-bold"
                                        style="background:linear-gradient(135deg,#c0392b,#e74c3c);color:#fff;">⭐ VIP
                                        4</span>
                                </div>
                                <button type="button"
                                    class="btn btn-icon btn-sm btn-light position-absolute top-0 end-0 m-2 z-2 rounded-circle">
                                    <i class="ci-heart fs-sm"></i>
                                </button>
                                <a href="#" class="d-block overflow-hidden" style="height:180px;">
                                    <img src="assets/img/shop/05.png" class="w-100 h-100 object-fit-cover"
                                        alt="Phòng trọ Q.4" />
                                </a>
                                <div class="card-body px-3 py-3">
                                    <h3 class="fs-sm fw-semibold mb-2 lh-base"
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.6em;">
                                        <a href="#" class="text-body text-decoration-none">
                                            Phòng trọ cao cấp có máy lạnh, WC riêng, gần ĐH Nguyễn Tất Thành
                                        </a>
                                    </h3>
                                    <div class="mb-2"><span class="text-danger fw-bold">2.800.000 đ/tháng</span></div>
                                    <div class="d-flex flex-wrap gap-1 mb-3">
                                        <span class="badge bg-light text-body fs-xs"><i class="ci-map-pin me-1"></i>Q.4,
                                            HCM</span>
                                        <span class="badge bg-light text-body fs-xs"><i
                                                class="ci-maximize me-1"></i>20m²</span>
                                        <span class="badge bg-light text-body fs-xs">Phòng trọ</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                        <span class="fs-xs text-body-tertiary"><i class="ci-clock me-1"></i>3 giờ
                                            trước</span>
                                        <a href="tel:0923456789"
                                            class="btn btn-sm btn-outline-primary rounded-pill py-0 px-2 fs-xs">
                                            <i class="ci-phone me-1"></i>Gọi ngay
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP4 Item 2 -->
                        <div class="col">
                            <div class="card border-0 rounded-4 overflow-hidden h-100 position-relative"
                                style="box-shadow:0 2px 16px rgba(192,57,43,.12);">
                                <div class="position-absolute top-0 start-0 z-2 m-2">
                                    <span class="badge px-2 py-1 fs-xs fw-bold"
                                        style="background:linear-gradient(135deg,#c0392b,#e74c3c);color:#fff;">⭐ VIP
                                        4</span>
                                </div>
                                <button type="button"
                                    class="btn btn-icon btn-sm btn-light position-absolute top-0 end-0 m-2 z-2 rounded-circle">
                                    <i class="ci-heart fs-sm"></i>
                                </button>
                                <a href="#" class="d-block overflow-hidden" style="height:180px;">
                                    <img src="assets/img/shop/05.png" class="w-100 h-100 object-fit-cover"
                                        alt="Căn hộ 1PN Tân Phú" />
                                </a>
                                <div class="card-body px-3 py-3">
                                    <h3 class="fs-sm fw-semibold mb-2 lh-base"
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.6em;">
                                        <a href="#" class="text-body text-decoration-none">
                                            Căn hộ 1PN đầy đủ nội thất, view đẹp, khu vực Tân Phú
                                        </a>
                                    </h3>
                                    <div class="mb-2"><span class="text-danger fw-bold">4.500.000 đ/tháng</span></div>
                                    <div class="d-flex flex-wrap gap-1 mb-3">
                                        <span class="badge bg-light text-body fs-xs"><i class="ci-map-pin me-1"></i>Tân Phú,
                                            HCM</span>
                                        <span class="badge bg-light text-body fs-xs"><i
                                                class="ci-maximize me-1"></i>30m²</span>
                                        <span class="badge bg-light text-body fs-xs">Căn hộ</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                        <span class="fs-xs text-body-tertiary"><i class="ci-clock me-1"></i>5 giờ
                                            trước</span>
                                        <a href="tel:0934567890"
                                            class="btn btn-sm btn-outline-primary rounded-pill py-0 px-2 fs-xs">
                                            <i class="ci-phone me-1"></i>Gọi ngay
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP4 Item 3 -->
                        <div class="col">
                            <div class="card border-0 rounded-4 overflow-hidden h-100 position-relative"
                                style="box-shadow:0 2px 16px rgba(192,57,43,.12);">
                                <div class="position-absolute top-0 start-0 z-2 m-2">
                                    <span class="badge px-2 py-1 fs-xs fw-bold"
                                        style="background:linear-gradient(135deg,#c0392b,#e74c3c);color:#fff;">⭐ VIP
                                        4</span>
                                </div>
                                <button type="button"
                                    class="btn btn-icon btn-sm btn-light position-absolute top-0 end-0 m-2 z-2 rounded-circle">
                                    <i class="ci-heart fs-sm"></i>
                                </button>
                                <a href="#" class="d-block overflow-hidden" style="height:180px;">
                                    <img src="assets/img/shop/05.png" class="w-100 h-100 object-fit-cover"
                                        alt="Nhà trọ Bình Dương" />
                                </a>
                                <div class="card-body px-3 py-3">
                                    <h3 class="fs-sm fw-semibold mb-2 lh-base"
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.6em;">
                                        <a href="#" class="text-body text-decoration-none">
                                            Phòng trọ giá rẻ an ninh khu vực Bình Dương, gần KCN Sóng Thần
                                        </a>
                                    </h3>
                                    <div class="mb-2"><span class="text-danger fw-bold">1.500.000 đ/tháng</span></div>
                                    <div class="d-flex flex-wrap gap-1 mb-3">
                                        <span class="badge bg-light text-body fs-xs"><i class="ci-map-pin me-1"></i>Bình
                                            Dương</span>
                                        <span class="badge bg-light text-body fs-xs"><i
                                                class="ci-maximize me-1"></i>18m²</span>
                                        <span class="badge bg-light text-body fs-xs">Phòng trọ</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                        <span class="fs-xs text-body-tertiary"><i class="ci-clock me-1"></i>1 ngày
                                            trước</span>
                                        <a href="tel:0945678901"
                                            class="btn btn-sm btn-outline-primary rounded-pill py-0 px-2 fs-xs">
                                            <i class="ci-phone me-1"></i>Gọi ngay
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- TIN VIP 3 -->
                <section class="container pt-2 mb-4">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 pb-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge px-2 py-1 fs-xs fw-bold"
                                style="background:linear-gradient(135deg,#8e44ad,#9b59b6);color:#fff;border-radius:6px;">⭐
                                VIP 3</span>
                            <h2 class="h3 mb-0">Tin Ưu Tiên</h2>
                        </div>
                        <div class="nav ms-3">
                            <a class="nav-link animate-underline px-0 py-2" href="#">
                                <span class="animate-target">Xem tất cả</span> <i class="ci-chevron-right fs-base ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 pt-4">

                        <!-- VIP3 Item 1 -->
                        <div class="col">
                            <div
                                class="product-card animate-underline hover-effect-opacity bg-body rounded position-relative">
                                <div class="position-absolute top-0 start-0 z-2 mt-2 ms-2" style="pointer-events:none">
                                    <span class="badge fs-xs fw-bold"
                                        style="background:linear-gradient(135deg,#8e44ad,#9b59b6);color:#fff;">VIP 3</span>
                                </div>
                                <div class="position-absolute top-0 end-0 z-2 mt-2 me-2">
                                    <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body rounded-circle">
                                        <i class="ci-heart fs-xs"></i>
                                    </button>
                                </div>
                                <a class="d-block rounded-top overflow-hidden" href="#" style="height:150px;">
                                    <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                        alt="Phòng gác lửng Gò Vấp" />
                                </a>
                                <div class="w-100 min-w-0 px-2 pb-2 pt-2 px-sm-3 pb-sm-3">
                                    <h3 class="pb-1 mb-1"
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.5em;">
                                        <a class="d-block fs-xs fw-medium text-body text-decoration-none" href="#">
                                            <span class="animate-target">Phòng trọ sạch sẽ, có gác lửng, gần chợ Gò
                                                Vấp</span>
                                        </a>
                                    </h3>
                                    <div class="fs-xs text-body-secondary mb-1"><i class="ci-map-pin me-1"></i>Gò Vấp, HCM ·
                                        22m²</div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fw-bold text-primary fs-sm">2.200.000 đ</span>
                                        <span class="fs-xs text-body-tertiary">2 giờ trước</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP3 Item 2 -->
                        <div class="col">
                            <div
                                class="product-card animate-underline hover-effect-opacity bg-body rounded position-relative">
                                <div class="position-absolute top-0 start-0 z-2 mt-2 ms-2" style="pointer-events:none">
                                    <span class="badge fs-xs fw-bold"
                                        style="background:linear-gradient(135deg,#8e44ad,#9b59b6);color:#fff;">VIP 3</span>
                                </div>
                                <div class="position-absolute top-0 end-0 z-2 mt-2 me-2">
                                    <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body rounded-circle">
                                        <i class="ci-heart fs-xs"></i>
                                    </button>
                                </div>
                                <a class="d-block rounded-top overflow-hidden" href="#" style="height:150px;">
                                    <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                        alt="Nhà trọ Thủ Đức" />
                                </a>
                                <div class="w-100 min-w-0 px-2 pb-2 pt-2 px-sm-3 pb-sm-3">
                                    <h3 class="pb-1 mb-1"
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.5em;">
                                        <a class="d-block fs-xs fw-medium text-body text-decoration-none" href="#">
                                            <span class="animate-target">Nhà trọ mới xây, an ninh 24/7, KV Thủ Đức</span>
                                        </a>
                                    </h3>
                                    <div class="fs-xs text-body-secondary mb-1"><i class="ci-map-pin me-1"></i>TP.Thủ Đức ·
                                        25m²</div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fw-bold text-primary fs-sm">2.500.000 đ</span>
                                        <span class="fs-xs text-body-tertiary">4 giờ trước</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP3 Item 3 -->
                        <div class="col">
                            <div
                                class="product-card animate-underline hover-effect-opacity bg-body rounded position-relative">
                                <div class="position-absolute top-0 start-0 z-2 mt-2 ms-2" style="pointer-events:none">
                                    <span class="badge fs-xs fw-bold"
                                        style="background:linear-gradient(135deg,#8e44ad,#9b59b6);color:#fff;">VIP 3</span>
                                </div>
                                <div class="position-absolute top-0 end-0 z-2 mt-2 me-2">
                                    <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body rounded-circle">
                                        <i class="ci-heart fs-xs"></i>
                                    </button>
                                </div>
                                <a class="d-block rounded-top overflow-hidden" href="#" style="height:150px;">
                                    <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                        alt="Phòng máy lạnh Q.12" />
                                </a>
                                <div class="w-100 min-w-0 px-2 pb-2 pt-2 px-sm-3 pb-sm-3">
                                    <h3 class="pb-1 mb-1"
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.5em;">
                                        <a class="d-block fs-xs fw-medium text-body text-decoration-none" href="#">
                                            <span class="animate-target">Phòng máy lạnh, wifi free, nước nóng, Q.12</span>
                                        </a>
                                    </h3>
                                    <div class="fs-xs text-body-secondary mb-1"><i class="ci-map-pin me-1"></i>Quận 12, HCM
                                        · 16m²</div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fw-bold text-primary fs-sm">1.900.000 đ</span>
                                        <span class="fs-xs text-body-tertiary">6 giờ trước</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP3 Item 4 -->
                        <div class="col">
                            <div
                                class="product-card animate-underline hover-effect-opacity bg-body rounded position-relative">
                                <div class="position-absolute top-0 start-0 z-2 mt-2 ms-2" style="pointer-events:none">
                                    <span class="badge fs-xs fw-bold"
                                        style="background:linear-gradient(135deg,#8e44ad,#9b59b6);color:#fff;">VIP 3</span>
                                </div>
                                <div class="position-absolute top-0 end-0 z-2 mt-2 me-2">
                                    <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body rounded-circle">
                                        <i class="ci-heart fs-xs"></i>
                                    </button>
                                </div>
                                <a class="d-block rounded-top overflow-hidden" href="#" style="height:150px;">
                                    <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                        alt="Nhà trọ Hóc Môn" />
                                </a>
                                <div class="w-100 min-w-0 px-2 pb-2 pt-2 px-sm-3 pb-sm-3">
                                    <h3 class="pb-1 mb-1"
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.5em;">
                                        <a class="d-block fs-xs fw-medium text-body text-decoration-none" href="#">
                                            <span class="animate-target">Nhà trọ mới, wc riêng, cửa chống trộm, Hóc
                                                Môn</span>
                                        </a>
                                    </h3>
                                    <div class="fs-xs text-body-secondary mb-1"><i class="ci-map-pin me-1"></i>Hóc Môn, HCM
                                        · 18m²</div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fw-bold text-primary fs-sm">1.700.000 đ</span>
                                        <span class="fs-xs text-body-tertiary">8 giờ trước</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- TIN VIP 2 -->
                <section class="container pt-2 mb-4">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 pb-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-info px-2 py-1 fs-xs fw-bold text-white" style="border-radius:6px;">VIP
                                2</span>
                            <h2 class="h3 mb-0">Tin Đề Xuất</h2>
                        </div>
                        <div class="nav ms-3">
                            <a class="nav-link animate-underline px-0 py-2" href="#">
                                <span class="animate-target">Xem tất cả</span> <i class="ci-chevron-right fs-base ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 pt-4">

                        <!-- VIP2 Item 1 -->
                        <div class="col">
                            <div
                                class="product-card animate-underline hover-effect-opacity bg-body rounded position-relative">
                                <div class="position-absolute top-0 start-0 z-2 mt-2 ms-2" style="pointer-events:none">
                                    <span class="badge bg-info fs-xs fw-bold text-white">VIP 2</span>
                                </div>
                                <div class="position-absolute top-0 end-0 z-2 mt-2 me-2">
                                    <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body rounded-circle">
                                        <i class="ci-heart fs-xs"></i>
                                    </button>
                                </div>
                                <a class="d-block rounded-top overflow-hidden" href="#" style="height:130px;">
                                    <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                        alt="Phòng trọ HUTECH" />
                                </a>
                                <div class="w-100 min-w-0 px-2 pb-2 pt-2 px-sm-3 pb-sm-3">
                                    <h3 class="pb-1 mb-1"
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.5em;">
                                        <a class="d-block fs-xs fw-medium text-body text-decoration-none" href="#">
                                            <span class="animate-target">Phòng trọ bình dân, sạch sẽ, gần trường ĐH
                                                HUTECH</span>
                                        </a>
                                    </h3>
                                    <div class="fs-xs text-body-secondary mb-1"><i class="ci-map-pin me-1"></i>Bình Thạnh,
                                        HCM</div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fw-bold text-primary fs-sm">1.400.000 đ</span>
                                        <span class="text-body-secondary fs-xs">15m²</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP2 Item 2 -->
                        <div class="col">
                            <div
                                class="product-card animate-underline hover-effect-opacity bg-body rounded position-relative">
                                <div class="position-absolute top-0 start-0 z-2 mt-2 ms-2" style="pointer-events:none">
                                    <span class="badge bg-info fs-xs fw-bold text-white">VIP 2</span>
                                </div>
                                <div class="position-absolute top-0 end-0 z-2 mt-2 me-2">
                                    <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body rounded-circle">
                                        <i class="ci-heart fs-xs"></i>
                                    </button>
                                </div>
                                <a class="d-block rounded-top overflow-hidden" href="#" style="height:130px;">
                                    <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                        alt="Nhà trọ Tân Bình" />
                                </a>
                                <div class="w-100 min-w-0 px-2 pb-2 pt-2 px-sm-3 pb-sm-3">
                                    <h3 class="pb-1 mb-1"
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.5em;">
                                        <a class="d-block fs-xs fw-medium text-body text-decoration-none" href="#">
                                            <span class="animate-target">Nhà trọ giá rẻ, an toàn, khu yên tĩnh Tân
                                                Bình</span>
                                        </a>
                                    </h3>
                                    <div class="fs-xs text-body-secondary mb-1"><i class="ci-map-pin me-1"></i>Tân Bình, HCM
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fw-bold text-primary fs-sm">1.600.000 đ</span>
                                        <span class="text-body-secondary fs-xs">17m²</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP2 Item 3 -->
                        <div class="col">
                            <div
                                class="product-card animate-underline hover-effect-opacity bg-body rounded position-relative">
                                <div class="position-absolute top-0 start-0 z-2 mt-2 ms-2" style="pointer-events:none">
                                    <span class="badge bg-info fs-xs fw-bold text-white">VIP 2</span>
                                </div>
                                <div class="position-absolute top-0 end-0 z-2 mt-2 me-2">
                                    <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body rounded-circle">
                                        <i class="ci-heart fs-xs"></i>
                                    </button>
                                </div>
                                <a class="d-block rounded-top overflow-hidden" href="#" style="height:130px;">
                                    <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                        alt="Phòng 1 người Bình Tân" />
                                </a>
                                <div class="w-100 min-w-0 px-2 pb-2 pt-2 px-sm-3 pb-sm-3">
                                    <h3 class="pb-1 mb-1"
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.5em;">
                                        <a class="d-block fs-xs fw-medium text-body text-decoration-none" href="#">
                                            <span class="animate-target">Phòng 1 người ở, wc khép kín, gần KCN Tân
                                                Tạo</span>
                                        </a>
                                    </h3>
                                    <div class="fs-xs text-body-secondary mb-1"><i class="ci-map-pin me-1"></i>Bình Tân, HCM
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fw-bold text-primary fs-sm">1.300.000 đ</span>
                                        <span class="text-body-secondary fs-xs">14m²</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP2 Item 4 -->
                        <div class="col">
                            <div
                                class="product-card animate-underline hover-effect-opacity bg-body rounded position-relative">
                                <div class="position-absolute top-0 start-0 z-2 mt-2 ms-2" style="pointer-events:none">
                                    <span class="badge bg-info fs-xs fw-bold text-white">VIP 2</span>
                                </div>
                                <div class="position-absolute top-0 end-0 z-2 mt-2 me-2">
                                    <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body rounded-circle">
                                        <i class="ci-heart fs-xs"></i>
                                    </button>
                                </div>
                                <a class="d-block rounded-top overflow-hidden" href="#" style="height:130px;">
                                    <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                        alt="Phòng Phú Nhuận" />
                                </a>
                                <div class="w-100 min-w-0 px-2 pb-2 pt-2 px-sm-3 pb-sm-3">
                                    <h3 class="pb-1 mb-1"
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.5em;">
                                        <a class="d-block fs-xs fw-medium text-body text-decoration-none" href="#">
                                            <span class="animate-target">Phòng trọ mới sơn, cửa khóa riêng khu Phú
                                                Nhuận</span>
                                        </a>
                                    </h3>
                                    <div class="fs-xs text-body-secondary mb-1"><i class="ci-map-pin me-1"></i>Phú Nhuận,
                                        HCM</div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fw-bold text-primary fs-sm">1.800.000 đ</span>
                                        <span class="text-body-secondary fs-xs">16m²</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- TIN VIP 1 -->
                <section class="container pt-2 mb-5">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 pb-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-secondary px-2 py-1 fs-xs fw-bold text-white"
                                style="border-radius:6px;">VIP 1</span>
                            <h2 class="h3 mb-0">Tin Mới Đăng</h2>
                        </div>
                        <div class="nav ms-3">
                            <a class="nav-link animate-underline px-0 py-2" href="#">
                                <span class="animate-target">Xem tất cả</span> <i class="ci-chevron-right fs-base ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-2 pt-4">

                        <!-- VIP1 Item 1 -->
                        <div class="card border rounded-3 overflow-hidden">
                            <div class="row g-0 align-items-center">
                                <div class="col-4 col-sm-3 col-md-2">
                                    <a href="#" class="d-block overflow-hidden" style="height:90px;">
                                        <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                            alt="Phòng Bình Chánh" />
                                    </a>
                                </div>
                                <div class="col-8 col-sm-9 col-md-10">
                                    <div class="card-body py-2 px-3">
                                        <div class="d-flex align-items-start justify-content-between gap-1 mb-1">
                                            <span class="badge bg-secondary fs-xs text-white">VIP 1</span>
                                            <span class="fs-xs text-body-tertiary text-nowrap"><i
                                                    class="ci-clock me-1"></i>10 phút trước</span>
                                        </div>
                                        <h3 class="fs-sm fw-medium mb-1 lh-base"
                                            style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                            <a href="#" class="text-body text-decoration-none">
                                                Phòng trọ bình dân 1,1 triệu khu vực Bình Chánh, đường xe buýt đi được
                                            </a>
                                        </h3>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <span class="fw-bold text-primary fs-sm">1.100.000 đ/tháng</span>
                                            <span class="text-body-secondary fs-xs"><i class="ci-map-pin me-1"></i>Bình
                                                Chánh, HCM</span>
                                            <span class="text-body-secondary fs-xs">12m²</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP1 Item 2 -->
                        <div class="card border rounded-3 overflow-hidden">
                            <div class="row g-0 align-items-center">
                                <div class="col-4 col-sm-3 col-md-2">
                                    <a href="#" class="d-block overflow-hidden" style="height:90px;">
                                        <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                            alt="Phòng Tân Phú" />
                                    </a>
                                </div>
                                <div class="col-8 col-sm-9 col-md-10">
                                    <div class="card-body py-2 px-3">
                                        <div class="d-flex align-items-start justify-content-between gap-1 mb-1">
                                            <span class="badge bg-secondary fs-xs text-white">VIP 1</span>
                                            <span class="fs-xs text-body-tertiary text-nowrap"><i
                                                    class="ci-clock me-1"></i>30 phút trước</span>
                                        </div>
                                        <h3 class="fs-sm fw-medium mb-1 lh-base"
                                            style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                            <a href="#" class="text-body text-decoration-none">
                                                Cần cho thuê phòng trọ thoáng mát, gần chợ, giờ tự do
                                            </a>
                                        </h3>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <span class="fw-bold text-primary fs-sm">1.200.000 đ/tháng</span>
                                            <span class="text-body-secondary fs-xs"><i class="ci-map-pin me-1"></i>Tân Phú,
                                                HCM</span>
                                            <span class="text-body-secondary fs-xs">14m²</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP1 Item 3 -->
                        <div class="card border rounded-3 overflow-hidden">
                            <div class="row g-0 align-items-center">
                                <div class="col-4 col-sm-3 col-md-2">
                                    <a href="#" class="d-block overflow-hidden" style="height:90px;">
                                        <img src="assets/img/shop/05.png" class="w-100 h-100 object-fit-cover"
                                            alt="Nhà trọ Củ Chi" />
                                    </a>
                                </div>
                                <div class="col-8 col-sm-9 col-md-10">
                                    <div class="card-body py-2 px-3">
                                        <div class="d-flex align-items-start justify-content-between gap-1 mb-1">
                                            <span class="badge bg-secondary fs-xs text-white">VIP 1</span>
                                            <span class="fs-xs text-body-tertiary text-nowrap"><i
                                                    class="ci-clock me-1"></i>1 giờ trước</span>
                                        </div>
                                        <h3 class="fs-sm fw-medium mb-1 lh-base"
                                            style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                            <a href="#" class="text-body text-decoration-none">
                                                Nhà trọ nguyên căn 3 phòng cho thuê giá rẻ khu Củ Chi
                                            </a>
                                        </h3>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <span class="fw-bold text-primary fs-sm">3.500.000 đ/tháng</span>
                                            <span class="text-body-secondary fs-xs"><i class="ci-map-pin me-1"></i>Củ Chi,
                                                HCM</span>
                                            <span class="text-body-secondary fs-xs">60m²</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP1 Item 4 -->
                        <div class="card border rounded-3 overflow-hidden">
                            <div class="row g-0 align-items-center">
                                <div class="col-4 col-sm-3 col-md-2">
                                    <a href="#" class="d-block overflow-hidden" style="height:90px;">
                                        <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                            alt="Phòng sinh viên Thủ Đức" />
                                    </a>
                                </div>
                                <div class="col-8 col-sm-9 col-md-10">
                                    <div class="card-body py-2 px-3">
                                        <div class="d-flex align-items-start justify-content-between gap-1 mb-1">
                                            <span class="badge bg-secondary fs-xs text-white">VIP 1</span>
                                            <span class="fs-xs text-body-tertiary text-nowrap"><i
                                                    class="ci-clock me-1"></i>2 giờ trước</span>
                                        </div>
                                        <h3 class="fs-sm fw-medium mb-1 lh-base"
                                            style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                            <a href="#" class="text-body text-decoration-none">
                                                Phòng trọ sinh viên giá 900k gần ĐHQG TPHCM
                                            </a>
                                        </h3>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <span class="fw-bold text-primary fs-sm">900.000 đ/tháng</span>
                                            <span class="text-body-secondary fs-xs"><i class="ci-map-pin me-1"></i>Thủ Đức,
                                                HCM</span>
                                            <span class="text-body-secondary fs-xs">10m²</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP1 Item 5 -->
                        <div class="card border rounded-3 overflow-hidden">
                            <div class="row g-0 align-items-center">
                                <div class="col-4 col-sm-3 col-md-2">
                                    <a href="#" class="d-block overflow-hidden" style="height:90px;">
                                        <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                            alt="Phòng Q.9" />
                                    </a>
                                </div>
                                <div class="col-8 col-sm-9 col-md-10">
                                    <div class="card-body py-2 px-3">
                                        <div class="d-flex align-items-start justify-content-between gap-1 mb-1">
                                            <span class="badge bg-secondary fs-xs text-white">VIP 1</span>
                                            <span class="fs-xs text-body-tertiary text-nowrap"><i
                                                    class="ci-clock me-1"></i>3 giờ trước</span>
                                        </div>
                                        <h3 class="fs-sm fw-medium mb-1 lh-base"
                                            style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                            <a href="#" class="text-body text-decoration-none">
                                                Cho thuê phòng sạch sẽ, an ninh, khu dân cư yên tĩnh Q.9
                                            </a>
                                        </h3>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <span class="fw-bold text-primary fs-sm">1.300.000 đ/tháng</span>
                                            <span class="text-body-secondary fs-xs"><i class="ci-map-pin me-1"></i>Quận 9,
                                                HCM</span>
                                            <span class="text-body-secondary fs-xs">15m²</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP1 Item 6 -->
                        <div class="card border rounded-3 overflow-hidden">
                            <div class="row g-0 align-items-center">
                                <div class="col-4 col-sm-3 col-md-2">
                                    <a href="#" class="d-block overflow-hidden" style="height:90px;">
                                        <img src="assets/img/shop/05.png" class="w-100 h-100 object-fit-cover"
                                            alt="Phòng Biên Hòa" />
                                    </a>
                                </div>
                                <div class="col-8 col-sm-9 col-md-10">
                                    <div class="card-body py-2 px-3">
                                        <div class="d-flex align-items-start justify-content-between gap-1 mb-1">
                                            <span class="badge bg-secondary fs-xs text-white">VIP 1</span>
                                            <span class="fs-xs text-body-tertiary text-nowrap"><i
                                                    class="ci-clock me-1"></i>4 giờ trước</span>
                                        </div>
                                        <h3 class="fs-sm fw-medium mb-1 lh-base"
                                            style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                            <a href="#" class="text-body text-decoration-none">
                                                Phòng trọ cạnh KCN Long Bình, phù hợp công nhân
                                            </a>
                                        </h3>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <span class="fw-bold text-primary fs-sm">1.000.000 đ/tháng</span>
                                            <span class="text-body-secondary fs-xs"><i class="ci-map-pin me-1"></i>Biên Hòa,
                                                Đồng Nai</span>
                                            <span class="text-body-secondary fs-xs">12m²</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="text-center mt-4">
                        <a href="#" class="btn btn-outline-secondary rounded-pill px-5">
                            <i class="ci-refresh-cw me-2"></i>Xem thêm tin đăng
                        </a>
                    </div>
                </section>

            </div>
            <!-- /tab-pane Đề xuất -->

            <!-- ==========================================
                                             TAB MỚI ĐĂNG: tất cả sắp theo thời gian
                                        =========================================== -->
            <div class="tab-pane fade" id="panel-moidang" role="tabpanel">
                <section class="container pt-3 mb-5">

                    <!-- VIP 5 + VIP 4 + VIP 3: lưới 4 cột có nút gọi -->
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 mb-3">

                        <!-- VIP 5 -->
                        <div class="col">
                            <div class="card border-0 rounded-4 overflow-hidden h-100 position-relative"
                                style="box-shadow:0 4px 20px rgba(255,107,0,.16);">
                                <div class="position-absolute top-0 start-0 z-2 m-2">
                                    <span class="badge px-2 py-1 fs-xs fw-bold"
                                        style="background:linear-gradient(135deg,#ff6b00,#ff9a00);color:#fff;">VIP 5</span>
                                </div>
                                <button type="button"
                                    class="btn btn-icon btn-sm btn-light position-absolute top-0 end-0 m-2 z-2 rounded-circle">
                                    <i class="ci-heart fs-xs"></i>
                                </button>
                                <a href="#" class="d-block overflow-hidden" style="height:140px;">
                                    <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                        alt="Căn hộ Bình Thạnh" />
                                </a>
                                <div class="card-body px-2 py-2 px-sm-3">
                                    <h3 class="fs-xs fw-semibold mb-1 lh-base"
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.5em;">
                                        <a href="#" class="text-body text-decoration-none">
                                            Cho thuê căn hộ cao cấp 2PN full nội thất tại Q.Bình Thạnh
                                        </a>
                                    </h3>
                                    <div class="fs-xs text-body-secondary mb-1"><i class="ci-map-pin me-1"></i>Bình Thạnh ·
                                        35m²</div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fw-bold text-primary fs-sm">6.500.000 đ</span>
                                        <a href="tel:0901234567"
                                            class="btn btn-sm btn-primary rounded-pill py-0 px-2 fs-xs">
                                            <i class="ci-phone me-1"></i>Gọi
                                        </a>
                                    </div>
                                    <div class="fs-xs text-body-tertiary mt-1"><i class="ci-clock me-1"></i>5 phút trước
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP 4 -->
                        <div class="col">
                            <div class="card border-0 rounded-4 overflow-hidden h-100 position-relative"
                                style="box-shadow:0 2px 16px rgba(192,57,43,.14);">
                                <div class="position-absolute top-0 start-0 z-2 m-2">
                                    <span class="badge px-2 py-1 fs-xs fw-bold"
                                        style="background:linear-gradient(135deg,#c0392b,#e74c3c);color:#fff;">VIP 4</span>
                                </div>
                                <button type="button"
                                    class="btn btn-icon btn-sm btn-light position-absolute top-0 end-0 m-2 z-2 rounded-circle">
                                    <i class="ci-heart fs-xs"></i>
                                </button>
                                <a href="#" class="d-block overflow-hidden" style="height:140px;">
                                    <img src="assets/img/shop/05.png" class="w-100 h-100 object-fit-cover"
                                        alt="Căn hộ Tân Phú" />
                                </a>
                                <div class="card-body px-2 py-2 px-sm-3">
                                    <h3 class="fs-xs fw-semibold mb-1 lh-base"
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.5em;">
                                        <a href="#" class="text-body text-decoration-none">
                                            Căn hộ 1PN đầy đủ nội thất, view đẹp, khu vực Tân Phú
                                        </a>
                                    </h3>
                                    <div class="fs-xs text-body-secondary mb-1"><i class="ci-map-pin me-1"></i>Tân Phú ·
                                        30m²</div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fw-bold text-primary fs-sm">4.500.000 đ</span>
                                        <a href="tel:0934567890"
                                            class="btn btn-sm btn-outline-primary rounded-pill py-0 px-2 fs-xs">
                                            <i class="ci-phone me-1"></i>Gọi
                                        </a>
                                    </div>
                                    <div class="fs-xs text-body-tertiary mt-1"><i class="ci-clock me-1"></i>45 phút trước
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP 3 -->
                        <div class="col">
                            <div
                                class="product-card animate-underline hover-effect-opacity bg-body rounded h-100 position-relative">
                                <div class="position-absolute top-0 start-0 z-2 mt-2 ms-2" style="pointer-events:none">
                                    <span class="badge fs-xs fw-bold"
                                        style="background:linear-gradient(135deg,#8e44ad,#9b59b6);color:#fff;">VIP 3</span>
                                </div>
                                <div class="position-absolute top-0 end-0 z-2 mt-2 me-2">
                                    <button type="button" class="btn btn-icon btn-sm btn-secondary bg-body rounded-circle">
                                        <i class="ci-heart fs-xs"></i>
                                    </button>
                                </div>
                                <a class="d-block rounded-top overflow-hidden" href="#" style="height:140px;">
                                    <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                        alt="Phòng Gò Vấp" />
                                </a>
                                <div class="w-100 min-w-0 px-2 pb-2 pt-2 px-sm-3">
                                    <h3 class="pb-1 mb-1"
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.5em;">
                                        <a class="d-block fs-xs fw-medium text-body text-decoration-none" href="#">
                                            <span class="animate-target">Phòng trọ sạch sẽ, có gác lửng, gần chợ Gò
                                                Vấp</span>
                                        </a>
                                    </h3>
                                    <div class="fs-xs text-body-secondary mb-1"><i class="ci-map-pin me-1"></i>Gò Vấp · 22m²
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fw-bold text-primary fs-sm">2.200.000 đ</span>
                                        <a href="tel:0911111111"
                                            class="btn btn-sm btn-outline-primary rounded-pill py-0 px-2 fs-xs">
                                            <i class="ci-phone me-1"></i>Gọi
                                        </a>
                                    </div>
                                    <div class="fs-xs text-body-tertiary mt-1"><i class="ci-clock me-1"></i>20 phút trước
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP 5 - item 2 -->
                        <div class="col">
                            <div class="card border-0 rounded-4 overflow-hidden h-100 position-relative"
                                style="box-shadow:0 4px 20px rgba(255,107,0,.16);">
                                <div class="position-absolute top-0 start-0 z-2 m-2">
                                    <span class="badge px-2 py-1 fs-xs fw-bold"
                                        style="background:linear-gradient(135deg,#ff6b00,#ff9a00);color:#fff;">VIP 5</span>
                                </div>
                                <button type="button"
                                    class="btn btn-icon btn-sm btn-light position-absolute top-0 end-0 m-2 z-2 rounded-circle">
                                    <i class="ci-heart fs-xs"></i>
                                </button>
                                <a href="#" class="d-block overflow-hidden" style="height:140px;">
                                    <img src="assets/img/shop/03.png" class="w-100 h-100 object-fit-cover"
                                        alt="Studio Q.7" />
                                </a>
                                <div class="card-body px-2 py-2 px-sm-3">
                                    <h3 class="fs-xs fw-semibold mb-1 lh-base"
                                        style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;min-height:2.5em;">
                                        <a href="#" class="text-body text-decoration-none">
                                            Studio cao cấp full đồ, ban công thoáng mát Q.7 gần Lotte Mart
                                        </a>
                                    </h3>
                                    <div class="fs-xs text-body-secondary mb-1"><i class="ci-map-pin me-1"></i>Quận 7 · 28m²
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fw-bold text-primary fs-sm">5.200.000 đ</span>
                                        <a href="tel:0912345678"
                                            class="btn btn-sm btn-primary rounded-pill py-0 px-2 fs-xs">
                                            <i class="ci-phone me-1"></i>Gọi
                                        </a>
                                    </div>
                                    <div class="fs-xs text-body-tertiary mt-1"><i class="ci-clock me-1"></i>2 giờ trước
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- VIP 1 + VIP 2: dạng list ngang, không có nút gọi -->
                    <div class="d-flex flex-column gap-2">

                        <!-- VIP 1 -->
                        <div class="card border rounded-3 overflow-hidden">
                            <div class="row g-0 align-items-center">
                                <div class="col-4 col-sm-3 col-md-2">
                                    <a href="#" class="d-block overflow-hidden" style="height:90px;">
                                        <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                            alt="Phòng Bình Chánh" />
                                    </a>
                                </div>
                                <div class="col-8 col-sm-9 col-md-10">
                                    <div class="card-body py-2 px-3">
                                        <div class="d-flex align-items-start justify-content-between gap-1 mb-1">
                                            <span class="badge bg-secondary fs-xs text-white">VIP 1</span>
                                            <span class="fs-xs text-body-tertiary text-nowrap"><i
                                                    class="ci-clock me-1"></i>10 phút trước</span>
                                        </div>
                                        <h3 class="fs-sm fw-medium mb-1 lh-base"
                                            style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                            <a href="#" class="text-body text-decoration-none">
                                                Phòng trọ bình dân 1,1 triệu khu vực Bình Chánh, đường xe buýt đi được
                                            </a>
                                        </h3>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <span class="fw-bold text-primary fs-sm">1.100.000 đ/tháng</span>
                                            <span class="text-body-secondary fs-xs"><i class="ci-map-pin me-1"></i>Bình
                                                Chánh, HCM</span>
                                            <span class="text-body-secondary fs-xs">12m²</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP 2 -->
                        <div class="card border rounded-3 overflow-hidden">
                            <div class="row g-0 align-items-center">
                                <div class="col-4 col-sm-3 col-md-2">
                                    <a href="#" class="d-block overflow-hidden" style="height:90px;">
                                        <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                            alt="Phòng HUTECH" />
                                    </a>
                                </div>
                                <div class="col-8 col-sm-9 col-md-10">
                                    <div class="card-body py-2 px-3">
                                        <div class="d-flex align-items-start justify-content-between gap-1 mb-1">
                                            <span class="badge bg-info fs-xs fw-bold text-white">VIP 2</span>
                                            <span class="fs-xs text-body-tertiary text-nowrap"><i
                                                    class="ci-clock me-1"></i>30 phút trước</span>
                                        </div>
                                        <h3 class="fs-sm fw-medium mb-1 lh-base"
                                            style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                            <a href="#" class="text-body text-decoration-none">
                                                Phòng trọ bình dân, sạch sẽ, gần trường ĐH HUTECH
                                            </a>
                                        </h3>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <span class="fw-bold text-primary fs-sm">1.400.000 đ/tháng</span>
                                            <span class="text-body-secondary fs-xs"><i class="ci-map-pin me-1"></i>Bình
                                                Thạnh, HCM</span>
                                            <span class="text-body-secondary fs-xs">15m²</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP 1 -->
                        <div class="card border rounded-3 overflow-hidden">
                            <div class="row g-0 align-items-center">
                                <div class="col-4 col-sm-3 col-md-2">
                                    <a href="#" class="d-block overflow-hidden" style="height:90px;">
                                        <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                            alt="Phòng Tân Phú" />
                                    </a>
                                </div>
                                <div class="col-8 col-sm-9 col-md-10">
                                    <div class="card-body py-2 px-3">
                                        <div class="d-flex align-items-start justify-content-between gap-1 mb-1">
                                            <span class="badge bg-secondary fs-xs text-white">VIP 1</span>
                                            <span class="fs-xs text-body-tertiary text-nowrap"><i
                                                    class="ci-clock me-1"></i>1 giờ trước</span>
                                        </div>
                                        <h3 class="fs-sm fw-medium mb-1 lh-base"
                                            style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                            <a href="#" class="text-body text-decoration-none">
                                                Cần cho thuê phòng trọ thoáng mát, gần chợ, giờ tự do
                                            </a>
                                        </h3>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <span class="fw-bold text-primary fs-sm">1.200.000 đ/tháng</span>
                                            <span class="text-body-secondary fs-xs"><i class="ci-map-pin me-1"></i>Tân Phú,
                                                HCM</span>
                                            <span class="text-body-secondary fs-xs">14m²</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP 2 -->
                        <div class="card border rounded-3 overflow-hidden">
                            <div class="row g-0 align-items-center">
                                <div class="col-4 col-sm-3 col-md-2">
                                    <a href="#" class="d-block overflow-hidden" style="height:90px;">
                                        <img src="assets/img/shop/02.png" class="w-100 h-100 object-fit-cover"
                                            alt="Nhà trọ Tân Bình" />
                                    </a>
                                </div>
                                <div class="col-8 col-sm-9 col-md-10">
                                    <div class="card-body py-2 px-3">
                                        <div class="d-flex align-items-start justify-content-between gap-1 mb-1">
                                            <span class="badge bg-info fs-xs fw-bold text-white">VIP 2</span>
                                            <span class="fs-xs text-body-tertiary text-nowrap"><i
                                                    class="ci-clock me-1"></i>4 giờ trước</span>
                                        </div>
                                        <h3 class="fs-sm fw-medium mb-1 lh-base"
                                            style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                            <a href="#" class="text-body text-decoration-none">
                                                Nhà trọ giá rẻ, an toàn, khu yên tĩnh Tân Bình
                                            </a>
                                        </h3>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <span class="fw-bold text-primary fs-sm">1.600.000 đ/tháng</span>
                                            <span class="text-body-secondary fs-xs"><i class="ci-map-pin me-1"></i>Tân Bình,
                                                HCM</span>
                                            <span class="text-body-secondary fs-xs">17m²</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- VIP 1 -->
                        <div class="card border rounded-3 overflow-hidden">
                            <div class="row g-0 align-items-center">
                                <div class="col-4 col-sm-3 col-md-2">
                                    <a href="#" class="d-block overflow-hidden" style="height:90px;">
                                        <img src="assets/img/shop/05.png" class="w-100 h-100 object-fit-cover"
                                            alt="Nhà trọ Củ Chi" />
                                    </a>
                                </div>
                                <div class="col-8 col-sm-9 col-md-10">
                                    <div class="card-body py-2 px-3">
                                        <div class="d-flex align-items-start justify-content-between gap-1 mb-1">
                                            <span class="badge bg-secondary fs-xs text-white">VIP 1</span>
                                            <span class="fs-xs text-body-tertiary text-nowrap"><i
                                                    class="ci-clock me-1"></i>1 giờ trước</span>
                                        </div>
                                        <h3 class="fs-sm fw-medium mb-1 lh-base"
                                            style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                            <a href="#" class="text-body text-decoration-none">
                                                Nhà trọ nguyên căn 3 phòng cho thuê giá rẻ khu Củ Chi
                                            </a>
                                        </h3>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <span class="fw-bold text-primary fs-sm">3.500.000 đ/tháng</span>
                                            <span class="text-body-secondary fs-xs"><i class="ci-map-pin me-1"></i>Củ Chi,
                                                HCM</span>
                                            <span class="text-body-secondary fs-xs">60m²</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="text-center mt-4">
                        <a href="#" class="btn btn-outline-secondary rounded-pill px-5">
                            <i class="ci-refresh-cw me-2"></i>Xem thêm tin đăng
                        </a>
                    </div>

                </section>
            </div>
            <!-- /tab-pane Mới đăng -->

        </div>
        <!-- /tab-content -->

    </main>
@endsection