<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <title>{{ config('app.name') }} - Tìm phòng trọ, căn hộ, nhà thuê nhanh và uy tín nhất</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800;900&family=Sora:wght@700;800&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/frontend/home.css') }}">
  <!-- fas pro     -->
  <link rel="stylesheet" href="{{ asset('font-awesome/css/all.min.css') }}">
  <link rel="icon" type="image/png" href="{{ asset('storage/logo/logo.png') }}">


  <!-- css -->
  <style>
    .tag-chip {
      cursor: pointer;
    }

    .tag-chip.active {
      background: var(--primary);
      color: #fff;
      border-color: var(--primary);
    }
  </style>
  @stack('styles')
</head>

<body>

  <!-- HEADER -->

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
          <a href="{{ route('frontend.new.index') }}" class="nav-link-custom">
            <i class="bi bi-newspaper me-1"></i>Tin tức
          </a>
          <a href="{{ route('frontend.contact.index') }}" class="nav-link-custom">
            <i class="bi bi-envelope me-1"></i>Liên hệ
          </a>
        </nav>

        {{-- Actions --}}
        <div class="header-actions">
          <button type="button" class="btn-filter-nav" id="openFilterModal" data-bs-toggle="modal"
            data-bs-target="#filterModal">
            <i class="bi bi-sliders2"></i>
            <span>Lọc</span>
            <span class="filter-badge d-none" id="filterBadge">0</span>
          </button>

          @auth
            {{-- Chuông thông báo --}}
            <div class="header-icon-btn" id="notifToggle">
              <i class="bi bi-bell"></i>

              @if(($headerNotificationCount ?? 0) > 0)
                <span class="header-icon-badge" id="notifCount">
                  {{ ($headerNotificationCount ?? 0) > 9 ? '9+' : ($headerNotificationCount ?? 0) }}
                </span>
              @endif

              <div class="header-dropdown notif-dropdown" id="notifDropdown">

                <div class="hdrop-head">
                  <span>Thông báo</span>

                  <form action="{{ route('user.notifications.readAll') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit"
                      style="font-size:0.72rem;color:#1a56db;font-weight:600;background:none;border:none;padding:0">
                      Đánh dấu đã đọc
                    </button>
                  </form>
                </div>

                @forelse(($headerNotifications ?? collect()) as $notification)
                  <a href="{{ route('user.notifications.read', $notification->id) }}"
                    class="notif-item {{ is_null($notification->read_at) ? 'unread' : '' }}"
                    style="display:flex;gap:10px;padding:12px 14px;text-decoration:none;border-bottom:1px solid #eef2f7">

                    <div
                      style="width:38px;height:38px;border-radius:50%;background:#eff6ff;color:#2563eb;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                      <i class="{{ $notification->data['icon'] ?? 'bi bi-bell' }}"></i>
                    </div>

                    <div style="flex:1;min-width:0">
                      <div style="font-size:.82rem;font-weight:600;color:#111827;margin-bottom:2px">
                        {{ $notification->data['title'] ?? 'Thông báo' }}
                      </div>

                      <div style="font-size:.78rem;color:#6b7280;line-height:1.4">
                        {{ $notification->data['message'] ?? '' }}
                      </div>

                      <div style="font-size:.72rem;color:#9ca3af;margin-top:4px">
                        {{ $notification->created_at->diffForHumans() }}
                      </div>
                    </div>

                    @if(is_null($notification->read_at))
                      <div style="width:8px;height:8px;background:#2563eb;border-radius:50%;margin-top:6px"></div>
                    @endif
                  </a>
                @empty
                  <div class="hdrop-empty">
                    <i class="bi bi-bell-slash" style="font-size:1.8rem;color:#cbd5e1;display:block;margin-bottom:6px"></i>
                    Chưa có thông báo nào
                  </div>
                @endforelse

              </div>
            </div>

            {{-- Bài viết đã lưu --}}
            <a href="{{ route('saved-post.index') }}" class="header-icon-btn" title="Bài viết đã lưu">
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

              <div class="dropdown-menu dropdown-menu-end avatar-dropdown p-0"
                style="width:270px;border-radius:14px;border:1px solid var(--border);box-shadow:0 8px 32px rgba(0,0,0,.12);overflow:hidden;margin-top:8px">

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
                  <a href="{{ route('user.wallet.index') }}" class="adrop-topup">
                    <i class="bi bi-credit-card-2-front"></i> Nạp tiền
                  </a>
                </div>

                {{-- Quản lý tin đăng --}}
                <div class="adrop-section-title">
                  Quản lý tin đăng
                  <a href="{{ route('user.post.index') }}" class="adrop-viewall">Xem tất cả</a>
                </div>
                <div class="adrop-post-stats">
                  <a href="{{ route('frontend.profile.index') }}" class="adrop-stat-item">
                    <i class="bi bi-folder2"></i>
                    <span>Tất cả</span>
                  </a>
                  <a href="{{ route('user.post.index') }}" class="adrop-stat-item">
                    <i class="bi bi-check-circle"></i>
                    <span>Đang hiển thị</span>
                  </a>
                  <a href="{{ route('user.post.index') }}" class="adrop-stat-item">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span>Hết hạn</span>
                  </a>
                  <a href="{{ route('user.post.index') }}" class="adrop-stat-item">
                    <i class="bi bi-eye-slash"></i>
                    <span>Tin ẩn</span>
                  </a>
                </div>

                <div class="adrop-divider"></div>

                <a href="{{ route('frontend.membership.index') }}" class="adrop-menu-item">
                  <i class="bi bi-tag"></i> Bảng giá dịch vụ
                </a>
                <a href="{{ route('user.wallet.deposit-history') }}" class="adrop-menu-item">
                  <i class="bi bi-credit-card"></i> Quản lý giao dịch
                </a>
                <a href="{{ route('frontend.profile.index') }}" class="adrop-menu-item">
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

          <a href="{{ route('user.post.create') }}" class="btn-post nav-post-btn">
            <i class="bi bi-plus-circle"></i>
            <span class="d-none d-sm-inline">Đăng tin</span>
          </a>
        </div>

      </div>
    </div>
  </header>

  {{-- Overlay (chỉ dùng cho notif dropdown) --}}
  <div id="headerOverlay"></div>

  <!-- FILTER MODAL -->
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
              @foreach ($categories as $category)
                <div class="cat-grid-item" data-filter="category" data-value="{{ $category->slug }}">
                  {{ $category->name }}
                </div>
              @endforeach
            </div>
          </div>

          <!-- Vị trí -->
          <div class="filter-section">
            <div class="filter-section-title">Vị trí</div>

            <div class="filter-select-row">
              <div>
                <label class="small text-muted fw-semibold mb-1 d-block">
                  Tỉnh/Thành phố
                </label>

                <select class="form-select form-select-sm" id="filterProvince">
                  <option value="">Tất cả</option>
                </select>
              </div>

              <div>
                <label class="small text-muted fw-semibold mb-1 d-block">
                  Phường/Xã
                </label>

                <select class="form-select form-select-sm" id="filterWard">
                  <option value="">Tất cả</option>
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
              @foreach ($amenities as $amenity)
                <label class="feature-chip">
                  <input type="checkbox" name="amenities[]" value="{{ $amenity->slug }}">
                  {{ $amenity->name }}
                </label>
              @endforeach
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
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const applyButton = document.getElementById('applyFilter');
        if (!applyButton) return;

        applyButton.addEventListener('click', function () {
          const url = new URL("{{ route('frontend.home') }}", window.location.origin);

          url.searchParams.delete('page');

          const category = document.querySelector('.cat-grid-item.active')?.dataset.value ?? '';
          const province = document.getElementById('filterProvince')?.value ?? '';
          const ward = document.getElementById('filterWard')?.value ?? '';
          const price = document.querySelector('.tag-chip[data-filter="price"].active:not(.active-all)')?.dataset.value ?? '';
          const area = document.querySelector('.tag-chip[data-filter="area"].active:not(.active-all)')?.dataset.value ?? '';
          const amenities = Array.from(document.querySelectorAll('input[name="amenities[]"]:checked'))
            .map((input) => input.value)
            .filter(Boolean)
            .join(',');

          if (category) url.searchParams.set('category', category);
          else url.searchParams.delete('category');

          if (province) url.searchParams.set('province', province);
          else {
            url.searchParams.delete('province');
            url.searchParams.delete('ward');
          }

          if (province && ward) url.searchParams.set('ward', ward);
          else url.searchParams.delete('ward');

          if (price && price !== 'all') url.searchParams.set('price', price);
          else url.searchParams.delete('price');

          if (area && area !== 'all') url.searchParams.set('area', area);
          else url.searchParams.delete('area');

          if (amenities) url.searchParams.set('amenities', amenities);
          else url.searchParams.delete('amenities');

          window.location.href = url.toString();
        });
      });
    </script>
  </div>

  <!-- MAIN CONTENT -->
  <div class="container section-wrap">

    {{-- Active filter chips --}}
    <div id="activeFiltersRow" class="active-filters d-none"></div>
    @include('components.alert')

    @yield('content')

    <!-- PAGINATION -->
    <!-- <div class="d-flex justify-content-center align-items-center gap-1 mt-4 flex-wrap">
      <button class="page-btn"><i class="bi bi-chevron-left"></i></button>
      <button class="page-btn active">1</button>
      <button class="page-btn">2</button>
      <button class="page-btn">3</button>
      <button class="page-btn">4</button>
      <button class="page-btn" style="border:none;cursor:default;background:transparent">…</button>
      <button class="page-btn">20</button>
      <button class="page-btn"><i class="bi bi-chevron-right"></i></button>
    </div> -->

  </div>

  <!-- FOOTER -->
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
          <a href="{{ route('frontend.contact.index') }}" class="footer-link">Liên hệ</a>
        </div>
        <div class="col-12 col-sm-4 col-lg-4">
          <div class="footer-title">Nhận tin phòng trọ mới</div>
          <p style="font-size:0.77rem;margin-bottom:12px">Đăng ký để nhận thông báo phòng trọ phù hợp với bạn.</p>
          <div class="d-flex gap-2">
            <input type="email" placeholder="Email của bạn" class="form-control form-control-sm footer-input">
            <button class="btn-post" style="white-space:nowrap;font-size:0.77rem;padding:6px 14px">Đăng ký</button>
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

  <!-- MOBILE BOTTOM NAV -->
  <nav class="mobile-nav">
    <a href="{{ route('frontend.home') }}" class="mobile-nav-item active">
      <i class="bi bi-house-fill"></i>
      <span>Trang chủ</span>
    </a>

    <button class="mobile-nav-item" data-bs-toggle="modal" data-bs-target="#filterModal">
      <i class="bi bi-sliders2"></i>
      <span>Lọc</span>
    </button>

    <a href="{{ route('user.post.create') }}" class="mobile-nav-item btn-post-mobile">
      <i class="bi bi-plus-circle-fill"></i>
      <span>Đăng tin</span>
    </a>

    <a href="#" class="mobile-nav-item">
      <i class="bi bi-bookmark"></i>
      <span>Đã lưu</span>
    </a>

    @auth
      <a href="{{ route('frontend.profile.index') }}" class="mobile-nav-item">
        <img src="{{ asset('storage/' . (auth()->user()->avatar ?? 'default/avt_default.png')) }}"
          style="width:24px;height:24px;border-radius:50%">

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
  <script>
    document.addEventListener('DOMContentLoaded', async function () {
      const provinceSelect = document.getElementById('filterProvince');
      const wardSelect = document.getElementById('filterWard');

      const selectedProvince = "{{ request('province') }}";
      const selectedWard = "{{ request('ward') }}";

      // load tỉnh/thành
      try {
        const provinceRes = await fetch('/provinces');
        const provinces = await provinceRes.json();

        provinces.forEach(province => {
          provinceSelect.innerHTML += `
          <option value="${province.id}" ${selectedProvince == province.id ? 'selected' : ''}>
            ${province.name}
          </option>
        `;
        });

        // nếu đang có tỉnh được chọn thì load luôn phường/xã
        if (selectedProvince) {
          const wardRes = await fetch(`/wards/${selectedProvince}`);
          const wards = await wardRes.json();

          wards.forEach(ward => {
            wardSelect.innerHTML += `
            <option value="${ward.id}" ${selectedWard == ward.id ? 'selected' : ''}>
              ${ward.name}
            </option>
          `;
          });
        }

      } catch (error) {
        console.error('Lỗi tải tỉnh/thành:', error);
      }

      // đổi tỉnh => load lại phường/xã
      provinceSelect.addEventListener('change', async function () {
        const provinceId = this.value;

        wardSelect.innerHTML = '<option value="">Tất cả</option>';

        if (!provinceId) return;

        try {
          const wardRes = await fetch(`/wards/${provinceId}`);
          const wards = await wardRes.json();

          wards.forEach(ward => {
            wardSelect.innerHTML += `
            <option value="${ward.id}">
              ${ward.name}
            </option>
          `;
          });
        } catch (error) {
          console.error('Lỗi tải phường/xã:', error);
        }
      });

      // giữ active danh mục sau reload
      const selectedCategory = "{{ request('category') }}";
      if (selectedCategory) {
        document.querySelectorAll('.cat-grid-item').forEach(item => {
          if (item.dataset.value === selectedCategory) {
            item.classList.add('active');
          }
        });
      }

      // giữ active giá sau reload
      const selectedPrice = "{{ request('price') }}";
      if (selectedPrice) {
        document.querySelectorAll('.tag-chip[data-filter="price"]').forEach(item => {
          if (item.dataset.value === selectedPrice) {
            item.classList.add('active');
            item.classList.remove('active-all');
          } else if (item.dataset.value === 'all') {
            item.classList.remove('active-all');
          }
        });
      }

      // giữ active diện tích sau reload
      const selectedArea = "{{ request('area') }}";
      if (selectedArea) {
        document.querySelectorAll('.tag-chip[data-filter="area"]').forEach(item => {
          if (item.dataset.value === selectedArea) {
            item.classList.add('active');
            item.classList.remove('active-all');
          } else if (item.dataset.value === 'all') {
            item.classList.remove('active-all');
          }
        });
      }

      // giữ checkbox tiện ích
      const selectedAmenities = "{{ request('amenities') }}".split(',');

      document.querySelectorAll('input[name="amenities[]"]').forEach(input => {
        if (selectedAmenities.includes(input.value)) {
          input.checked = true;
          input.closest('.feature-chip')?.classList.add('checked');
        }
      });
    });
  </script>
  @stack('scripts')

</body>

</html>
