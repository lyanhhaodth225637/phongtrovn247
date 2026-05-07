{{-- ── Inline style chỉ cho trang mới nhất ── --}}
<style>
    .new-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }

    @media (min-width: 576px) {
        .new-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (min-width: 992px) {
        .new-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (min-width: 1200px) {
        .new-grid {
            grid-template-columns: repeat(5, 1fr);
        }
    }

    .new-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(15, 23, 42, .08);
        transition: .2s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .new-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, .12);
    }

    .new-card-img {
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
    }

    .new-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .new-card-top-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        z-index: 2;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 700;
        color: #fff;
        line-height: 1;
        box-shadow: 0 4px 10px rgba(0, 0, 0, .12);
    }

    .new-card-img-count {
        position: absolute;
        right: 8px;
        bottom: 8px;
        z-index: 2;
        background: rgba(15, 23, 42, .75);
        color: #fff;
        padding: 4px 8px;
        border-radius: 999px;
        font-size: .72rem;
    }

    .new-card-body {
        padding: 12px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .new-time {
        font-size: .74rem;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .new-title {
        font-size: .92rem;
        font-weight: 800;
        line-height: 1.45;
        text-decoration: none;
        display: block;
        margin-top: 6px;
    }

    .new-title:hover {
        opacity: .9;
    }

    .new-price {
        font-size: .96rem;
        font-weight: 800;
        color: #dc2626;
        margin-top: 6px;
    }

    .new-meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 8px;
    }

    .new-meta-chip {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 9px;
        border-radius: 999px;
        background: #f1f5f9;
        color: #475569;
        font-size: .72rem;
    }

    .new-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-top: auto;
        padding-top: 10px;
    }

    .new-poster {
        font-size: .76rem;
        color: #475569;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .new-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .save-btn {
        width: 34px;
        height: 34px;
        border: 1px solid #e2e8f0;
        background: #fff;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        transition: .2s ease;
    }

    .save-btn:hover {
        color: #dc2626;
        border-color: #fecaca;
        background: #fff5f5;
    }

    .save-btn.saved {
        color: #dc2626;
        border-color: #fecaca;
        background: #fff1f2;
    }

    .phone-btn {
        border: none;
        border-radius: 999px;
        padding: 7px 12px;
        font-size: .72rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #fff;
    }
</style>

{{-- ══ TAB: MỚI NHẤT ══ --}}
<div class="tab-pane-custom active" id="tab-moiNhat">

    @php
        $currentCategory = $categories->firstWhere('id', request('category'));
    @endphp

    <div class="sec-head mb-3">
        <h2 class="sec-title">
            <span class="accent-line" style="background:linear-gradient(180deg,#0b5ed7,#3b82f6)"></span>

            @if($currentCategory)
                Tin mới nhất - {{ $currentCategory->name }}
            @else
                Tin đăng mới nhất
            @endif
        </h2>
    </div>

    <div class="new-grid">
        @forelse($newPosts as $post)
            @php
                $membershipSlug = $post->membership->slug ?? null;
                $color = $post->membership->color ?? '#64748b';

                $postType = match ($membershipSlug) {
                    'vip-5', 'vip-4' => 'featured',
                     'vip-1' => 'suggest',
                    default => 'normal',
                };

                $topLabel = match ($postType) {
                    'featured' => 'Nổi bật',
                    'suggest' => 'Đề xuất',
                    default => 'Tin thường',
                };

                $showSaveButton = in_array($postType, ['featured', 'suggest']);

                $isSaved = auth()->check()
                    && auth()->user()->savedPosts()->where('post_id', $post->id)->exists();
            @endphp

            <div class="new-card" style="border-top:3px solid {{ $color }};">
                <div class="new-card-img">
                    <a href="{{ route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]) }}">
                        <img src="{{ asset('storage/' . ($post->images->first()->image ?? 'default.jpg')) }}"
                            alt="{{ $post->title }}" loading="lazy">
                    </a>

                    <span class="hot-tag" style="background: {{ $color }}; color: #fff; border-color: {{ $color }};">
                        <i class="bi bi-fire"></i> {{ $post->membership->name ?? 'Đề Xuất' }}
                    </span>

                    @if($post->images->count() > 1)
                        <span class="new-card-img-count">
                            <i class="bi bi-images"></i> {{ $post->images->count() }}
                        </span>
                    @endif
                </div>

                <div class="new-card-body">
                    <span class="new-time">
                        <i class="bi bi-clock"></i>
                        {{ $post->created_at->diffForHumans() }}
                    </span>

                    <a href="{{ route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                        class="new-title" style="color: {{ $color }}">
                        {{ \Illuminate\Support\Str::limit($post->title, 60) }}
                    </a>

                    <div class="new-price">
                        {{ number_format($post->price, 0, ',', '.') }}đ/{{ $post->price_unit == 'day' ? 'ngày' : 'tháng' }}
                    </div>

                    <div class="new-meta-row">
                        <span class="new-meta-chip">
                            <i class="bi bi-rulers"></i> {{ $post->area }}m²
                        </span>

                        <span class="new-meta-chip">
                            <i class="bi bi-geo-alt"></i> {{ $post->ward?->name }}
                        </span>

                        @if($post->ward?->province)
                            <span class="new-meta-chip">
                                <i class="bi bi-map"></i> {{ $post->ward->province->name }}
                            </span>
                        @endif
                    </div>

                    <div class="new-bottom">
                        <span class="new-poster">
                            <i class="bi bi-person-fill"></i>
                            {{ $post->user?->name ?? 'Ẩn danh' }}
                        </span>

                        <div class="new-actions">
                            @if($showSaveButton)
                                <form action="{{ route('saved-post.store', ['id' => $post->id]) }}" method="POST"
                                    class="save-form">
                                    @csrf
                                    <button type="submit" class="save-btn {{ $isSaved ? 'saved' : '' }}"
                                        aria-label="{{ $isSaved ? 'Bỏ lưu tin' : 'Lưu tin' }}">
                                        <i class="bi {{ $isSaved ? 'bi-bookmark-check-fill' : 'bi-bookmark-plus' }}"></i>
                                    </button>
                                </form>
                            @endif

                            @if(!empty($post->user?->phone))
                                <button class="phone-btn" data-phone="{{ $post->user?->phone ?? '' }}"
                                    style="background:{{ $color }}; border-color:{{ $color }};">
                                    <i class="bi bi-telephone-fill"></i>
                                    {{ substr($post->user->phone, 0, 3) }}*****{{ substr($post->user->phone, -2) }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted text-center py-4">
                    Chưa có tin mới nào.
                </p>
            </div>
        @endforelse
    </div>

    @if($newPosts->hasPages())
        @php
            $currentPage = $newPosts->currentPage();
            $lastPage = $newPosts->lastPage();
            $start = max(1, $currentPage - 2);
            $end = min($lastPage, $currentPage + 2);
        @endphp

        <div class="d-flex justify-content-center align-items-center gap-1 mt-4 flex-wrap">

            @if ($newPosts->onFirstPage())
                <span class="page-btn disabled">
                    <i class="bi bi-chevron-left"></i>
                </span>
            @else
                <a href="{{ $newPosts->previousPageUrl() }}" class="page-btn">
                    <i class="bi bi-chevron-left"></i>
                </a>
            @endif

            @if ($start > 1)
                <a href="{{ $newPosts->url(1) }}" class="page-btn {{ $currentPage == 1 ? 'active' : '' }}">1</a>

                @if ($start > 2)
                    <span class="page-btn" style="border:none;cursor:default;background:transparent">…</span>
                @endif
            @endif

            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $currentPage)
                    <span class="page-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $newPosts->url($page) }}" class="page-btn">{{ $page }}</a>
                @endif
            @endfor

            @if ($end < $lastPage)
                @if ($end < $lastPage - 1)
                    <span class="page-btn" style="border:none;cursor:default;background:transparent">…</span>
                @endif

                <a href="{{ $newPosts->url($lastPage) }}" class="page-btn {{ $currentPage == $lastPage ? 'active' : '' }}">
                    {{ $lastPage }}
                </a>
            @endif

            @if ($newPosts->hasMorePages())
                <a href="{{ $newPosts->nextPageUrl() }}" class="page-btn">
                    <i class="bi bi-chevron-right"></i>
                </a>
            @else
                <span class="page-btn disabled">
                    <i class="bi bi-chevron-right"></i>
                </span>
            @endif

        </div>
    @endif
</div>