@extends('layouts.frontend.app')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')
<style>
    .btn-report-trigger {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border: 1.5px solid #ef4444;
        background: transparent;
        color: #dc2626;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all .18s ease;
        text-decoration: none;
    }

    .btn-report-trigger:hover {
        background: #ef4444;
        color: #fff;
    }

    /* ===== REPORT MODAL ===== */
    .report-modal-content {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .15);
    }

    .report-modal-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 22px 24px 16px;
        border-bottom: 1px solid #f1f5f9;
        position: relative;
    }

    .report-modal-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #fee2e2;
        color: #dc2626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .report-modal-title {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
    }

    .report-modal-sub {
        margin: 2px 0 0;
        font-size: 0.78rem;
        color: #94a3b8;
    }

    .report-modal-close {
        margin-left: auto;
        background: #f1f5f9;
        border: none;
        border-radius: 8px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        cursor: pointer;
        flex-shrink: 0;
        transition: background .15s;
    }

    .report-modal-close:hover {
        background: #e2e8f0;
    }

    .report-modal-body {
        padding: 20px 24px 8px;
    }

    .report-label {
        display: block;
        font-size: 0.83rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 10px;
    }

    /* Radio chips dạng lưới */
    .reason-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }

    @media (max-width: 400px) {
        .reason-grid {
            grid-template-columns: 1fr;
        }
    }

    .reason-chip input[type="radio"] {
        display: none;
    }

    .reason-chip-inner {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 9px 12px;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 500;
        color: #475569;
        cursor: pointer;
        transition: all .15s ease;
        user-select: none;
        background: #f8fafc;
    }

    .reason-chip-inner i {
        font-size: 0.95rem;
        color: #94a3b8;
    }

    .reason-chip-inner:hover {
        border-color: #fca5a5;
        background: #fff5f5;
        color: #dc2626;
    }

    .reason-chip input[type="radio"]:checked + .reason-chip-inner {
        border-color: #ef4444;
        background: #fee2e2;
        color: #dc2626;
        font-weight: 600;
    }

    .reason-chip input[type="radio"]:checked + .reason-chip-inner i {
        color: #dc2626;
    }

    .report-textarea {
        width: 100%;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 13px;
        font-size: 0.85rem;
        color: #334155;
        resize: none;
        outline: none;
        transition: border .15s;
        font-family: inherit;
        background: #f8fafc;
    }

    .report-textarea:focus {
        border-color: #ef4444;
        background: #fff;
    }

    .report-error {
        color: #dc2626;
        font-size: 0.78rem;
        margin-top: 5px;
    }

    .report-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 16px 24px 22px;
        border-top: 1px solid #f1f5f9;
        margin-top: 12px;
    }

    .report-btn-cancel {
        padding: 9px 20px;
        border: 1.5px solid #e2e8f0;
        background: #fff;
        color: #64748b;
        border-radius: 9px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all .15s;
    }

    .report-btn-cancel:hover {
        background: #f1f5f9;
    }

    .report-btn-submit {
        padding: 9px 22px;
        background: #ef4444;
        border: none;
        color: #fff;
        border-radius: 9px;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 7px;
        transition: background .15s;
    }

    .report-btn-submit:hover {
        background: #dc2626;
    }

    /* Responsive modal trên mobile */
    @media (max-width: 576px) {
        .report-modal-header {
            padding: 18px 16px 14px;
        }

        .report-modal-body {
            padding: 16px 16px 6px;
        }

        .report-modal-footer {
            padding: 14px 16px 18px;
        }
    }
</style>

<div class="pd-wrap">
    <div class="pd-breadcrumb">
        <a href="{{ route('frontend.home') }}"><i class="bi bi-house-fill"></i> Trang chủ</a>
        <span class="sep"><i class="bi bi-chevron-right" style="font-size:.65rem"></i></span>
        <a href="{{ route('frontend.category.show', $post->category->slug ?? '#') }}">
            {{ $post->category->name ?? 'Danh mục' }}
        </a>
        <span class="sep"><i class="bi bi-chevron-right" style="font-size:.65rem"></i></span>
        <span style="color:#1e293b;font-weight:600;max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
            {{ $post->title }}
        </span>
    </div>

    <div class="pd-grid">
        <div>
            @if($post->images->count())
                @php
                    $thumbnail = $post->images->firstWhere('is_thumbnail', true) ?? $post->images->first();
                    $allImages = $post->images;
                @endphp

                <div class="gallery-main-wrap mb-2" id="galleryWrap">
                    <img id="mainImg" src="{{ asset('storage/' . $thumbnail->image) }}" alt="{{ $post->title }}">
                    <button class="gallery-arrow prev" onclick="galleryNav(-1)">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="gallery-arrow next" onclick="galleryNav(1)">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                    <div class="gallery-counter">
                        <i class="bi bi-images"></i>
                        <span id="galleryCounter">1 / {{ $allImages->count() }}</span>
                    </div>
                </div>

                <div class="gallery-thumbs mb-4" id="thumbStrip">
                    @foreach($allImages as $idx => $img)
                        <img src="{{ asset('storage/' . $img->image) }}"
                             class="gallery-thumb {{ $idx === 0 ? 'active' : '' }}"
                             data-idx="{{ $idx }}"
                             onclick="gallerySet({{ $idx }})"
                             alt="">
                    @endforeach
                </div>
            @else
                <div style="height:220px;background:#f1f5f9;border-radius:14px;display:flex;align-items:center;justify-content:center;color:#94a3b8;margin-bottom:20px">
                    <i class="bi bi-image" style="font-size:2.5rem"></i>
                </div>
            @endif

            <div class="pd-card">
                <div class="pd-card-body">
                    <div class="post-vip-row">
                        @if($post->membership)
                            @php
                                $vipClass = match ($post->membership->slug ?? '') {
                                    'vip-5' => 'vip-5',
                                    'vip-4' => 'vip-4',
                                    'vip-3' => 'vip-3',
                                    'vip-2' => 'vip-2',
                                    'vip-1' => 'vip-1',
                                    default => 'vip-free',
                                };
                                $vipLabel = strtoupper(str_replace('-', ' ', $post->membership->name ?? 'Free'));
                            @endphp
                            <span class="vip-badge fs-6 {{ $vipClass }}"style="color:{{ $post->membership->color }}; back-">
                                <i class="bi bi-star-fill"></i> {{ $vipLabel }}
                            </span>
                        @endif

                        <span class="vip-badge vip-free" >
                            <i class="bi bi-tag-fill"></i> {{ $post->category->name ?? '' }}
                        </span>

                        <span style="margin-left:auto;font-size:0.76rem;color:#94a3b8;display:flex;align-items:center;gap:4px">
                            <i class="bi bi-clock"></i> {{ $post->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <h1 class="post-title" style="color:{{ $post->membership->color }}">{{ $post->title }}</h1>

                    <div class="post-price-row">
                        <div>
                            <span class="post-price">{{ number_format($post->price, 0, ',', '.') }} đ</span>
                            <span class="post-price-unit">/{{ $post->price_unit == 'month' ? 'tháng' : 'ngày' }}</span>
                        </div>
                    </div>

                    <div class="post-meta-chips">
                        <span class="meta-chip"><i class="bi bi-rulers"></i> {{ $post->area }} m2</span>
                        <span class="meta-chip"><i class="bi bi-geo-alt-fill"></i> {{ $post->ward->name ?? '---' }}</span>
                        <span class="meta-chip"><i class="bi bi-eye"></i> {{ number_format($post->view_count, 0, ',', '.') }} lượt xem</span>
                    </div>

                    <div class="address-line">
                        <i class="bi bi-geo-alt-fill"></i>
                        @if($post->latitude && $post->longitude)
                            <a href="https://www.google.com/maps?q={{ $post->latitude }},{{ $post->longitude }}&z=17" target="_blank">
                                {{ $post->address }}
                                <i class="bi bi-box-arrow-up-right" style="font-size:.7rem;margin-left:3px"></i>
                            </a>
                        @else
                            {{ $post->address }}
                        @endif
                    </div>
                </div>
            </div>

            <div class="pd-card">
                <div class="pd-card-head"><i class="bi bi-file-text"></i> Mô tả chi tiết</div>
                <div class="pd-card-body">
                    <div class="post-desc">{!! $post->description !!}</div>
                </div>
            </div>

            @if($post->amenities->count())
                <div class="pd-card">
                    <div class="pd-card-head"><i class="bi bi-stars"></i> Tiện ích</div>
                    <div class="pd-card-body">
                        <div class="amenity-list">
                            @foreach($post->amenities as $a)
                                <span class="amenity-chip"><i class="bi bi-check-circle-fill"></i> {{ $a->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if($post->latitude && $post->longitude)
                <div class="pd-card" style="overflow:hidden">
                    <div class="pd-card-head"><i class="bi bi-map"></i> Vị trí</div>
                    <div class="map-toolbar"></div>
                    <div id="pd-map"></div>
                </div>
            @endif

            <div class="pd-card">
                <div class="pd-card-head"><i class="bi bi-info-circle"></i> Thông tin bài đăng</div>
                <div class="pd-card-body">
                    <table class="info-table">
                        <tr>
                            <td>Mã tin</td>
                            <td>
                                <code style="background:#f1f5f9;padding:2px 7px;border-radius:5px;font-size:.82rem">
                                    #{{ $post->id }}
                                </code>
                            </td>
                        </tr>

                        <tr>
                            <td>Gói tin</td>
                            <td>
                                @if($post->membership)
                                    <span class="vip-badge {{ $vipClass ?? 'vip-free' }}"
                                          style="font-size:.72rem; background-color: {{ $post->membership->color }};">
                                        {{ $post->membership->name ?? $vipLabel ?? '---' }}
                                    </span>
                                @else
                                    <span class="vip-badge vip-free">Miễn phí</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td>Ngày đăng</td>
                            <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                        </tr>

                        <tr>
                            <td>Hết hạn</td>
                            <td class="text-center align-middle">
                                @if($post->expires_at)
                                    @php
                                        $expiresAt = $post->expires_at;
                                    @endphp

                                    @if($expiresAt->isPast())
                                        <span class="expires-chip expired">
                                            <i class="bi bi-calendar-x"></i>
                                            {{ $expiresAt->format('d/m/Y H:i') }}
                                            (đã hết hạn)
                                        </span>
                                    @else
                                        <span class="expires-chip {{ $expiresAt->diffInDays(now()) <= 3 ? 'soon' : '' }}">
                                            <i class="bi bi-calendar-check"></i>
                                            {{ $expiresAt->format('d/m/Y H:i') }}
                                            ({{ $expiresAt->diffForHumans(now(), [
                                                'parts' => 2,
                                                'short' => true,
                                                'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW
                                            ]) }})
                                        </span>
                                    @endif
                                @else
                                    <span class="text-muted">---</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <td>Lượt xem</td>
                            <td>{{ number_format($post->view_count, 0, ',', '.') }} lượt</td>
                        </tr>
                    </table>

                    <a href="#" class="report-link">
                        <i class="bi bi-flag"></i> Báo cáo tin này (tại đây)
                    </a>
                </div>
            </div>
        </div>

        <div class="sidebar-sticky">
            <div class="contact-card">
                <div class="contact-card-top">
                    <div class="contact-avatar-wrap">
                        <img src="{{ asset('storage/' . ($post->user->avatar ?? 'default/avt_default.png')) }}"
                             class="contact-avatar" alt="">
                        <div>
                            <div class="contact-name">{{ $post->user->name ?? 'Chủ nhà' }}</div>
                            <div class="contact-role">
                                <i class="bi bi-patch-check-fill" style="font-size:.75rem;margin-right:2px"></i>
                                Chính chủ đã xác minh
                            </div>
                        </div>
                    </div>

                    <div class="contact-user-meta">
                        <span class="contact-meta-item">
                            <i class="bi bi-file-earmark-text"></i>
                            {{ $post->user->posts()->where('status', 'approved')->count() }} bài đăng
                        </span>
                        <span class="contact-meta-item">
                            <i class="bi bi-calendar3"></i>
                            Tham gia {{ $post->user->created_at->format('d/m/Y') }}
                        </span>
                    </div>
                </div>

                <div class="contact-card-body">
                    <button class="btn-phone" id="btnRevealPhone" data-phone="{{ $post->user->phone ?? '0000000000' }}">
                        <i class="bi bi-telephone-fill"></i>
                        <span id="phoneText">
                            {{ substr($post->user->phone ?? '0000000000', 0, 3) }}*****{{ substr($post->user->phone ?? '0000000000', -2) }}
                        </span>
                        <span style="font-size:.75rem;font-weight:400;opacity:.85"> - Bấm để hiển thị số</span>
                    </button>

                    <a href="https://zalo.me/{{ $post->user->phone ?? '' }}" target="_blank" class="btn-zalo">
                        <i class="bi bi-chat-dots-fill"></i> Nhắn Zalo
                    </a>

                    @php
                        $isSaved = auth()->check()
                            && auth()->user()->savedPosts()
                                ->where('post_id', $post->id)
                                ->exists();
                    @endphp

                    <form action="{{ route('saved-post.store', ['id' => $post->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-save-post {{ $isSaved ? 'saved' : '' }}" id="btnSave">
                            @if($isSaved)
                                <i class="bi bi-bookmark-check-fill"></i> Đã lưu
                            @else
                                <i class="bi bi-bookmark-plus"></i> Lưu tin
                            @endif
                        </button>
                    </form>
                </div>
            </div>

            <div class="security-note">
                <i class="bi bi-shield-exclamation"></i>

                <div class="security-note-content">
                    <div>
                        Lưu ý: Chỉ đặt cọc khi xác định được đúng chủ nhà và có thỏa thuận biên nhận rõ ràng.
                        Kiểm tra kỹ mọi điều khoản và yêu cầu liệt kê đầy đủ tất cả chi phí hàng tháng vào hợp đồng.
                        Mọi thông tin liên quan đến tin đăng này chỉ mang tính chất tham khảo.
                        Nếu bạn thấy rằng tin đăng này không đúng hoặc có dấu hiệu lừa đảo, hãy phản ánh với chúng tôi.
                    </div>

                    {{-- Nút tố cáo: hiển thị cho tất cả, chủ bài không thấy --}}
                    @if(!auth()->check() || auth()->id() !== $post->user_id)
                        <div class="mt-2">
                            @auth
                                <button
                                    type="button"
                                    class="btn-report-trigger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#reportPostModal">
                                    <i class="bi bi-flag"></i> Tố cáo bài viết
                                </button>
                            @else
                                <a href="{{ route('login') }}?redirect={{ urlencode(request()->fullUrl()) }}"
                                   class="btn-report-trigger">
                                    <i class="bi bi-flag"></i> Tố cáo bài viết
                                </a>
                            @endauth
                        </div>
                    @endif
                </div>
            </div>

            @if(isset($relatedPosts) && $relatedPosts->count())
                <div class="pd-card">
                    <div class="pd-card-head"><i class="bi bi-grid"></i> Tin cùng khu vực</div>
                    <div class="pd-card-body" style="padding-top:8px;padding-bottom:8px">
                        <div class="related-title">Gợi ý cho bạn</div>

                        @foreach($relatedPosts as $rp)
                            <a href="{{ route('frontend.post.show', ['id' => $rp->id, 'slug' => $rp->slug]) }}"
                               class="related-card">
                                <img src="{{ asset('storage/' . ($rp->images->first()->image ?? 'default.jpg')) }}"
                                     class="related-img"
                                     alt="{{ $rp->title }}">
                                <div class="related-info">
                                    <div class="related-post-title">{{ $rp->title }}</div>
                                    <div class="related-price">{{ number_format($rp->price, 0, ',', '.') }} đ/tháng</div>
                                    <div class="related-meta">
                                        <i class="bi bi-geo-alt"></i> {{ $rp->ward->name ?? '' }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- modal tố cáo -->
<div class="modal fade" id="reportPostModal" tabindex="-1" aria-labelledby="reportPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content report-modal-content">
            <form action="{{ route('post.report', $post->id) }}" method="POST">
                @csrf

                <div class="report-modal-header">
                    <div class="report-modal-icon">
                        <i class="bi bi-flag-fill"></i>
                    </div>

                    <div>
                        <h5 class="report-modal-title" id="reportPostModalLabel">Tố cáo bài viết</h5>
                        <p class="report-modal-sub">Giúp chúng tôi xử lý nội dung vi phạm</p>
                    </div>

                    <button type="button" class="report-modal-close" data-bs-dismiss="modal" aria-label="Đóng">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <div class="report-modal-body">
                    <div class="mb-4">
                        <label class="report-label">Lý do tố cáo <span class="text-danger">*</span></label>

                        <div class="reason-grid">
                            @php
                                $reasons = [
                                    'spam'          => ['icon' => 'bi-trash3', 'label' => 'Tin rác'],
                                    'scam'          => ['icon' => 'bi-exclamation-triangle', 'label' => 'Lừa đảo'],
                                    'false_info'    => ['icon' => 'bi-x-circle', 'label' => 'Thông tin sai'],
                                    'duplicate'     => ['icon' => 'bi-files', 'label' => 'Tin trùng lặp'],
                                    'inappropriate' => ['icon' => 'bi-slash-circle', 'label' => 'Nội dung không phù hợp'],
                                    'wrong_price'   => ['icon' => 'bi-currency-exchange', 'label' => 'Giá không đúng'],
                                    'other'         => ['icon' => 'bi-three-dots', 'label' => 'Khác'],
                                ];
                            @endphp

                            @foreach($reasons as $val => $r)
                                <label class="reason-chip">
                                    <input type="radio" name="reason_type" value="{{ $val }}"
                                           {{ old('reason_type') == $val ? 'checked' : '' }} required>
                                    <span class="reason-chip-inner">
                                        <i class="bi {{ $r['icon'] }}"></i>
                                        {{ $r['label'] }}
                                    </span>
                                </label>
                            @endforeach
                        </div>

                        @error('reason_type')
                            <div class="report-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label class="report-label">
                            Chi tiết thêm <span style="color:#94a3b8;font-weight:400">(tùy chọn)</span>
                        </label>

                        <textarea
                            name="reason_detail"
                            rows="3"
                            class="report-textarea @error('reason_detail') is-invalid @enderror"
                            placeholder="Mô tả thêm nếu cần...">{{ old('reason_detail') }}</textarea>

                        @error('reason_detail')
                            <div class="report-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="report-modal-footer">
                    <button type="button" class="report-btn-cancel" data-bs-dismiss="modal">Huỷ</button>
                    <button type="submit" class="report-btn-submit">
                        <i class="bi bi-send"></i> Gửi tố cáo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const galleryImages = @json($post->images->pluck('image'));
        let currentIdx = 0;

        function gallerySet(idx) {
            currentIdx = idx;
            const base = '{{ asset('storage/') }}/';
            document.getElementById('mainImg').src = base + galleryImages[idx];
            document.getElementById('galleryCounter').textContent = (idx + 1) + ' / ' + galleryImages.length;

            document.querySelectorAll('.gallery-thumb').forEach((t, i) => {
                t.classList.toggle('active', i === idx);
            });

            const thumb = document.querySelector(`.gallery-thumb[data-idx="${idx}"]`);
            if (thumb) {
                thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        }

        function galleryNav(dir) {
            const len = galleryImages.length;
            gallerySet((currentIdx + dir + len) % len);
        }

        const btnPhone = document.getElementById('btnRevealPhone');
        if (btnPhone) {
            btnPhone.addEventListener('click', function () {
                const phone = this.dataset.phone;
                document.getElementById('phoneText').textContent = phone;
                this.querySelector('span:last-child').style.display = 'none';
                this.classList.add('revealed');
                this.querySelector('i').className = 'bi bi-telephone-fill';
            });
        }

        @if($post->latitude && $post->longitude)
            (function () {
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
                    .bindPopup(`<div style="font-size:13px;max-width:200px">${address}</div>`)
                    .openPopup();

                document.querySelectorAll('.map-tb-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const key = this.dataset.layer;
                        if (layers[key] === current) return;

                        map.removeLayer(current);
                        current = layers[key].addTo(map);

                        document.querySelectorAll('.map-tb-btn').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                    });
                });
            })();
        @endif
    </script>
@endpush