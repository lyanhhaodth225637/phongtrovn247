@extends('layouts.admin.app')

@section('content')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&family=Playfair+Display:wght@600&display=swap');

        :root {
            --primary: #1a56db;
            --primary-light: #e8f0fe;
            --success: #0e9f6e;
            --danger: #e02424;
            --warning: #c27803;
            --warning-bg: #fdf6b2;
            --surface: #ffffff;
            --surface-2: #f8fafc;
            --border: #e2e8f0;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, .06), 0 1px 2px rgba(0, 0, 0, .04);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, .08);
            --radius: 14px;
            --radius-sm: 8px;
        }

        /* ── Page wrapper ── */
        .pd-page {
            font-family: 'Be Vietnam Pro', sans-serif;
            color: var(--text-main);
            max-width: 900px;
            margin: 0 auto;
            padding: 32px 16px 64px;
        }

        /* ── Page title ── */
        .pd-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pd-title::after {
            content: '';
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, var(--border), transparent);
            border-radius: 2px;
        }

        /* ── Card ── */
        .pd-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            margin-bottom: 20px;
            overflow: hidden;
            transition: box-shadow .2s;
        }

        .pd-card:hover {
            box-shadow: var(--shadow-md);
        }

        .pd-card-header {
            padding: 14px 22px;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--text-muted);
            background: var(--surface-2);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .pd-card-header .icon {
            font-size: 1rem;
            opacity: .75;
        }

        .pd-card-body {
            padding: 22px;
        }

        /* ── Info grid ── */
        .pd-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 32px;
        }

        @media (max-width: 600px) {
            .pd-info-grid {
                grid-template-columns: 1fr;
            }
        }

        .pd-field {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .pd-field-label {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .pd-field-value {
            font-size: .95rem;
            color: var(--text-main);
            font-weight: 500;
        }

        /* ── Price chip ── */
        .price-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: #fff1f2;
            color: var(--danger);
            font-weight: 700;
            font-size: 1rem;
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid #fecdd3;
        }

        /* ── Avatar / main image ── */
        .pd-avatar {
            width: 100%;
            max-height: 220px;
            object-fit: cover;

            border-radius: 50% border: 1px solid var(--border);
            display: block;
        }

        /* ── General layout for first card ── */
        .pd-hero {
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 24px;
            align-items: start;
        }

        @media (max-width: 640px) {
            .pd-hero {
                grid-template-columns: 1fr;
            }
        }

        /* ── Address link ── */
        .pd-map-link {
            color: var(--primary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-weight: 500;
        }

        .pd-map-link:hover {
            text-decoration: underline;
        }

        /* ── Description ── */
        .pd-description {
            font-size: .94rem;
            line-height: 1.75;
            color: #374151;
        }

        .pd-description p {
            margin-bottom: .6rem;
        }

        /* ── Amenity badges ── */
        .amenity-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--primary-light);
            color: var(--primary);
            font-size: .78rem;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
            border: 1px solid #c7d9fb;
            margin: 3px;
        }

        /* ── Image gallery ── */
        .pd-main-image {
            width: 100%;
            height: 340px;
            object-fit: cover;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            display: block;
            margin-bottom: 14px;
            transition: opacity .2s;
        }

        .pd-thumb-strip {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .pd-thumb {
            width: 90px;
            height: 68px;
            object-fit: cover;
            border-radius: 6px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: border-color .15s, transform .15s;
        }

        .pd-thumb:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        /* ── Status badges ── */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .8rem;
            font-weight: 700;
            padding: 5px 14px;
            border-radius: 20px;
            letter-spacing: .03em;
        }

        .status-badge.pending {
            background: var(--warning-bg);
            color: var(--warning);
            border: 1px solid #f3cc6c;
        }

        .status-badge.approved {
            background: #d1fae5;
            color: var(--success);
            border: 1px solid #6ee7b7;
        }

        .status-badge.rejected {
            background: #fee2e2;
            color: var(--danger);
            border: 1px solid #fca5a5;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: currentColor;
            display: inline-block;
        }

        /* ── Stats row ── */
        .pd-stats {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            margin-top: 6px;
        }

        .pd-stat-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .pd-stat-number {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1;
        }

        .pd-stat-label {
            font-size: .7rem;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--text-muted);
            font-weight: 600;
        }

        /* ── Action bar ── */
        .pd-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }

        .pd-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 22px;
            border-radius: 8px;
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: .88rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: filter .15s, transform .1s, box-shadow .15s;
        }

        .pd-btn:hover {
            filter: brightness(1.06);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, .12);
        }

        .pd-btn:active {
            transform: translateY(0);
        }

        .pd-btn-secondary {
            background: var(--surface-2);
            color: var(--text-muted);
            border: 1px solid var(--border);
        }

        .pd-btn-success {
            background: var(--success);
            color: #fff;
        }

        .pd-btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .pd-divider {
            width: 1px;
            background: var(--border);
            align-self: stretch;
            margin: 0 4px;
        }
    </style>

    <div class="pd-page">

        <a href="{{ route('admin.post') }}" class="pd-btn pd-btn-secondary mb-3">
            ← Quay lại
        </a>
        <h3 class="pd-title">📄 Chi tiết bài đăng</h3>

        {{-- ===== THÔNG TIN CHUNG ===== --}}
        <div class="pd-card">
            <div class="pd-card-header"><span class="icon">ℹ️</span> Thông tin chung</div>
            <div class="pd-card-body">
                <div class="pd-hero">

                    {{-- AVATAR --}}
                    <div class="">
                        <img src="{{ asset('storage/' . ($post->user->avatar ?? 'default/avt_default.png')) }}"
                            class="pd-avatar" alt="avatar">
                    </div>

                    {{-- INFO --}}
                    <div class="pd-info-grid">
                        <div class="pd-field" style="grid-column: 1 / -1">
                            <span class="pd-field-label">Tiêu đề:</span>
                            <span class="pd-field-value" style="font-size:1.05rem">{{ $post->title }}</span>
                        </div>

                        <div class="pd-field">
                            <span class="pd-field-label">Danh mục:</span>
                            <span class="pd-field-value">{{ $post->category->name ?? '---' }}</span>
                        </div>

                        <div class="pd-field">
                            <span class="pd-field-label">Người đăng:</span>
                            <span class="pd-field-value">{{ $post->user->name ?? '---' }}</span>
                        </div>

                        <div class="pd-field">
                            <span class="pd-field-label">Giá:</span>
                            <span class="price-chip">
                                {{ number_format($post->price) }} đ /
                                {{ $post->price_unit == 'month' ? 'tháng' : 'ngày' }}
                            </span>
                        </div>

                        <div class="pd-field">
                            <span class="pd-field-label">Diện tích:</span>
                            <span class="pd-field-value">{{ $post->area }} m²</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ===== ĐỊA CHỈ ===== --}}
        <div class="pd-card">
            <div class="pd-card-header"><span class="icon">📍</span> Địa chỉ</div>
            <div class="pd-card-body">
                <div class="pd-info-grid">

                    <div class="pd-field">
                        <span class="pd-field-label">Tỉnh / Thành phố</span>
                        <span class="pd-field-value">{{ $post->ward->province->name ?? '---' }}</span>
                    </div>

                    <div class="pd-field">
                        <span class="pd-field-label">Phường / Xã</span>
                        <span class="pd-field-value">{{ $post->ward->name ?? '---' }}</span>
                    </div>

                    <div class="pd-field" style="grid-column: 1 / -1">
                        <span class="pd-field-label">Địa chỉ cụ thể</span>
                        <span class="pd-field-value">
                            @if($post->latitude && $post->longitude)
                                <a href="https://www.google.com/maps?q={{ $post->latitude }},{{ $post->longitude }}&z=17"
                                    target="_blank" class="pd-map-link">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $post->address }}
                                </a>
                            @else
                                {{ $post->address }}
                            @endif
                        </span>
                    </div>

                    {{-- ===== KHUNG BẢN ĐỒ ===== --}}
                    @if($post->latitude && $post->longitude)
                        <div class="pd-field pd-map-wrapper" style="grid-column: 1 / -1">
                            <div id="pd-map" style="height: 320px; width: 100%; border-radius: 0 0 8px 8px;"></div>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ===== TIỆN ÍCH ===== --}}
        <div class="pd-card">
            <div class="pd-card-header"><span class="icon">⭐</span> Tiện ích</div>
            <div class="pd-card-body">
                @forelse($post->amenities as $a)
                    <span class="amenity-badge">{{ $a->name }}</span>
                @empty
                    <p style="color:var(--text-muted); font-size:.9rem; margin:0">Không có tiện ích</p>
                @endforelse
            </div>
        </div>

        {{-- ===== MÔ TẢ ===== --}}
        <div class="pd-card">
            <div class="pd-card-header"><span class="icon">📝</span> Mô tả</div>
            <div class="pd-card-body">
                <div class="pd-description">
                    {!! $post->description !!}
                </div>
            </div>
        </div>



        {{-- ===== HÌNH ẢNH ===== --}}
        <div class="pd-card">
            <div class="pd-card-header"><span class="icon">🖼</span> Hình ảnh</div>
            <div class="pd-card-body">

                @if($post->images->count())

                    @php
                        $thumbnail = $post->images->firstWhere('is_thumbnail', true)
                            ?? $post->images->first();
                    @endphp

                    {{-- ẢNH LỚN --}}
                    <img id="mainImage" src="{{ asset('storage/' . $thumbnail->image) }}" class="pd-main-image"
                        alt="main image">

                    {{-- THUMB STRIP --}}
                    <div class="pd-thumb-strip">
                        @foreach($post->images as $img)
                            <img src="{{ asset('storage/' . $img->image) }}" class="pd-thumb"
                                onclick="document.getElementById('mainImage').src='{{ asset('storage/' . $img->image) }}'">
                        @endforeach
                    </div>

                @else
                    <p style="color:var(--text-muted); font-size:.9rem; margin:0">Không có hình ảnh</p>
                @endif

            </div>
        </div>

        {{-- ===== TRẠNG THÁI ===== --}}
        <div class="pd-card">
            <div class="pd-card-header"><span class="icon">⚙️</span> Trạng thái</div>
            <div class="pd-card-body">

                <div style="display:flex; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:20px">
                    @if($post->status == 'pending')
                        <span class="status-badge pending"><span class="status-dot"></span> Chờ duyệt</span>
                    @elseif($post->status == 'approved')
                        <span class="status-badge approved"><span class="status-dot"></span> Đã duyệt</span>
                    @else
                        <span class="status-badge rejected"><span class="status-dot"></span> Từ chối</span>
                    @endif
                </div>

                @php
                    $latestRejected = $post->postModerations
                        ->where('action', 'rejected')
                        ->first();

                    $reasons = [
                        'spam' => 'Spam',
                        'scam' => 'Lừa đảo',
                        'false_info' => 'Sai sự thật',
                        'duplicate' => 'Trùng bài',
                        'other' => 'Khác'
                    ];
                @endphp
                @if($post->status == 'rejected' && $latestRejected)
                    <div class="alert alert-danger">
                        <strong>Lý do từ chối: </strong>{{ $reasons[$latestRejected->reason_type] ?? 'Không xác định' }}
                        @if($latestRejected->reason_detail)
                            <div>
                                <b>Chi tiết:</b>
                                {{ $latestRejected->reason_detail }}
                            </div>
                        @endif
                    </div>
                @endif

                <div class="pd-stats">
                    <div class="pd-stat-item">
                        <span class="pd-stat-number">{{ number_format($post->view_count) }}</span>
                        <span class="pd-stat-label">Lượt xem</span>
                    </div>
                    <div class="pd-stat-item">
                        <span class="pd-stat-number">
                            {{ $post->expires_at ? \Carbon\Carbon::parse($post->expires_at)->format('d/m/Y') : '---' }}
                        </span>
                        <span class="pd-stat-label">Hết hạn</span>
                    </div>
                </div>

            </div>
        </div>
        {{-- ===== ACTION ===== --}}
        <div class="pd-actions">
            <div class="pd-divider"></div>
            <form action="{{ route('admin.post.approved', ['id' => $post->id, 'slug' => $post->slug]) }}" method="POST">
                @csrf
                @method('PUT')

                <button class="pd-btn pd-btn-success">✔ Duyệt</button>
            </form>
            <button type="button" class="pd-btn pd-btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                ✖ Từ chối
            </button>
        </div>
    </div>
    @include('admin.post.rejectmodal')
@endsection
@push('scripts')
    {{-- ===== CSS BẢN ĐỒ ===== --}}
    @if($post->latitude && $post->longitude)
        @once
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <style>
                .pd-map-wrapper {
                    padding: 0 !important;
                    border: 1px solid #e2e8f0;
                    border-radius: 8px;
                    overflow: hidden;
                    margin-top: 4px;
                }

                .pd-map-toolbar {
                    display: flex;
                    gap: 0;
                    background: #f8fafc;
                    border-bottom: 1px solid #e2e8f0;
                }

                .pd-map-layer-btn {
                    flex: 1;
                    padding: 8px 12px;
                    font-size: 13px;
                    font-weight: 500;
                    color: #64748b;
                    background: transparent;
                    border: none;
                    border-right: 1px solid #e2e8f0;
                    cursor: pointer;
                    transition: background 0.15s, color 0.15s;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 5px;
                }

                .pd-map-layer-btn:last-child {
                    border-right: none;
                }

                .pd-map-layer-btn:hover {
                    background: #e2e8f0;
                    color: #334155;
                }

                .pd-map-layer-btn.active {
                    background: #3b82f6;
                    color: #fff;
                }

                #pd-map .leaflet-control-zoom a {
                    font-size: 14px;
                }
            </style>
        @endonce

        {{-- ===== SCRIPT BẢN ĐỒ ===== --}}
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            (function () {
                const lat = {{ $post->latitude }};
                const lng = {{ $post->longitude }};
                const address = @json($post->address ?? '');

                const map = L.map('pd-map', {
                    center: [lat, lng],
                    zoom: 17,
                    zoomControl: true,
                    scrollWheelZoom: false,
                });

                // --- Các lớp tile ---
                const googleStreet = L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', { attribution: '© Google Maps', maxZoom: 20 });
                const googleSatellite = L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', { attribution: '© Google Maps', maxZoom: 20 });
                const googleHybrid = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', { attribution: '© Google Maps', maxZoom: 20 });

                const layers = { street: googleStreet, satellite: googleSatellite, hybrid: googleHybrid };
                let currentLayer = googleStreet.addTo(map);

                // --- Marker ---
                const marker = L.marker([lat, lng]).addTo(map);
                if (address) {
                    marker.bindPopup(`<div style="font-size:13px;max-width:220px">${address}</div>`).openPopup();
                }

                // --- Chuyển lớp tile ---
                document.querySelectorAll('.pd-map-layer-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const layerKey = this.dataset.layer;
                        if (layers[layerKey] === currentLayer) return;

                        map.removeLayer(currentLayer);
                        currentLayer = layers[layerKey].addTo(map);

                        document.querySelectorAll('.pd-map-layer-btn').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                    });
                });
            })();
        </script>
    @endif
@endpush