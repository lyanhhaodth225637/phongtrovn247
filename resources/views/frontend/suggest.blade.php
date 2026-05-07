{{-- ══ TAB: ĐỀ XUẤT ══ --}}
<div class="tab-pane-custom active" id="tab-deXuat">
    @php
        $currentCategory = $categories->firstWhere('id', request('category'))
            ?? $categories->firstWhere('slug', request('category'));

        $deXuatColor = $postVip5->first()?->membership?->color ?? '#ef4444';
        $noiBatColor = $postVip4->first()?->membership?->color ?? '#f97316';
        $thuongColor = $postVip1->first()?->membership?->color ?? '#10b981';
    @endphp

    @if($currentCategory)
        <div class="container mt-3">
            <h5 class="mb-0">Danh mục đang xem: {{ $currentCategory->name }}</h5>
        </div>
    @endif

    {{-- ── Đề xuất ── --}}
    <div class="mb-4">
        <div class="sec-head">
            <h2 class="sec-title">
                <span class="accent-line"
                    style="background: linear-gradient(180deg, {{ $deXuatColor }}, {{ $deXuatColor }}cc)"></span>
                <span class="vip-badge vip-5 me-1"
                    style="background: {{ $deXuatColor }}; border-color: {{ $deXuatColor }}; color: #fff;">
                    <i class="bi bi-star-fill"></i> Đề Xuất
                </span>
            </h2>
            <a href="{{ route('frontend.all-post.suggest', request()->except('page')) }}" class="sec-more">Xem tất cả <i
                    class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-lg-4">
            @forelse($postVip5 as $post)
                @php
                    $color = $post->membership->color ?? '#ef4444';
                @endphp

                <div class="col">
                    <div class="card-vip5 h-100 position-relative" style="border-top: 3px solid {{ $color }};">
                        <div class="img-wrap">
                            <img src="{{ asset('storage/' . ($post->images->first()->image ?? 'default.jpg')) }}"
                                alt="{{ $post->title }}" loading="lazy">

                            @if($post->images->count() > 0)
                                <span class="hot-tag"
                                    style="background: {{ $color }}; color: #fff; border-color: {{ $color }};">
                                    <i class="bi bi-fire"></i> {{ $post->membership->name ?? 'Đề Xuất' }}
                                </span>
                                <span class="img-count">
                                    <i class="bi bi-images"></i> {{ $post->images->count() }}
                                </span>
                            @endif
                        </div>

                        <div class="body">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="vip-badge vip-5"
                                    style="background: {{ $color }}; border-color: {{ $color }}; color: #fff;">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </span>
                                <span class="time-ago">
                                    <i class="bi bi-clock"></i> {{ $post->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <div class="price">{{ number_format($post->price, 0, ',', '.') }} đ/tháng</div>

                            <a href="{{ route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                class="title-link stretched-link mt-1" style="color: {{ $color }}; font-weight: 700;">
                                {{ $post->title }}
                            </a>

                            <div class="meta-row">
                                <span class="meta-chip"><i class="bi bi-rulers"></i> {{ $post->area }}m²</span>
                                <span class="meta-chip"><i class="bi bi-geo-alt"></i> {{ $post->ward->name ?? '' }}</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-auto pt-2">
                                <span class="poster-name">
                                    <i class="bi bi-person-fill"></i> {{ $post->user->name ?? 'Ẩn danh' }}
                                </span>

                                <div class="d-flex gap-2" style="position: relative; z-index: 1;">

                                    @php
                                        $isSaved = auth()->check()
                                            && auth()->user()->savedPosts()
                                                ->where('post_id', $post->id)
                                                ->exists();
                                    @endphp

                                    <form action="{{ route('saved-post.store', ['id' => $post->id]) }}" method="POST"
                                        class="save-form">
                                        @csrf

                                        <button type="submit" class="save-btn {{ $isSaved ? 'saved' : '' }}"
                                            aria-label="{{ $isSaved ? 'Bỏ lưu tin' : 'Lưu tin' }}">

                                            @if($isSaved)
                                                <i class="bi bi-bookmark-check-fill"></i>
                                            @else
                                                <i class="bi bi-bookmark-plus"></i>
                                            @endif

                                        </button>
                                    </form>
                                    <button class="phone-btn" data-phone="{{ $post->user->phone ?? '' }}"
                                        style="background: {{ $color }}; border-color: {{ $color }}; color: #fff;">
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
                    <p class="text-muted text-center py-3">Chưa có tin nào.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- ── Nổi bật ── --}}
    <div class="mb-4">
        <div class="sec-head">
            <h2 class="sec-title">
                <span class="accent-line"
                    style="background: linear-gradient(180deg, {{ $noiBatColor }}, {{ $noiBatColor }}cc)"></span>
                <span class="vip-badge vip-4 me-1"
                    style="background: {{ $noiBatColor }}; border-color: {{ $noiBatColor }}; color: #fff;">
                    <i class="bi bi-star-half"></i> Nổi Bật
                </span>
            </h2>
            <a href="{{ route('frontend.all-post.featured', request()->except('page')) }}" class="sec-more">Xem tất cả <i
                    class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row g-2">
            @forelse($postVip4 as $post)
                @php
                    $color = $post->membership->color ?? '#f97316';
                @endphp

                <div class="col-12 col-md-6">
                    <div class="card-vip4 h-100 position-relative" style="border-left: 4px solid {{ $color }};">
                        <div class="img-wrap" style="position: relative;">
                            <img src="{{ asset('storage/' . ($post->images->first()->image ?? 'default.jpg')) }}"
                                alt="{{ $post->title }}" loading="lazy">

                            <span class="hot-tag"
                                style="background: {{ $color }}; color: #fff; border-color: {{ $color }};">
                                <i class="bi bi-fire"></i> {{ $post->membership->name ?? 'Nổi Bật' }}
                            </span>
                        </div>

                        <div class="body d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="poster-name">
                                    <i class="bi bi-person-fill"></i> {{ $post->user->name ?? 'Ẩn danh' }}
                                </span>
                                <span class="time-ago">
                                    <i class="bi bi-clock"></i> {{ $post->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <a href="{{ route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                class="title-link stretched-link mt-1" style="color: {{ $color }}; font-weight: 700;">
                                {{ $post->title }}
                            </a>

                            <div class="price mt-1">{{ number_format($post->price, 0, ',', '.') }} đ/tháng</div>

                            <div class="meta-row mt-1">
                                <span class="meta-chip"><i class="bi bi-rulers"></i> {{ $post->area }}m²</span>
                                <span class="meta-chip"><i class="bi bi-geo-alt"></i> {{ $post->ward->name ?? '' }}</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-auto pt-2">
                                <span class="text-muted small">
                                    <i class="bi bi-images"></i> {{ $post->images->count() }} ảnh
                                </span>
                                <div class="d-flex gap-2" style="position: relative; z-index: 1;">

                                    @php
                                        $isSaved = auth()->check()
                                            && auth()->user()->savedPosts()
                                                ->where('post_id', $post->id)
                                                ->exists();
                                    @endphp

                                    <form action="{{ route('saved-post.store', ['id' => $post->id]) }}" method="POST"
                                        class="save-form">
                                        @csrf

                                        <button type="submit" class="save-btn {{ $isSaved ? 'saved' : '' }}"
                                            aria-label="{{ $isSaved ? 'Bỏ lưu tin' : 'Lưu tin' }}">

                                            @if($isSaved)
                                                <i class="bi bi-bookmark-check-fill"></i>
                                            @else
                                                <i class="bi bi-bookmark-plus"></i>
                                            @endif

                                        </button>
                                    </form>
                                    <button class="phone-btn" data-phone="{{ $post->user->phone ?? '' }}"
                                        style="background: {{ $color }}; border-color: {{ $color }}; color: #fff;">
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
                    <p class="text-muted text-center py-3">Chưa có tin nào.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- ── Thường ── --}}
    <div class="mb-4">
        <div class="sec-head">
            <h2 class="sec-title">
                <span class="accent-line"
                    style="background: linear-gradient(180deg, {{ $thuongColor }}, {{ $thuongColor }}cc)"></span>
                <span class="vip-badge vip-1 me-1"
                    style="background: {{ $thuongColor }}; border-color: {{ $thuongColor }}; color: #fff;">
                    <i class="bi bi-patch-check-fill"></i> Thường
                </span>
            </h2>
            <a href="{{ route('frontend.all-post.normal', request()->except('page')) }}" class="sec-more">Xem tất cả <i
                    class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row g-2">
            @forelse($postVip1 as $post)
                @php
                    $color = $post->membership->color ?? '#10b981';
                @endphp

                <div class="col-12 col-md-4">
                    <div class="card-small h-100 position-relative" style="border-top: 3px solid {{ $color }};">
                        <div class="img-wrap">
                            <img src="{{ asset('storage/' . ($post->images->first()->image ?? 'default.jpg')) }}"
                                alt="{{ $post->title }}" loading="lazy">
                        </div>

                        <div class="body d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <span class="hot-tag"
                                    style="background: {{ $color }}; color: #fff; border-color: {{ $color }};">
                                    <i class="bi bi-fire"></i> {{ $post->membership->name ?? 'Thường' }}
                                </span>
                                <span class="time-ago">
                                    <i class="bi bi-clock"></i> {{ $post->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <a href="{{ route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                class="title-link stretched-link" style="color: {{ $color }}; font-weight: 700;">
                                {{ $post->title }}
                            </a>

                            <div class="price mt-1">{{ number_format($post->price, 0, ',', '.') }} đ/tháng</div>

                            <div class="meta-row mt-1">
                                <span class="meta-chip"><i class="bi bi-rulers"></i> {{ $post->area }}m²</span>
                                <span class="meta-chip"><i class="bi bi-geo-alt"></i> {{ $post->ward->name ?? '' }}</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-auto pt-2">
                                <span class="poster-name">
                                    <i class="bi bi-person-fill"></i> {{ $post->user->name ?? 'Ẩn danh' }}
                                </span>
                                <span class="text-muted small">
                                    <i class="bi bi-images"></i> {{ $post->images->count() }} ảnh
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted text-center py-3">Chưa có tin nào.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
