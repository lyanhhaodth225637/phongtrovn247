@extends('layouts.frontend.app')

@section('content')
    <div class="container">
        <style>
            /* ══════════════════════════════════════════
       Tin tức — news.css
       Dựa theo home.css design system
       ══════════════════════════════════════════ */

            /* ── Header ── */
            .news-header {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 16px;
                padding: 28px 0 20px;
                border-bottom: 1.5px solid var(--border);
                margin-bottom: 28px;
                flex-wrap: wrap;
            }

            .news-header-left {
                display: flex;
                flex-direction: column;
                gap: 6px;
            }

            /* ── View toggle ── */
            .news-view-toggle {
                display: flex;
                gap: 4px;
                background: var(--surface);
                border: 1.5px solid var(--border);
                border-radius: 9px;
                padding: 4px;
                align-self: flex-start;
                margin-top: 6px;
            }

            .news-toggle-btn {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 6px 12px;
                border-radius: 6px;
                border: none;
                background: transparent;
                color: var(--muted);
                font-family: 'Be Vietnam Pro', sans-serif;
                font-size: 0.76rem;
                font-weight: 600;
                cursor: pointer;
                transition: background .15s, color .15s;
                white-space: nowrap;
            }

            .news-toggle-btn.active {
                background: var(--primary);
                color: #fff;
            }

            .news-toggle-btn:not(.active):hover {
                background: var(--surface2);
                color: var(--text2);
            }


            /* ── Source pill ── */
            .news-source-pill {
                position: absolute;
                bottom: 8px;
                left: 8px;
                background: rgba(13, 110, 253, .9);
                color: #fff;
                font-size: 0.6rem;
                font-weight: 800;
                padding: 3px 9px;
                border-radius: 20px;
                letter-spacing: 0.2px;
                pointer-events: none;
                backdrop-filter: blur(4px);
                text-transform: uppercase;
            }

            /* ── Category tag ── */
            .news-category-tag {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                background: #eff6ff;
                color: #1d4ed8;
                font-size: 0.65rem;
                font-weight: 700;
                padding: 3px 9px;
                border-radius: 4px;
                border: 1px solid #bfdbfe;
            }

            /* ── Meta row ── */
            .news-meta-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 8px;
                flex-wrap: wrap;
            }

            /* ── Read more ── */
            .news-read-more {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                font-size: 0.73rem;
                font-weight: 700;
                color: var(--primary);
                white-space: nowrap;
                transition: gap .18s;
            }

            .news-card:hover .news-read-more {
                gap: 8px;
            }

            /* ── No-image placeholder ── */
            .news-no-img {
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
                color: var(--border2);
                background: var(--surface2);
                min-height: 140px;
            }

            .news-no-img--lg {
                min-height: 220px;
                font-size: 2.8rem;
            }

            /* ══════════════════════════════════════════
       NEWS GRID
       ══════════════════════════════════════════ */
            .news-grid {
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 16px;
                margin-bottom: 28px;
            }

            /* ── News card ── */
            .news-card {
                background: var(--surface);
                border: 1.5px solid var(--border);
                border-radius: var(--radius);
                overflow: hidden;
                box-shadow: var(--shadow-sm);
                display: flex;
                flex-direction: column;
                text-decoration: none;
                color: inherit;
                transition: box-shadow .2s, transform .2s;
            }

            .news-card:hover {
                box-shadow: var(--shadow-hover);
                transform: translateY(-3px);
                color: inherit;
            }

            .news-card-img-wrap {
                position: relative;
                aspect-ratio: 16/9;
                overflow: hidden;
                flex-shrink: 0;
                background: var(--surface2);
            }

            .news-card-img-wrap img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
                transition: transform .35s;
            }

            .news-card:hover .news-card-img-wrap img {
                transform: scale(1.05);
            }

            .news-card-body {
                padding: 13px 14px;
                flex: 1;
                display: flex;
                flex-direction: column;
                gap: 7px;
            }

            .news-card-title {
                font-family: 'Sora', sans-serif;
                font-size: 0.85rem;
                font-weight: 700;
                color: var(--text);
                line-height: 1.5;
                margin: 0;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                transition: color .15s;
            }

            .news-card:hover .news-card-title {
                color: var(--primary);
            }

            .news-card-desc {
                font-size: 0.74rem;
                color: var(--muted);
                line-height: 1.65;
                margin: 0;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .news-card-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-top: auto;
                padding-top: 9px;
                border-top: 1px solid var(--border);
                gap: 6px;
            }

            /* ══════════════════════════════════════════
       LIST MODE
       ══════════════════════════════════════════ */
            .news-grid--list {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .news-grid--list .news-card {
                flex-direction: row;
            }

            .news-grid--list .news-card-img-wrap {
                width: 180px;
                min-width: 180px;
                aspect-ratio: unset;
                min-height: 120px;
            }

            .news-grid--list .news-card-img-wrap img {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }

            .news-grid--list .news-card-img-wrap {
                position: relative;
            }

            /* ══════════════════════════════════════════
       PAGINATION
       ══════════════════════════════════════════ */
            .news-pagination {
                display: flex;
                justify-content: center;
                padding: 20px 0 36px;
            }

            .news-pagination .pagination {
                display: flex;
                gap: 6px;
                margin: 0;
                padding: 0;
                list-style: none;
                align-items: center;
                flex-wrap: wrap;
                justify-content: center;
            }

            .news-pagination .page-item .page-link {
                width: 36px;
                height: 36px;
                border-radius: var(--radius-sm);
                border: 1.5px solid var(--border);
                background: var(--surface);
                color: var(--text2);
                font-size: 0.82rem;
                font-weight: 600;
                display: flex;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                font-family: 'Be Vietnam Pro', sans-serif;
                transition: border-color .18s, color .18s, background .18s;
            }

            .news-pagination .page-item .page-link:hover {
                border-color: var(--primary);
                color: var(--primary);
            }

            .news-pagination .page-item.active .page-link {
                background: var(--primary);
                border-color: var(--primary);
                color: #fff;
                box-shadow: 0 2px 8px rgba(13, 110, 253, .3);
            }

            .news-pagination .page-item.disabled .page-link {
                opacity: .4;
                pointer-events: none;
            }

            /* ══════════════════════════════════════════
       RESPONSIVE
       ══════════════════════════════════════════ */
            @media (max-width: 1200px) {
                .news-grid {
                    grid-template-columns: repeat(4, 1fr);
                }
            }

            @media (max-width: 992px) {
                .news-grid {
                    grid-template-columns: repeat(3, 1fr);
                    gap: 14px;
                }
            }

            @media (max-width: 768px) {
                .news-grid {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 12px;
                }
            }

            @media (max-width: 480px) {
                .news-grid {
                    grid-template-columns: 1fr;
                    gap: 12px;
                }

                .news-header {
                    padding: 18px 0 14px;
                    margin-bottom: 18px;
                }

                .news-grid--list .news-card {
                    flex-direction: column;
                }

                .news-grid--list .news-card-img-wrap {
                    width: 100%;
                    min-width: 0;
                }
            }
        </style>
        {{-- Header --}}
        <div class="news-header">
            <div class="news-header-left">
                <h2 class="listing-page-title"><i class="bi bi-newspaper"></i> Tin tức</h2>
                
            </div>

            <div class="news-view-toggle">
                <button class="news-toggle-btn active" onclick="setNewsView('grid', this)">
                    <i class="bi bi-grid-3x3-gap-fill"></i> Grid
                </button>
                <button class="news-toggle-btn" onclick="setNewsView('list', this)">
                    <i class="bi bi-list-ul"></i> List
                </button>
            </div>
        </div>

        @if($articles->isEmpty())
            <div class="lp-empty">
                <div class="empty-icon"><i class="bi bi-wifi-off"></i></div>
                <h4>Chưa tải được dữ liệu</h4>
                <p>Hiện chưa tải được dữ liệu RSS từ các nguồn tin. Vui lòng thử lại sau.</p>
            </div>
        @else

            {{-- Grid --}}
            <div class="news-grid" id="news-grid">
                @foreach($articles as $article)
                    @php
                        $sc = match ($article['source']) {
                            'CafeF' => ['pill' => '#ea580c', 'light' => '#fff7ed', 'text' => '#c2410c', 'bd' => '#fed7aa'],
                            'Tuổi Trẻ' => ['pill' => '#ef4444', 'light' => '#fff1f2', 'text' => '#b91c1c', 'bd' => '#fecdd3'],
                            'Thanh Niên' => ['pill' => '#059669', 'light' => '#f0fdf4', 'text' => '#15803d', 'bd' => '#bbf7d0'],
                            default => ['pill' => '#0d6efd', 'light' => '#eff6ff', 'text' => '#1d4ed8', 'bd' => '#bfdbfe'],
                        };
                    @endphp

                    <a href="{{ $article['link'] }}" target="_blank" rel="noopener noreferrer" class="news-card">

                        <div class="news-card-img-wrap">
                            @if($article['image'])
                                <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" loading="lazy">
                            @else
                                <div class="news-no-img"><i class="bi bi-newspaper"></i></div>
                            @endif
                            <span class="news-source-pill" style="background: {{ $sc['pill'] }};">
                                {{ $article['source'] }}
                            </span>
                        </div>

                        <div class="news-card-body">
                            <div class="news-meta-row">
                                <span class="time-ago">
                                    <i class="bi bi-clock"></i>
                                    {{ \Carbon\Carbon::parse($article['pubDate'])->diffForHumans() }}
                                </span>
                            </div>
                            <h5 class="news-card-title">{{ $article['title'] }}</h5>
                            <p class="news-card-desc">
                                {{ \Illuminate\Support\Str::limit($article['description'], 110) }}
                            </p>
                            <div class="news-card-footer">
                                <span class="news-category-tag"
                                    style="background:{{ $sc['light'] }}; color:{{ $sc['text'] }}; border-color:{{ $sc['bd'] }};">
                                    {{ $article['source'] }}
                                </span>
                                <span class="news-read-more">Đọc ngay <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($articles->hasPages())
                <div class="news-pagination">{{ $articles->links() }}</div>
            @endif

        @endif
    </div>

    @push('scripts')
        <script>
            function setNewsView(mode, btn) {
                document.querySelectorAll('.news-toggle-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById('news-grid').classList.toggle('news-grid--list', mode === 'list');
            }
        </script>
    @endpush
@endsection