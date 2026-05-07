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

        .pd-page {
            font-family: 'Be Vietnam Pro', sans-serif;
            color: var(--text-main);
            max-width: 900px;
            margin: 0 auto;
            padding: 32px 16px 64px;
        }

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

        .pd-avatar {
            width: 100%;
            max-height: 220px;
            object-fit: cover;
            border-radius: 14px;
            border: 1px solid var(--border);
            display: block;
        }

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

        .pd-description {
            font-size: .94rem;
            line-height: 1.75;
            color: #374151;
        }

        .pd-description p {
            margin-bottom: .6rem;
        }

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

        .pd-main-image {
            width: 100%;
            height: 340px;
            object-fit: cover;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            display: block;
            margin-bottom: 14px;
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
            transition: .15s;
        }

        .pd-btn:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
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

        .pd-map-wrapper {
            padding: 0 !important;
            border: 1px solid var(--border);
            border-radius: 8px;
            overflow: hidden;
            margin-top: 4px;
        }
    </style>

    <div class="pd-page">

        <a href="{{ route('admin.post') }}" class="pd-btn pd-btn-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>

        <h3 class="pd-title">
            <i class="bi bi-file-earmark-text"></i>
            Chi tiết bài đăng
        </h3>

        {{-- THÔNG TIN CHUNG --}}
        <div class="pd-card">
            <div class="pd-card-header">
                <span class="icon"><i class="bi bi-info-circle"></i></span>
                Thông tin chung
            </div>

            <div class="pd-card-body">
                <div class="pd-hero">
                    <div>
                        <img src="{{ asset('storage/' . ($post->user->avatar ?? 'default/avt_default.png')) }}"
                            class="pd-avatar" alt="avatar">
                    </div>

                    <div class="pd-info-grid">
                        <div class="pd-field" style="grid-column: 1 / -1">
                            <span class="pd-field-label">Tiêu đề</span>
                            <span class="pd-field-value" style="font-size:1.05rem">
                                {{ $post->title }}
                            </span>
                        </div>

                        <div class="pd-field">
                            <span class="pd-field-label">Danh mục</span>
                            <span class="pd-field-value">{{ $post->category->name ?? '---' }}</span>
                        </div>

                        <div class="pd-field">
                            <span class="pd-field-label">Người đăng</span>
                            <span class="pd-field-value">{{ $post->user->name ?? '---' }}</span>
                        </div>

                        <div class="pd-field">
                            <span class="pd-field-label">Giá</span>
                            <span class="price-chip">
                                {{ number_format($post->price) }} đ /
                                {{ $post->price_unit == 'month' ? 'tháng' : 'ngày' }}
                            </span>
                        </div>

                        <div class="pd-field">
                            <span class="pd-field-label">Diện tích</span>
                            <span class="pd-field-value">{{ $post->area }} m²</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ĐỊA CHỈ --}}
        <div class="pd-card">
            <div class="pd-card-header">
                <span class="icon"><i class="bi bi-geo-alt"></i></span>
                Địa chỉ
            </div>

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
                                <a href="https://www.google.com/maps?q={{ $post->latitude }},{{ $post->longitude }}"
                                    target="_blank" class="pd-map-link">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    {{ $post->address }}
                                </a>
                            @else
                                {{ $post->address }}
                            @endif
                        </span>
                    </div>

                    @if($post->latitude && $post->longitude)
                        <div class="pd-field pd-map-wrapper" style="grid-column: 1 / -1">
                           
                            <div id="pd-map" style="height:320px;"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- TIỆN ÍCH --}}
        <div class="pd-card">
            <div class="pd-card-header">
                <span class="icon"><i class="bi bi-stars"></i></span>
                Tiện ích
            </div>

            <div class="pd-card-body">
                @forelse($post->amenities as $a)
                    <span class="amenity-badge">{{ $a->name }}</span>
                @empty
                    <p class="text-muted mb-0">Không có tiện ích</p>
                @endforelse
            </div>
        </div>

        {{-- MÔ TẢ --}}
        <div class="pd-card">
            <div class="pd-card-header">
                <span class="icon"><i class="bi bi-card-text"></i></span>
                Mô tả
            </div>

            <div class="pd-card-body">
                <div class="pd-description">
                    {!! $post->description !!}
                </div>
            </div>
        </div>

        {{-- HÌNH ẢNH --}}
        <div class="pd-card">
            <div class="pd-card-header">
                <span class="icon"><i class="bi bi-images"></i></span>
                Hình ảnh
            </div>

            <div class="pd-card-body">
                @if($post->images->count())
                    @php
                        $thumbnail = $post->images->firstWhere('is_thumbnail', true) ?? $post->images->first();
                    @endphp

                    <img id="mainImage" src="{{ asset('storage/' . $thumbnail->image) }}" class="pd-main-image" alt="Ảnh chính">

                    <div class="pd-thumb-strip">
                        @foreach($post->images as $img)
                            <img src="{{ asset('storage/' . $img->image) }}" class="pd-thumb"
                                onclick="document.getElementById('mainImage').src='{{ asset('storage/' . $img->image) }}'">
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">Không có hình ảnh</p>
                @endif
            </div>
        </div>

        {{-- TRẠNG THÁI --}}
        <div class="pd-card">
            <div class="pd-card-header">
                <span class="icon"><i class="bi bi-check2-circle"></i></span>
                Trạng thái
            </div>

            <div class="pd-card-body">
                <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;margin-bottom:20px">
                    @if($post->status == 'pending')
                        <span class="status-badge pending">
                            <span class="status-dot"></span> Chờ duyệt
                        </span>
                    @elseif($post->status == 'approved')
                        <span class="status-badge approved">
                            <span class="status-dot"></span> Đã duyệt
                        </span>
                    @else
                        <span class="status-badge rejected">
                            <span class="status-dot"></span> Từ chối
                        </span>
                    @endif
                </div>

                @php
                    $latestRejected = $post->postModerations
                        ->where('action', 'rejected')
                        ->sortByDesc('created_at')
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
                        <strong>Lý do từ chối:</strong>
                        {{ $reasons[$latestRejected->reason_type] ?? 'Không xác định' }}

                        @if($latestRejected->reason_detail)
                            <div class="mt-2">
                                <strong>Chi tiết:</strong>
                                {{ $latestRejected->reason_detail }}
                            </div>
                        @endif
                    </div>
                @endif

                <div class="pd-stats">
                    <div class="pd-stat-item">
                        <span class="pd-stat-number">{{ number_format($post->view_count ?? 0) }}</span>
                        <span class="pd-stat-label">Lượt xem</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ACTION --}}
        @if($post->status == 'pending')
            <div class="pd-actions">
                <form action="{{ route('admin.post.admin.approved', ['id' => $post->id, 'slug' => $post->slug]) }}"
                    method="POST">
                    @csrf
                    @method('PUT')

                    <button type="submit" class="pd-btn pd-btn-success">
                        <i class="bi bi-check2-square"></i>
                        Duyệt bài
                    </button>
                </form>

                <button type="button" class="pd-btn pd-btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="bi bi-x-square"></i>
                    Từ chối
                </button>
            </div>
        @elseif($post->status == 'approved')
            <div class="alert alert-success">
                Bài viết này đã được duyệt.
            </div>
        @else
            <div class="alert alert-danger">
                Bài viết này đã bị từ chối.
            </div>
        @endif
    </div>

    @include('admin.post.rejectmodal')
@endsection

@push('scripts')
    @if($post->latitude && $post->longitude)
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const lat = {{ $post->latitude }};
                const lng = {{ $post->longitude }};
                const address = @json($post->address ?? '');

                const map = L.map('pd-map', {
                    center: [lat, lng],
                    zoom: 17,
                    scrollWheelZoom: false
                });

                const layers = {
                    street: L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                        attribution: 'Google',
                        maxZoom: 20
                    }),
                    satellite: L.tileLayer('https://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                        attribution: 'Google',
                        maxZoom: 20
                    }),
                    hybrid: L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                        attribution: 'Google',
                        maxZoom: 20
                    }),
                };

                let current = layers.street.addTo(map);

                L.marker([lat, lng]).addTo(map)
                    .bindPopup(address ? `<div style="font-size:13px;max-width:200px">${address}</div>` : '')
                    .openPopup();

                document.querySelectorAll('.map-tb-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const key = this.dataset.layer;
                        if (!layers[key] || layers[key] === current) return;

                        map.removeLayer(current);
                        current = layers[key].addTo(map);

                        document.querySelectorAll('.map-tb-btn').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                    });
                });
            });
        </script>
    @endif
@endpush
