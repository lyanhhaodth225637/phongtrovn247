@extends('layouts.frontend.app')

@section('content')
  <!-- ═══ HERO ═══ -->
  <section class="hero">
    <div class="container">
      <div class="hero-inner">
        <div class="hero-badge">
          <i class="bi bi-geo-alt-fill"></i> Nền tảng tìm thuê nhà hàng đầu Việt Nam
        </div>
        <h1 class="hero-title">
          Tìm phòng trọ, căn hộ,<br>
          nhà thuê <span class="highlight">ưng ý nhất</span>
        </h1>
        <p class="hero-sub">Hàng trăm nghìn tin đăng mỗi ngày – tìm nhanh, thuê dễ</p>
      </div>
    </div>
  </section>

  <!-- ═══ STATS BAR ═══ -->
  <div class="stats-bar">
    <div class="container">
      <div class="row text-center g-0">
        <div class="col stat-item py-1">
          <strong>{{ number_format($totalPosts, 0, ',', '.') }}</strong> tin đang đăng
        </div>

        <div class="col stat-item py-1 d-none d-sm-block">
          <strong>34</strong> tỉnh thành
        </div>

        <div class="col stat-item py-1">
          <strong>{{ number_format($newPostsToday, 0, ',', '.') }}</strong> tin mới hôm nay
        </div>

        <div class="col stat-item py-1 d-none d-sm-block">
          <strong>{{ number_format($totalViewsPerDay, 0, ',', '.') }}</strong> lượt xem
        </div>
      </div>
    </div>
  </div>

  <!-- ═══ CATEGORY CHIPS ═══ -->
  <div class="cat-chips-wrap">
    <div class="container">
      <div class="cat-chips-scroll">
        <a href="{{ route('frontend.home', request()->except('category', 'page')) }}"
          class="cat-chip {{ request('category') ? '' : 'active' }}">
          <i class="bi bi-grid-fill"></i> Tất cả
        </a>

        @foreach ($categories as $category)
          <a href="{{ route('frontend.home', array_merge(request()->except('page'), ['category' => $category->slug])) }}"
            class="cat-chip {{ request('category') == $category->slug ? 'active' : '' }}">
            {{ $category->name }}
          </a>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Listing tabs --}}
  <div class="listing-tabs">
    <a class="listing-tab {{ request('sort') != 'new' ? 'active' : '' }}"
      href="{{ route('frontend.home', request()->except('sort', 'page')) }}">
      <i class="bi bi-stars"></i> Đề xuất
    </a>

    <a class="listing-tab {{ request('sort') == 'new' ? 'active' : '' }}"
      href="{{ route('frontend.home', array_merge(request()->except('page'), ['sort' => 'new'])) }}">
      <i class="bi bi-clock-history"></i> Mới nhất
    </a>
  </div>

  @if (request('sort') == 'new')
    @include('frontend.new_post')
  @else
    @include('frontend.suggest')
  @endif
  @if(request()->routeIs('frontend.home'))
    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:18px; overflow:hidden;">

          <div class="modal-header text-dark border-0" style="background: linear-gradient(135deg,#fff3cd,#ffe69c);">
            <h5 class="modal-title fw-bold d-flex align-items-center" id="warningModalLabel">
              <i class="bi bi-exclamation-triangle-fill text-warning me-2 fs-4"></i>
              Cảnh báo
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
          </div>

          <div class="modal-body p-4">
            <div class="text-center mb-3">
              <div class="mx-auto d-flex align-items-center justify-content-center"
                style="width:78px;height:78px;border-radius:50%;background:#fff3cd;">
                <i class="bi bi-shield-exclamation text-warning" style="font-size:38px;"></i>
              </div>
            </div>

            <h4 class="fw-bold text-center mb-3 text-warning-emphasis">
              Website chỉ mang tính mô phỏng
            </h4>

            <div class="alert alert-warning border-0 mb-3" style="border-radius:12px;">
              <strong>Lưu ý:</strong> Đây là website phục vụ cho đồ án tốt nghiệp.
            </div>

            <p class="text-muted mb-3" style="line-height:1.8;">
              Tất cả các chức năng liên quan đến:
            </p>

            <ul class="text-muted mb-3" style="line-height:1.9;">
              <li>Nạp tiền vào tài khoản</li>
              <li>Thanh toán, giao dịch</li>
              <li>Mua gói dịch vụ, nâng cấp VIP</li>
              <li>Ví tiền và chuyển khoản</li>
            </ul>

            <p class="text-danger fw-semibold mb-0" style="line-height:1.8;">
              đều chỉ là mô phỏng giả lập để minh họa cho hoạt động của hệ thống, không phải giao dịch thật và không phát
              sinh giá trị thực tế.
            </p>
          </div>

          <div class="modal-footer border-0 bg-light px-4 pb-4">
            <button type="button" class="btn btn-warning fw-semibold px-4" data-bs-dismiss="modal">
              Tôi đã hiểu
            </button>
          </div>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('warningModal');

        // chỉ hiện 1 lần
        if (modalEl && !localStorage.getItem('warning_modal_shown')) {
          const modal = new bootstrap.Modal(modalEl);
          modal.show();

          modalEl.addEventListener('hidden.bs.modal', function () {
            localStorage.setItem('warning_modal_shown', '1');
          });
        }
      });
    </script>
  @endif

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const modalEl = document.getElementById('projectNoticeModal');
      if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
      }
    });
  </script>
@endsection