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

        {{-- Search bar --}}
        <div class="search-bar">
          <select>
            <option>Danh mục</option>
           
              <option value=""></option>
           
          </select>
          <div class="search-divider d-none d-sm-block"></div>
          <select>
            <option value="">Tỉnh/Thành phố</option>
            <option>An Giang</option>
            <option>TP. Hồ Chí Minh</option>
            <option>Hà Nội</option>
            <option>Đà Nẵng</option>
            <option>Cần Thơ</option>
            <option>Bình Dương</option>
            <option>Long An</option>
          </select>
          <div class="search-divider d-none d-md-block"></div>
          <select>
            <option value="">Quận/Huyện</option>
            <option>TP. Long Xuyên</option>
            <option>H. Châu Thành</option>
            <option>H. Thoại Sơn</option>
          </select>
          <div class="search-divider d-none d-lg-block"></div>
          <select class="d-none d-lg-block">
            <option value="">Giá thuê</option>
            <option>Dưới 1 triệu</option>
            <option>1 – 2 triệu</option>
            <option>2 – 3 triệu</option>
            <option>3 – 5 triệu</option>
            <option>5 – 7 triệu</option>
            <option>Trên 7 triệu</option>
          </select>
          <button class="btn-search">
            <i class="bi bi-search"></i> Tìm kiếm
          </button>
        </div>

        {{-- Quick tags --}}
        <div class="quick-tags">
          <span class="quick-tag">Dưới 2 triệu</span>
          <span class="quick-tag">2–4 triệu</span>
          <span class="quick-tag">Gần trường ĐH</span>
          <span class="quick-tag">Có nội thất</span>
          <span class="quick-tag">Cho phép nuôi thú</span>
          <span class="quick-tag">Tự do giờ giấc</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══ STATS BAR ═══ -->
  <div class="stats-bar">
    <div class="container">
      <div class="row text-center g-0">
        <div class="col stat-item py-1"><strong>128.450</strong> tin đang đăng</div>
        <div class="col stat-item py-1 d-none d-sm-block"><strong>63</strong> tỉnh thành</div>
        <div class="col stat-item py-1"><strong>4.200</strong> tin mới hôm nay</div>
        <div class="col stat-item py-1 d-none d-sm-block"><strong>1.2M+</strong> lượt xem/ngày</div>
      </div>
    </div>
  </div>

  <!-- ═══ CATEGORY CHIPS ═══ -->
  <div class="cat-chips-wrap">
    <div class="container">
      <div class="cat-chips-scroll">
        <a href="{{ route('frontend.home') }}" class="cat-chip {{ request()->routeIs('frontend.home') ? 'active' : '' }}">
          <i class="bi bi-grid-fill"></i> Tất cả
        </a>
       
          <a href=""
            class="cat-chip ">
           
          </a>
        
      </div>
    </div>
  </div>
   {{-- Listing tabs --}}
    <div class="listing-tabs">
      <a class="listing-tab {{ request('sort') != 'new' ? 'active' : '' }}" data-tab="deXuat"
        href="{{ url()->current() }}">
        <i class="bi bi-stars"></i> Đề xuất
      </a>
      <a class="listing-tab {{ request('sort') == 'new' ? 'active' : '' }}" data-tab="moiNhat"
        href="{{ url()->current() }}?sort=new">
        <i class="bi bi-clock-history"></i> Mới nhất
      </a>
    </div>
  {{-- ══ TAB: ĐỀ XUẤT ══ --}}
  <div class="tab-pane-custom active" id="tab-deXuat">
    {{-- ── VIP 5 ── --}}
    <div class="mb-4">
      <div class="sec-head">
        <h2 class="sec-title">
          <span class="accent-line" style="background:linear-gradient(180deg,#dc2626,#ef4444)"></span>
          <span class="vip-badge vip-5 me-1"><i class="bi bi-star-fill"></i> VIP 5</span>
          Tin nổi bật cao cấp
        </h2>
        <a href="#" class="sec-more">Xem tất cả <i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-lg-4">

        @forelse($postVip5 as $post)
          <div class="col">
            <div class="card-vip5 h-100">
              <div class="img-wrap">
                <img src="{{ asset('storage/' . ($post->images->first()->image ?? 'default.jpg')) }}"
                  alt="{{ $post->title }}" loading="lazy">
                @if($post->images->count() > 0)
                  <span class="hot-tag"><i class="bi bi-fire"></i> Hot</span>
                  <span class="img-count"><i class="bi bi-images"></i> {{ $post->images->count() }}</span>
                @endif
              </div>
              <div class="body">
                <div class="d-flex align-items-center justify-content-between mb-1">
                  <span class="vip-badge vip-5"><i class="bi bi-star-fill"></i> VIP 5</span>
                  <span class="time-ago"><i class="bi bi-clock"></i> {{ $post->created_at->diffForHumans() }}</span>
                </div>
                <div class="price">{{ number_format($post->price) }}đ/tháng</div>
                <a href="{{ route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                  class="title-link mt-1">{{ $post->title }}</a>
                <div class="meta-row">
                  <span class="meta-chip"><i class="bi bi-rulers"></i> {{ $post->area }}m²</span>
                  <span class="meta-chip"><i class="bi bi-geo-alt"></i> {{ $post->ward->name ?? '' }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-auto pt-2">
                  <span class="poster-name">
                    <i class="bi bi-person-fill"></i> {{ $post->user->name ?? 'Ẩn danh' }}
                  </span>
                  <div class="d-flex gap-2">
                    <button class="save-btn" aria-label="Lưu tin"><i class="bi bi-bookmark"></i></button>
                    <button class="phone-btn">
                      <i class="bi bi-telephone-fill"></i>
                      {{ substr($post->user->phone ?? '0000000000', 0, 3) }}*****{{ substr($post->user->phone ?? '0000000000', -2) }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-muted text-center py-3">Chưa có tin VIP 5 nào.</p>
          </div>
        @endforelse
      </div>
    </div>

    {{-- ── VIP 4 ── --}}
    <div class="mb-4">
      <div class="sec-head">
        <h2 class="sec-title">
          <span class="accent-line" style="background:linear-gradient(180deg,#ea580c,#f97316)"></span>
          <span class="vip-badge vip-4 me-1"><i class="bi bi-star-half"></i> VIP 4</span>
          Tin đăng ưu tiên
        </h2>
        <a href="#" class="sec-more">Xem tất cả <i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="row g-2">
        @forelse($postVip4 as $post)
          <div class="col-12 col-md-6">
            <div class="card-vip4">
              <div class="img-wrap" style="position:relative">
                <img src="{{ asset('storage/' . ($post->images->first()->image ?? 'default.jpg')) }}"
                  alt="{{ $post->title }}" loading="lazy">
                <span class="vip-badge vip-4" style="position:absolute;top:6px;left:6px">
                  <i class="bi bi-star-half"></i> VIP 4
                </span>
              </div>
              <div class="body">
                <span class="time-ago"><i class="bi bi-clock"></i> {{ $post->created_at->diffForHumans() }}</span>
                <a href="" class="title-link mt-1">{{ $post->title }}</a>
                <div class="price mt-1">{{ number_format($post->price) }}đ/tháng</div>
                <div class="d-flex align-items-center justify-content-between mt-1">
                  <div class="meta-row">
                    <span class="meta-chip"><i class="bi bi-rulers"></i> {{ $post->area }}m²</span>
                    <span class="meta-chip"><i class="bi bi-geo-alt"></i> {{ $post->ward->name ?? '' }}</span>
                  </div>
                  <button class="phone-btn" style="font-size:0.7rem;padding:5px 10px">
                    <i class="bi bi-telephone-fill"></i>
                    {{ substr($post->user->phone ?? '0000000000', 0, 3) }}*****{{ substr($post->user->phone ?? '0000000000', -2) }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-muted text-center py-3">Chưa có tin VIP 4 nào.</p>
          </div>
        @endforelse
      </div>
    </div>

    {{-- ── VIP 3 ── --}}
    <div class="mb-4">
      <div class="sec-head">
        <h2 class="sec-title">
          <span class="accent-line" style="background:linear-gradient(180deg,#7c3aed,#a855f7)"></span>
          <span class="vip-badge vip-3 me-1">VIP 3</span> Tin ưu tiên thường
        </h2>
        <a href="#" class="sec-more">Xem tất cả <i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="row g-2">
        @forelse($postVip3 as $post)
          <div class="col-12 col-md-6">
            <div class="card-small">
              <div class="img-wrap">
                <img src="{{ asset('storage/' . ($post->images->first()->image ?? 'default.jpg')) }}"
                  alt="{{ $post->title }}" loading="lazy">
              </div>
              <div class="body">
                <div class="d-flex align-items-center justify-content-between mb-1">
                  <span class="vip-badge vip-3">VIP 3</span>
                  <span class="time-ago"><i class="bi bi-clock"></i> {{ $post->created_at->diffForHumans() }}</span>
                </div>
                <a href="" class="title-link">{{ $post->title }}</a>
                <div class="price mt-1">{{ number_format($post->price) }}đ/tháng</div>
                <div class="meta-row">
                  <span class="meta-chip"><i class="bi bi-rulers"></i> {{ $post->area }}m²</span>
                  <span class="meta-chip"><i class="bi bi-geo-alt"></i> {{ $post->ward->name ?? '' }}</span>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-muted text-center py-3">Chưa có tin VIP 3 nào.</p>
          </div>
        @endforelse
      </div>
    </div>

    {{-- ── VIP 2 ── --}}
    <div class="mb-4">
      <div class="sec-head">
        <h2 class="sec-title">
          <span class="accent-line" style="background:linear-gradient(180deg,#0b5ed7,#3b82f6)"></span>
          <span class="vip-badge vip-2 me-1">VIP 2</span> Tin mới đăng
        </h2>
        <a href="#" class="sec-more">Xem tất cả <i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="row g-2">
        @forelse($postVip2 as $post)
          <div class="col-12 col-md-6">
            <div class="card-small">
              <div class="img-wrap">
                <img src="{{ asset('storage/' . ($post->images->first()->image ?? 'default.jpg')) }}"
                  alt="{{ $post->title }}" loading="lazy">
              </div>
              <div class="body">
                <div class="d-flex align-items-center justify-content-between mb-1">
                  <span class="vip-badge vip-2">VIP 2</span>
                  <span class="time-ago"><i class="bi bi-clock"></i> {{ $post->created_at->diffForHumans() }}</span>
                </div>
                <a href="" class="title-link">{{ $post->title }}</a>
                <div class="price mt-1">{{ number_format($post->price) }}đ/tháng</div>
                <div class="meta-row">
                  <span class="meta-chip"><i class="bi bi-rulers"></i> {{ $post->area }}m²</span>
                  <span class="meta-chip"><i class="bi bi-geo-alt"></i> {{ $post->ward->name ?? '' }}</span>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-muted text-center py-3">Chưa có tin VIP 2 nào.</p>
          </div>
        @endforelse
      </div>
    </div>

    {{-- ── VIP 1 ── --}}
    <div class="mb-4">
      <div class="sec-head">
        <h2 class="sec-title">
          <span class="accent-line" style="background:linear-gradient(180deg,#059669,#10b981)"></span>
          <span class="vip-badge vip-1 me-1">VIP 1</span> Tin thường
        </h2>
        <a href="#" class="sec-more">Xem tất cả <i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="row g-2">
        @forelse($postVip1 as $post)
          <div class="col-12 col-md-4">
            <div class="card-small">
              <div class="img-wrap">
                <img src="{{ asset('storage/' . ($post->images->first()->image ?? 'default.jpg')) }}"
                  alt="{{ $post->title }}" loading="lazy">
              </div>
              <div class="body">
                <div class="d-flex align-items-center justify-content-between mb-1">
                  <span class="vip-badge vip-1">VIP 1</span>
                  <span class="time-ago"><i class="bi bi-clock"></i> {{ $post->created_at->diffForHumans() }}</span>
                </div>
                <a href="" class="title-link">{{ $post->title }}</a>
                <div class="price mt-1">{{ number_format($post->price) }}đ/tháng</div>
                <div class="meta-row">
                  <span class="meta-chip"><i class="bi bi-rulers"></i> {{ $post->area }}m²</span>
                  <span class="meta-chip"><i class="bi bi-geo-alt"></i> {{ $post->ward->name ?? '' }}</span>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-muted text-center py-3">Chưa có tin VIP 1 nào.</p>
          </div>
        @endforelse
      </div>
    </div>

    {{-- ── FREE ── --}}
    <div class="mb-3">
      <div class="sec-head">
        <h2 class="sec-title">
          <span class="accent-line" style="background:linear-gradient(180deg,#475569,#94a3b8)"></span>
          <span class="vip-badge vip-free me-1">Miễn phí</span> Tin đăng miễn phí
        </h2>
        <a href="#" class="sec-more">Xem tất cả <i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="row g-2">
        @forelse($postFree as $post)
          <div class="col-12 col-md-4">
            <div class="card-small">
              <div class="img-wrap">
                <img src="{{ asset('storage/' . ($post->images->first()->image ?? 'default.jpg')) }}"
                  alt="{{ $post->title }}" loading="lazy">
              </div>
              <div class="body">
                <div class="d-flex align-items-center justify-content-between mb-1">
                  <span class="vip-badge vip-free">Miễn phí</span>
                  <span class="time-ago"><i class="bi bi-clock"></i> {{ $post->created_at->diffForHumans() }}</span>
                </div>
                <a href="" class="title-link">{{ $post->title }}</a>
                <div class="price mt-1">{{ number_format($post->price) }}đ/tháng</div>
                <div class="meta-row">
                  <span class="meta-chip"><i class="bi bi-rulers"></i> {{ $post->area }}m²</span>
                  <span class="meta-chip"><i class="bi bi-geo-alt"></i> {{ $post->ward->name ?? '' }}</span>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-muted text-center py-3">Chưa có tin miễn phí nào.</p>
          </div>
        @endforelse
      </div>
    </div>

  </div>

@endsection