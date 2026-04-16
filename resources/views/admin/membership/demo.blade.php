@extends('layouts.frontend.app')
@section('content')

    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Barlow+Condensed:wght@600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --cz-primary: #fd5c01;
            --cz-dark: #1a1f2e;
            --cz-border: #e8ecf0;
            --cz-muted: #8a93a6;
            --cz-text: #2d3142;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: #f0f4ff;
            color: var(--cz-text);
        }

        .pg-header {
            background: linear-gradient(135deg, #fff7f3 0%, #ffffff 50%, #f0f4ff 100%);
            border-bottom: 1.5px solid #fde8d8;
            padding: 48px 0 36px;
            position: relative;
            overflow: hidden;
        }

        .pg-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(-45deg, transparent, transparent 22px,
                    rgba(253, 92, 1, 0.03) 22px, rgba(253, 92, 1, 0.03) 24px);
        }

        .pg-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            right: 0;
            height: 32px;
            background: #f0f4ff;
            clip-path: ellipse(55% 100% at 50% 100%);
        }

        .pg-header-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(253, 92, 1, 0.10);
            border: 1px solid rgba(253, 92, 1, 0.25);
            color: var(--cz-primary);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 99px;
            margin-bottom: 14px;
        }

        .pg-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 800;
            color: var(--cz-dark);
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .pg-title span {
            color: var(--cz-primary);
        }

        .pg-subtitle {
            color: var(--cz-muted);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .vat-toggle-wrap {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            border: 1.5px solid var(--cz-border);
            padding: 8px 18px;
            border-radius: 99px;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--cz-text);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
            cursor: pointer;
            margin-bottom: 28px;
        }

        .form-check-input:checked {
            background-color: var(--cz-primary);
            border-color: var(--cz-primary);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(253, 92, 1, 0.2);
        }

        .pricing-table-wrap {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(100, 120, 200, 0.10);
            overflow: hidden;
            border: 1.5px solid var(--cz-border);
        }

        .pricing-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .pricing-table thead tr th {
            padding: 0;
            border: none;
            vertical-align: top;
        }

        .th-label {
            background: #f8faff;
            border-right: 1.5px solid var(--cz-border);
            height: 88px;
        }

        .th-label-inner {
            padding: 16px 20px;
            display: flex;
            align-items: flex-end;
            height: 100%;
        }

        .th-label-inner span {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
        }

        .plan-header {
            height: 88px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 12px 8px;
        }

        .plan-header .plan-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 15px;
            font-weight: 800;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1;
            text-align: center;
        }

        .plan-header .plan-stars {
            font-size: 11px;
            letter-spacing: 1px;
            color: #fbbf24;
        }

        .pricing-table tbody tr {
            border-bottom: 1px solid var(--cz-border);
            transition: background 0.15s;
        }

        .pricing-table tbody tr:hover {
            background: #f5f7ff;
        }

        .pricing-table tbody tr:last-child {
            border-bottom: none;
        }

        .pricing-table td {
            padding: 13px 16px;
            font-size: 13.5px;
            vertical-align: middle;
            border-right: 1px solid var(--cz-border);
            text-align: center;
        }

        .pricing-table td:last-child {
            border-right: none;
        }

        .pricing-table td.row-label {
            text-align: left;
            font-weight: 700;
            color: var(--cz-text);
            background: #f8faff;
            font-size: 13px;
            padding-left: 20px;
        }

        .price-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
        }

        .price-main {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--cz-text);
        }

        .price-vat {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--cz-text);
            display: none;
        }

        .price-na {
            color: #d1d5db;
            font-size: 20px;
        }

        .show-vat .price-main {
            display: none;
        }

        .show-vat .price-vat {
            display: block;
        }

        tr.row-highlight {
            background: #fffbf5;
        }

        tr.row-highlight:hover {
            background: #fff5e8 !important;
        }

        .color-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 6px;
        }

        .pkg-desc {
            font-size: 11px;
            color: var(--cz-muted);
            margin-top: 2px;
        }

        .pkg-inactive {
            opacity: 0.35;
        }

        td.action-cell {
            padding: 14px 12px;
            background: #f8faff;
        }

        .btn-cz {
            background: var(--cz-primary);
            color: #fff;
            border: none;
            font-size: 13px;
            font-weight: 800;
            padding: 8px 20px;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cz:hover {
            background: #d94d00;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(253, 92, 1, 0.35);
        }

        .btn-cz-outline {
            background: transparent;
            color: var(--cz-muted);
            border: 1.5px solid var(--cz-border);
            font-size: 13px;
            font-weight: 800;
            padding: 7px 20px;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cz-outline:hover {
            border-color: var(--cz-primary);
            color: var(--cz-primary);
        }

        .footnote {
            font-size: 12px;
            color: var(--cz-muted);
            padding: 20px 24px 0;
        }

        .table-scroll {
            overflow-x: auto;
        }

        @media (max-width: 768px) {

            .pricing-table td,
            .pricing-table th {
                padding: 10px 8px;
                font-size: 12px;
            }

            .plan-header .plan-name {
                font-size: 12px;
            }

            .price-main,
            .price-vat {
                font-size: 14px;
            }
        }
    </style>

    {{-- Lấy tất cả duration_days duy nhất từ collection, không cần query thêm --}}
    @php
        $durations = $membership
            ->flatMap(fn($m) => $m->membershipPackages->pluck('duration_days'))
            ->unique()
            ->sort()
            ->values();
    @endphp

    {{-- HEADER --}}
    <div class="pg-header text-center">
        <div class="container position-relative">
            <div class="pg-header-badge">
                <i class="fas fa-tags"></i> Bảng giá
            </div>
            <h1 class="pg-title">Bảng giá <span>tin đăng</span></h1>
            <p class="pg-subtitle">Áp dụng từ {{ now()->format('d/m/Y') }}</p>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="container py-5" id="pricingContainer">

        {{-- VAT Toggle --}}
        <!-- <div class="d-flex align-items-center mb-4">
                    <label class="vat-toggle-wrap mb-0" for="vatToggle">
                        <input class="form-check-input" type="checkbox" id="vatToggle" role="switch">
                        <span id="vatLabel">Giá chưa bao gồm VAT</span>
                    </label>
                </div> -->

        @if($membership->isEmpty())
            <div class="alert alert-warning">Chưa có gói dịch vụ nào.</div>
        @else

            @php $colCount = $membership->count(); @endphp

            <div class="pricing-table-wrap">
                <div class="table-scroll">
                    <table class="pricing-table">
                        <colgroup>
                            <col style="width:20%">
                            @foreach($membership as $m)
                                <col style="width:{{ round(80 / $colCount) }}%">
                            @endforeach
                        </colgroup>

                        {{-- THEAD --}}
                        <thead>
                            <tr>
                                <th class="th-label">
                                    <div class="th-label-inner"><span>Loại tin</span></div>
                                </th>
                                @foreach($membership as $m)
                                    <th>
                                        <div class="plan-header" style="background: {{ $m->color ?? '#475569' }};">
                                            <div class="plan-name">{{ $m->name }}</div>
                                            <div class="plan-stars">
                                                @for($i = 0; $i < min($m->priority, 5); $i++)★@endfor
                                                @if($m->priority === 0)&nbsp;@endif
                                            </div>
                                        </div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>

                            {{-- ROWS GIÁ + MÔ TẢ: 2 row mỗi duration_days --}}
                            @foreach($durations as $idx => $days)
                                @php $isLast = $idx === count($durations) - 1; @endphp

                                {{-- Row giá --}}
                                <tr @if($isLast) class="row-highlight" @endif>
                                    @if($days < 7)
                                        <td class="row-label">Giá {{ number_format($days) }} ngày (miễn phí)</td>
                                    @else
                                        <td class="row-label">Giá {{ number_format($days) }} ngày</td>
                                    @endif

                                    @foreach($membership as $m)
                                        @php $pkg = $m->membershipPackages->firstWhere('duration_days', $days); @endphp
                                        <td @if($pkg && !$pkg->is_active) class="pkg-inactive" @endif>
                                            @if($pkg)
                                                <div class="price-wrap">
                                                    <span class="price-main">{{ number_format($pkg->price, 0, ',', '.') }}đ</span>
                                                    <span class="price-vat">{{ number_format($pkg->price * 1.08, 0, ',', '.') }}đ</span>
                                                    @if(!$pkg->is_active)
                                                        <span style="font-size:10px;color:#f97316;font-weight:700;">Tạm dừng</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="price-na">Không có</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>



                            @endforeach

                            {{-- ROW: Mô tả từng loại VIP --}}
                            @if($membership->whereNotNull('description')->isNotEmpty())
                                <tr>
                                    <td class="row-label">Mô tả</td>
                                    @foreach($membership as $m)
                                        <td style="font-size:12px; color:var(--cz-muted); line-height:1.6; padding: 12px 16px;">
                                            @if($m->description)
                                                <ul style="list-style:none; margin:0; padding:0; text-align:left; display:inline-block;">
                                                    @foreach(explode("\n", $m->description) as $line)
                                                        @if(trim($line))
                                                            <li style="display:flex; align-items:flex-start; gap:5px; margin-bottom:4px;">
                                                                <i class="fas fa-check-circle"
                                                                    style="color:#16a34a; font-size:12px; margin-top:2px; flex-shrink:0;"></i>
                                                                <span>{{ trim($line) }}</span>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span style="color:#d1d5db;">—</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endif

                            {{-- ROW: Màu sắc tiêu đề --}}
                            <tr>
                                <td class="row-label">Màu sắc tiêu đề</td>
                                @foreach($membership as $m)
                                    <td>
                                        @if($m->color)
                                            <span class="color-label" style="background:{{ $m->color }}1a; color:{{ $m->color }};">
                                                <i class="fas fa-circle" style="font-size:9px"></i>
                                                {{ $m->color }}
                                            </span>
                                        @else
                                            <span class="color-label" style="background:#f1f5f9; color:#475569;">Mặc định</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>

                            {{-- ROW: CTA --}}
                            <tr>
                                <td class="action-cell row-label"></td>
                                @foreach($membership as $idx => $m)
                                    <td class="action-cell">
                                        <a href="{{ route('frontend.membership.show', ['id' => $m->id, 'slug' => $m->slug]) }}"
                                            class="btn-cz-outline">Đăng ký</a>
                                    </td>
                                @endforeach
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="footnote">
                    <i class="fas fa-info-circle me-1" style="color:var(--cz-primary)"></i>
                    Giá mặc định chưa bao gồm VAT (8%).
                    Gói <span style="color:#f97316;font-weight:700;">Tạm dừng</span> không thể đăng ký.
                </div>
                <div style="height:20px"></div>
            </div>

        @endif
    </div>

    <script>
        const toggle = document.getElementById('vatToggle');
        const container = document.getElementById('pricingContainer');
        const label = document.getElementById('vatLabel');

        toggle.addEventListener('change', function () {
            if (this.checked) {
                container.classList.add('show-vat');
                label.textContent = 'Giá có VAT (8%)';
            } else {
                container.classList.remove('show-vat');
                label.textContent = 'Giá chưa bao gồm VAT';
            }
        });
    </script>

@endsection