@extends('layouts.frontend.app')

@section('content')
    <div class="container">

        {{-- Header --}}
        <div class="listing-page-header">
            <div class="listing-page-header-left">

                @php
                    $badgeClass = match ($type) {
                        'suggest' => 'vip-5',
                        'featured' => 'vip-4',
                        default => 'vip-1',
                    };

                    $icon = match ($type) {
                        'suggest' => 'bi-star-fill',
                        'featured' => 'bi-star-half',
                        default => 'bi-patch-check-fill',
                    };

                    // Màu dự phòng chỉ dùng khi bài đăng không có membership hoặc membership chưa khai báo color.
                    $fallbackColor = match ($type) {
                        'suggest' => '#ef4444',   // Tin đề xuất
                        'featured' => '#f97316',  // Tin nổi bật
                        default => '#10b981',     // Tin thường
                    };

                    // Header là màu đại diện của trang. Ưu tiên lấy màu từ membership của bài đầu tiên.
                    $headerColor = $posts->first()?->membership?->color ?: $fallbackColor;

                    $badgeLabel = match ($type) {
                        'suggest' => 'Đề xuất',
                        'featured' => 'Nổi bật',
                        default => 'Thường',
                    };
                @endphp

                <span class="vip-badge {{ $badgeClass }}" style="background:{{ $headerColor }}; color:#fff;">
                    <i class="bi {{ $icon }}"></i>
                    {{ $title }}
                </span>

                <p class="listing-page-count mt-2 mb-0">
                    Có <strong>{{ $posts->total() }}</strong> bài đăng
                </p>
            </div>
        </div>

        {{-- Bài viết đề xuất --}}
        @if($type === 'suggest')
            @if($posts->count())
                <div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-lg-4 mb-4">
                    @foreach($posts as $post)
                        @php
                            $color = $post->membership?->color ?: $fallbackColor;
                            $isSaved = auth()->check() && auth()->user()->savedPosts()->where('post_id', $post->id)->exists();
                            $phone = $post->user?->phone ?? '0000000000';
                        @endphp

                        <div class="col">
                            <div class="card-vip5 h-100 position-relative" style="border-top:3px solid {{ $color }};">
                                <div class="img-wrap">
                                    <a href="{{ route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]) }}">
                                        <img src="{{ asset('storage/' . ($post->images->first()->image ?? 'default.jpg')) }}"
                                            alt="{{ $post->title }}" loading="lazy">
                                    </a>

                                    <span class="hot-tag" style="background:{{ $color }};">
                                        <i class="bi bi-fire"></i>
                                        {{ $post->membership?->name ?? $badgeLabel }}
                                    </span>

                                    @if($post->images->count() > 1)
                                        <span class="img-count">
                                            <i class="bi bi-images"></i> {{ $post->images->count() }}
                                        </span>
                                    @endif
                                </div>

                                <div class="body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="vip-badge vip-5" style="background:{{ $color }}; color:#fff;">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                        </span>

                                        <span class="time-ago">
                                            <i class="bi bi-clock"></i>
                                            {{ $post->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <div class="price">
                                        {{ number_format($post->price, 0, ',', '.') }}đ/
                                        {{ $post->price_unit === 'day' ? 'ngày' : 'tháng' }}
                                    </div>

                                    <a href="{{ route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                        class="title-link stretched-link mt-2" style="color:{{ $color }};">
                                        {{ Str::limit($post->title, 60) }}
                                    </a>

                                    <div class="meta-row mt-2">
                                        <span class="meta-chip">
                                            <i class="bi bi-rulers"></i> {{ $post->area }}m²
                                        </span>

                                        <span class="meta-chip">
                                            <i class="bi bi-geo-alt"></i> {{ $post->ward?->name }}
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3 position-relative"
                                        style="z-index:2;">
                                        <span class="poster-name">
                                            <i class="bi bi-person-fill"></i>
                                            {{ $post->user?->name ?? 'Ẩn danh' }}
                                        </span>

                                        <div class="d-flex gap-2">
                                            <form action="{{ route('saved-post.store', ['id' => $post->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="save-btn {{ $isSaved ? 'saved' : '' }}"
                                                    aria-label="{{ $isSaved ? 'Bỏ lưu tin' : 'Lưu tin' }}">
                                                    <i class="bi {{ $isSaved ? 'bi-bookmark-check-fill' : 'bi-bookmark-plus' }}"></i>
                                                </button>
                                            </form>

                                            <button type="button" class="phone-btn" data-phone="{{ $post->user?->phone ?? '' }}"
                                                style="background:{{ $color }}; border-color:{{ $color }}; color:#fff;">
                                                <i class="bi bi-telephone-fill"></i>
                                                {{ substr($phone, 0, 3) }}*****{{ substr($phone, -2) }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="lp-empty text-center py-5">
                    <div class="empty-icon mb-3">
                        <i class="bi bi-inbox" style="font-size:48px;"></i>
                    </div>
                    <h4>Chưa có bài đăng nào</h4>
                    <p class="text-muted">Hiện chưa có bài viết trong mục này.</p>
                </div>
            @endif

            {{-- Bài viết nổi bật --}}
        @elseif($type === 'featured')
            @if($posts->count())
                <div class="row g-3 mb-4">
                    @foreach($posts as $post)
                        @php
                            $color = $post->membership?->color ?: $fallbackColor;
                            $isSaved = auth()->check() && auth()->user()->savedPosts()->where('post_id', $post->id)->exists();
                            $phone = $post->user?->phone ?? '0000000000';
                        @endphp

                        <div class="col-12 col-md-6">
                            <div class="card-vip4 h-100 position-relative" style="border-left:4px solid {{ $color }};">
                                <div class="img-wrap position-relative">
                                    <a href="{{ route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]) }}">
                                        <img src="{{ asset('storage/' . ($post->images->first()->image ?? 'default.jpg')) }}"
                                            alt="{{ $post->title }}" loading="lazy">
                                    </a>

                                    <span class="vip-badge vip-4"
                                        style="position:absolute; top:8px; left:8px; background:{{ $color }}; color:#fff;">
                                        <i class="bi bi-star-half"></i>
                                        {{ $post->membership?->name ?? $badgeLabel }}
                                    </span>
                                </div>

                                <div class="body d-flex flex-column">
                                    <a href="{{ route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                        class="title-link mt-2 stretched-link" style="color:{{ $color }};">
                                        {{ Str::limit($post->title, 70) }}
                                    </a>

                                    <div class="price mt-2">
                                        {{ number_format($post->price, 0, ',', '.') }}đ/
                                        {{ $post->price_unit === 'day' ? 'ngày' : 'tháng' }}
                                    </div>

                                    <div class="meta-row mt-2">
                                        <span class="meta-chip"><i class="bi bi-rulers"></i> {{ $post->area }}m²</span>
                                        <span class="meta-chip"><i class="bi bi-geo-alt"></i> {{ $post->ward?->name }}</span>
                                        @if($post->ward?->province)
                                            <span class="meta-chip"><i class="bi bi-map"></i> {{ $post->ward->province->name }}</span>
                                        @endif
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3 position-relative"
                                        style="z-index:2;">
                                        <span class="poster-name">
                                            <i class="bi bi-person-fill"></i>
                                            {{ $post->user?->name ?? 'Ẩn danh' }}
                                        </span>

                                        <div class="d-flex gap-2">
                                            <form action="{{ route('saved-post.store', ['id' => $post->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="save-btn {{ $isSaved ? 'saved' : '' }}"
                                                    aria-label="{{ $isSaved ? 'Bỏ lưu tin' : 'Lưu tin' }}">
                                                    <i class="bi {{ $isSaved ? 'bi-bookmark-check-fill' : 'bi-bookmark-plus' }}"></i>
                                                </button>
                                            </form>

                                            <button type="button" class="phone-btn" data-phone="{{ $post->user?->phone ?? '' }}"
                                                style="background:{{ $color }}; border-color:{{ $color }}; color:#fff;">
                                                <i class="bi bi-telephone-fill"></i>
                                                {{ substr($phone, 0, 3) }}*****{{ substr($phone, -2) }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="lp-empty text-center py-5">
                    <div class="empty-icon mb-3">
                        <i class="bi bi-inbox" style="font-size:48px;"></i>
                    </div>
                    <h4>Chưa có bài đăng nào</h4>
                    <p class="text-muted">Hiện chưa có bài viết trong mục này.</p>
                </div>
            @endif

            {{-- Bài thường --}}
        @else
            @if($posts->count())
                <div class="row g-3 mb-4">
                    @foreach($posts as $post)
                        @php
                            $color = $post->membership?->color ?: $fallbackColor;
                            $isSaved = auth()->check() && auth()->user()->savedPosts()->where('post_id', $post->id)->exists();
                            $phone = $post->user?->phone ?? '0000000000';
                        @endphp

                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card-small h-100 position-relative" style="border-top:3px solid {{ $color }};">
                                <div class="img-wrap">
                                    <a href="{{ route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]) }}">
                                        <img src="{{ asset('storage/' . ($post->images->first()->image ?? 'default.jpg')) }}"
                                            alt="{{ $post->title }}" loading="lazy">
                                    </a>
                                </div>

                                <div class="body d-flex flex-column">
                                    <span class="vip-badge vip-1 mb-2" style="background:{{ $color }}; color:#fff; width:max-content;">
                                        <i class="bi bi-patch-check-fill"></i>
                                        {{ $post->membership?->name ?? $badgeLabel }}
                                    </span>

                                    <a href="{{ route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                        class="title-link stretched-link" style="color:{{ $color }};">
                                        {{ Str::limit($post->title, 60) }}
                                    </a>

                                    <div class="price mt-2">
                                        {{ number_format($post->price, 0, ',', '.') }}đ/
                                        {{ $post->price_unit === 'day' ? 'ngày' : 'tháng' }}
                                    </div>

                                    <div class="meta-row mt-2">
                                        <span class="meta-chip"><i class="bi bi-rulers"></i> {{ $post->area }}m²</span>
                                        <span class="meta-chip"><i class="bi bi-geo-alt"></i> {{ $post->ward?->name }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3 position-relative"
                                        style="z-index:2;">
                                        <span class="poster-name">
                                            <i class="bi bi-person-fill"></i>
                                            {{ $post->user?->name ?? 'Ẩn danh' }}
                                        </span>

                                        <div class="d-flex gap-2">
                                            <form action="{{ route('saved-post.store', ['id' => $post->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="save-btn {{ $isSaved ? 'saved' : '' }}"
                                                    aria-label="{{ $isSaved ? 'Bỏ lưu tin' : 'Lưu tin' }}">
                                                    <i class="bi {{ $isSaved ? 'bi-bookmark-check-fill' : 'bi-bookmark-plus' }}"></i>
                                                </button>
                                            </form>

                                            <button type="button" class="phone-btn" data-phone="{{ $post->user?->phone ?? '' }}"
                                                style="background:{{ $color }}; border-color:{{ $color }}; color:#fff;">
                                                <i class="bi bi-telephone-fill"></i>
                                                {{ substr($phone, 0, 3) }}*****{{ substr($phone, -2) }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="lp-empty text-center py-5">
                    <div class="empty-icon mb-3">
                        <i class="bi bi-inbox" style="font-size:48px;"></i>
                    </div>
                    <h4>Chưa có bài đăng nào</h4>
                    <p class="text-muted">Hiện chưa có bài viết trong mục này.</p>
                </div>
            @endif
        @endif

        @if($posts->hasPages())
            <div class="lp-pagination mt-4">
                {{ $posts->links() }}
            </div>
        @endif

    </div>
@endsection