@extends('layouts.frontend.app')

@section('content')

    <style>
        /* ───────── Tin đã lưu - saved-posts.css ─────────
           Dựa theo home.css design system
        ───────────────────────────────────────────── */

        /* ───── Page Header ───── */
        .saved-header {
            padding: 28px 0 20px;
            border-bottom: 1.5px solid var(--border);
            margin-bottom: 28px;
        }

        .saved-header h3 {
            font-family: 'Sora', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 4px;
            letter-spacing: -0.3px;
        }

        .saved-header h3 i {
            color: #e02424;
            font-size: 1.3rem;
            margin-right: 4px;
        }

        .saved-header p.text-muted {
            font-size: 0.82rem;
            color: var(--muted);
            margin: 0;
        }

        /* ───── Card Grid ───── */
        .saved-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        /* ───── Saved Post Card ───── */
        .saved-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: box-shadow .2s, transform .2s;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .saved-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-3px);
        }

        /* ───── Card Image ───── */
        .saved-card-img-wrap {
            position: relative;
            aspect-ratio: 16 / 10;
            overflow: hidden;
            flex-shrink: 0;
        }

        .saved-card-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .35s;
        }

        .saved-card:hover .saved-card-img-wrap img {
            transform: scale(1.05);
        }

        .bookmark-overlay {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 32px;
            height: 32px;
            background: rgba(255, 255, 255, .92);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e02424;
            font-size: .95rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .12);
            pointer-events: none;
        }

        /* ───── Card Body ───── */
        .saved-card .card-body {
            padding: 14px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .badge-row {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 2px;
        }

        .badge-membership {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-size: .62rem;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: .3px;
            color: #fff;
        }

        .badge-category {
            background: var(--surface2);
            color: var(--muted);
            font-size: .68rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 4px;
            border: 1px solid var(--border);
        }

        .card-title {
            font-weight: 700;
            font-size: .88rem;
            line-height: 1.45;
            margin: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-title a {
            color: var(--text);
            text-decoration: none;
            transition: color .15s;
        }

        .card-title a:hover {
            color: var(--primary);
        }

        .location-row {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: .74rem;
            color: var(--muted);
        }

        .location-row i {
            font-size: .78rem;
            color: #e02424;
            flex-shrink: 0;
        }

        .price-area-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 2px;
            gap: 10px;
        }

        .price {
            font-size: 1rem;
            font-weight: 800;
            color: #e02424;
            letter-spacing: -.01em;
        }

        .area {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            background: var(--surface2);
            color: var(--muted);
            font-size: .72rem;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 4px;
            border: 1px solid var(--border);
            white-space: nowrap;
        }

        /* ───── Card Footer Actions ───── */
        .card-actions {
            margin-top: auto;
            padding-top: 10px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-view-detail {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 20px;
            font-family: 'Be Vietnam Pro', sans-serif;
            font-weight: 700;
            font-size: .78rem;
            padding: 8px 14px;
            text-decoration: none;
            transition: background .18s, transform .12s;
            white-space: nowrap;
        }

        .btn-view-detail:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-unsave {
            width: 36px;
            height: 36px;
            border-radius: 20px;
            border: 1.5px solid #fecdd3;
            background: #fff1f2;
            color: #e02424;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            transition: background .18s, border-color .18s, transform .12s;
            flex-shrink: 0;
        }

        .btn-unsave:hover {
            background: #fee2e2;
            border-color: #e02424;
            transform: scale(1.08);
        }

        /* ───── Empty State ───── */
        .saved-empty {
            text-align: center;
            padding: 64px 20px;
            background: var(--surface);
            border: 1.5px dashed var(--border2);
            border-radius: var(--radius);
        }

        .saved-empty .empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: var(--surface2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--muted);
            border: 1.5px solid var(--border);
        }

        .saved-empty h4 {
            font-family: 'Sora', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }

        .saved-empty p {
            font-size: .82rem;
            color: var(--muted);
            max-width: 320px;
            margin: 0 auto 24px;
            line-height: 1.7;
        }

        .btn-explore {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e02424;
            color: #fff;
            border: none;
            border-radius: 20px;
            font-family: 'Be Vietnam Pro', sans-serif;
            font-weight: 700;
            font-size: .85rem;
            padding: 11px 28px;
            text-decoration: none;
            transition: filter .18s, transform .12s;
        }

        .btn-explore:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
            color: #fff;
        }

        /* ───── Pagination ───── */
        .saved-pagination {
            display: flex;
            justify-content: center;
            margin-top: 8px;
            margin-bottom: 28px;
        }

        .saved-pagination .pagination {
            margin: 0;
        }

        .saved-pagination .page-link {
            border-radius: 10px !important;
            margin: 0 3px;
            border: 1px solid var(--border);
            color: var(--text2);
            font-size: .82rem;
            font-weight: 600;
            min-width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .18s;
        }

        .saved-pagination .page-link:hover {
            background: var(--surface2);
            border-color: var(--primary);
            color: var(--primary);
        }

        .saved-pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 2px 8px rgba(13, 110, 253, .25);
        }

        /* ───── Responsive ───── */
        @media (max-width: 768px) {
            .saved-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 14px;
            }

            .saved-header h3 {
                font-size: 1.15rem;
            }

            .saved-card .card-body {
                padding: 11px;
            }

            .price {
                font-size: .88rem;
            }
        }

        @media (max-width: 480px) {
            .saved-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .saved-header {
                padding: 20px 0 14px;
                margin-bottom: 18px;
            }

            .btn-view-detail {
                font-size: .75rem;
                padding: 7px 12px;
            }

            .saved-empty {
                padding: 44px 16px;
            }

            .saved-empty .empty-icon {
                width: 64px;
                height: 64px;
                font-size: 1.6rem;
            }
        }
    </style>

    <div class="container">

        {{-- Header --}}
        <div class="saved-header">
            <h3>
                <i class="bi bi-bookmark-heart-fill"></i>
                Tin đã lưu
            </h3>
            <p class="text-muted">
                Bạn đã lưu {{ $savedPosts->total() }} tin
            </p>
        </div>

        @if($savedPosts->count())

            <div class="saved-grid">
                @foreach($savedPosts as $post)
                    <div class="saved-card">

                        {{-- Ảnh --}}
                        <div class="saved-card-img-wrap">
                            <a href="{{ route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]) }}">
                                <img src="{{ asset('storage/' . ($post->images->first()->image ?? 'default.jpg')) }}"
                                    alt="{{ $post->title }}" loading="lazy">
                            </a>

                            <div class="bookmark-overlay">
                                <i class="bi bi-bookmark-heart-fill"></i>
                            </div>
                        </div>

                        {{-- Nội dung --}}
                        <div class="card-body">

                            <div class="badge-row">
                                @if($post->membership)
                                    <span class="badge-membership" style="background: {{ $post->membership->color ?? '#0d6efd' }}">
                                        {{ $post->membership->name }}
                                    </span>
                                @endif

                                @if($post->category)
                                    <span class="badge-category">
                                        {{ $post->category->name }}
                                    </span>
                                @endif
                            </div>

                            <h5 class="card-title" style="color:{{ $post->membership->color }} !important">
                                <a href="{{ route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]) }}">
                                    {{ \Illuminate\Support\Str::limit($post->title, 60) }}
                                </a>
                            </h5>

                            <div class="location-row">
                                <i class="bi bi-geo-alt-fill"></i>

                                @if($post->ward)
                                    {{ $post->ward->name }}
                                    @if($post->ward->province)
                                        , {{ $post->ward->province->name }}
                                    @endif
                                @else
                                    Chưa cập nhật địa chỉ
                                @endif
                            </div>

                            <div class="price-area-row">
                                <div class="price">
                                    {{ number_format($post->price, 0, ',', '.') }}đ/tháng
                                </div>

                                <div class="area">
                                    <i class="bi bi-rulers"></i>
                                    {{ $post->area }}m²
                                </div>
                            </div>

                            <div class="card-actions">
                                <a href="{{ route('frontend.post.show', ['id' => $post->id, 'slug' => $post->slug]) }}"
                                    class="btn-view-detail">
                                    <i class="bi bi-eye"></i>
                                    Xem chi tiết
                                </a>

                                <form action="{{ route('saved-post.store', ['id' => $post->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-unsave" title="Bỏ lưu">
                                        <i class="bi bi-bookmark-x-fill"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <div class="saved-pagination">
                {{ $savedPosts->links() }}
            </div>

        @else

            <div class="saved-empty">
                <div class="empty-icon">
                    <i class="bi bi-bookmark-x"></i>
                </div>

                <h4>Bạn chưa lưu tin nào</h4>

                <p>
                    Hãy lưu những tin phòng trọ bạn quan tâm để xem lại sau nhé.
                </p>

                <a href="{{ route('frontend.home') }}" class="btn-explore">
                    <i class="bi bi-compass"></i>
                    Khám phá ngay
                </a>
            </div>

        @endif

    </div>

@endsection