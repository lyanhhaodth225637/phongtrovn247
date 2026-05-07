@extends('layouts.user.app')

@section('title', 'Giới thiệu bạn bè')

@section('content')
    <style>
        .referral-page {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* ══ BANNER ══ */
        .referral-banner {
            background: linear-gradient(135deg, #0f1e4a 0%, #0d6efd 100%);
            border-radius: var(--radius);
            padding: 28px 24px;
            position: relative;
            overflow: hidden;
        }

        .referral-banner::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, .06);
            border-radius: 50%;
            pointer-events: none;
        }

        .referral-banner::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, .04);
            border-radius: 50%;
            pointer-events: none;
        }

        .referral-banner__content {
            position: relative;
            z-index: 1;
        }

        .referral-banner h1 {
            font-family: 'Sora', sans-serif;
            font-size: clamp(1rem, 3.5vw, 1.4rem);
            font-weight: 800;
            color: #fff;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .referral-banner p {
            font-size: .84rem;
            color: rgba(255, 255, 255, .75);
            margin-bottom: 20px;
            line-height: 1.6;
            max-width: 480px;
        }

        /* Code box */
        .referral-code-box {
            display: inline-flex;
            flex-direction: column;
            gap: 4px;
            background: rgba(255, 255, 255, .12);
            border: 1.5px solid rgba(255, 255, 255, .25);
            border-radius: var(--radius-sm);
            padding: 12px 20px;
            min-width: 200px;
        }

        .referral-code-box span {
            font-size: .7rem;
            color: rgba(255, 255, 255, .65);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .referral-code-box strong {
            font-family: monospace;
            font-size: 1.35rem;
            color: #fff;
            letter-spacing: 2px;
        }

        /* Copy button */
        .btn-referral {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--gold, #f59e0b);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-family: 'Be Vietnam Pro', sans-serif;
            font-weight: 700;
            font-size: .84rem;
            padding: 10px 20px;
            cursor: pointer;
            transition: filter .15s, transform .1s;
            white-space: nowrap;
        }

        .btn-referral:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }

        .btn-referral.copied {
            background: #10b981;
        }

        /* Share row */
        .referral-share-row {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .btn-share {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .78rem;
            font-weight: 600;
            padding: 7px 14px;
            border-radius: var(--radius-sm);
            border: 1.5px solid rgba(255, 255, 255, .3);
            background: rgba(255, 255, 255, .1);
            color: rgba(255, 255, 255, .9);
            cursor: pointer;
            transition: background .15s;
            text-decoration: none;
        }

        .btn-share:hover {
            background: rgba(255, 255, 255, .2);
            color: #fff;
        }

        /* ══ HOW IT WORKS ══ */
        .how-it-works {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .how-it-works-head {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 18px;
            border-bottom: 1.5px solid var(--border);
            background: #f8fafc;
        }

        .how-it-works-head i {
            font-size: 1rem;
            color: var(--primary);
        }

        .how-it-works-head span {
            font-size: .85rem;
            font-weight: 700;
            color: var(--text);
        }

        .how-it-works-body {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
            padding: 0;
        }

        .how-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 20px 16px;
            border-right: 1px solid var(--border);
            position: relative;
        }

        .how-step:last-child {
            border-right: none;
        }

        .how-step-num {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary-light, #e8f0fe);
            color: var(--primary);
            font-size: .85rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            flex-shrink: 0;
        }

        .how-step-title {
            font-size: .82rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }

        .how-step-desc {
            font-size: .73rem;
            color: var(--muted);
            line-height: 1.55;
        }

        /* ══ STATS ══ */
        .referral-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .ref-stat-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            box-shadow: var(--shadow-sm);
        }

        .ref-stat-card__text small {
            font-size: .7rem;
            color: var(--muted);
            font-weight: 600;
            display: block;
            margin-bottom: 4px;
        }

        .ref-stat-card__text h3 {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text);
            margin: 0;
            line-height: 1.2;
        }

        .ref-stat-card__icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .ref-stat-card__icon.pink {
            background: #fce7f3;
            color: #9d174d;
        }

        .ref-stat-card__icon.blue {
            background: var(--primary-light, #e8f0fe);
            color: var(--primary);
        }

        .ref-stat-card__icon.green {
            background: #f0fdf4;
            color: #15803d;
        }

        /* ══ TABLE SECTION ══ */
        .referral-table-wrap {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .referral-table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 18px;
            border-bottom: 1.5px solid var(--border);
            background: #f8fafc;
            flex-wrap: wrap;
            gap: 8px;
        }

        .referral-table-header h2 {
            font-size: .85rem;
            font-weight: 700;
            color: var(--text);
            margin: 0;
        }

        .referral-table-header h2.text-primary {
            color: var(--primary);
        }

        .referral-table-body {
            padding: 0 18px 18px;
        }

        .referral-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .82rem;
            margin-bottom: 0;
        }

        .referral-table thead tr {
            border-bottom: 1.5px solid var(--border);
        }

        .referral-table thead th {
            padding: 10px 10px;
            font-size: .7rem;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .04em;
            white-space: nowrap;
            background: transparent;
            border: none;
        }

        .referral-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background .1s;
        }

        .referral-table tbody tr:last-child {
            border-bottom: none;
        }

        .referral-table tbody tr:hover {
            background: #fafbfc;
        }

        .referral-table tbody td {
            padding: 11px 10px;
            color: var(--text);
            vertical-align: middle;
            border: none;
        }

        .referral-table .code-cell {
            font-family: monospace;
            font-size: .78rem;
            color: var(--muted);
        }

        .referral-table .date-cell {
            font-size: .75rem;
            color: var(--muted);
            white-space: nowrap;
        }

        .ref-badge-deposited {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: .67rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .ref-badge-pending {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: .67rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            background: #f8fafc;
            color: #64748b;
            border: 1px solid var(--border);
        }

        .ref-section-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 18px 10px;
            font-size: .75rem;
            font-weight: 700;
            color: var(--primary);
            border-top: 1.5px solid var(--border);
            margin-top: 4px;
        }

        .ref-section-divider i {
            font-size: .85rem;
        }

        .empty-state {
            padding: 36px 16px;
            text-align: center;
        }

        .empty-state i {
            font-size: 2rem;
            color: #cbd5e1;
            display: block;
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: .8rem;
            color: var(--muted);
            margin: 0;
        }

        /* ══ RESPONSIVE ══ */
        @media (max-width: 768px) {
            .how-it-works-body {
                grid-template-columns: 1fr;
            }

            .how-step {
                border-right: none;
                border-bottom: 1px solid var(--border);
                padding: 16px;
                flex-direction: row;
                text-align: left;
                gap: 14px;
            }

            .how-step:last-child {
                border-bottom: none;
            }

            .how-step-num {
                margin-bottom: 0;
                flex-shrink: 0;
            }

            .how-step-content {
                flex: 1;
            }
        }

        @media (max-width: 640px) {
            .referral-stats {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .ref-stat-card {
                padding: 12px 14px;
            }

            .ref-stat-card__text h3 {
                font-size: .95rem;
            }

            .referral-table-body {
                padding: 0 12px 12px;
            }

            .referral-table-header {
                padding: 11px 12px;
            }

            .referral-banner {
                padding: 22px 16px;
            }

            .referral-code-box {
                min-width: unset;
                width: 100%;
            }
        }

        @media (max-width: 480px) {

            /* table scroll ngang trên màn nhỏ */
            .referral-table-body {
                padding: 0;
            }

            .table-scroll-wrap {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                padding: 0 14px 14px;
            }

            .referral-table {
                min-width: 460px;
            }

            .referral-table-header {
                padding: 10px 14px;
            }

            .referral-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            /* .referral-stats .ref-stat-card:last-child {
                                    grid-column: 1 / -1;
                                } */
        }

        @media (max-width: 360px) {
            .referral-stats {
                grid-template-columns: 1fr;
            }

            .referral-stats .ref-stat-card:last-child {
                grid-column: unset;
            }
        }
    </style>

    <div class="referral-page">

        {{-- ── Banner ── --}}
        <div class="referral-banner">
            <div class="referral-banner__content">
                <h1>Mời bạn thêm vui — Quà về đầy túi 🎁</h1>
                <p>Nhận thưởng khi bạn bè đăng ký và nạp tiền lần đầu qua mã giới thiệu của bạn.</p>

                <div class="referral-code-box">
                    <span>Mã giới thiệu của bạn</span>
                    <strong id="refCode">{{ auth()->user()->phone }}</strong>
                </div>

                <div class="referral-share-row mt-3">
                    <button type="button" class="btn-referral" id="copyBtn" onclick="copyReferralCode()">
                        <i class="bi bi-clipboard"></i> Sao chép mã
                    </button>
                    <a href="https://zalo.me/share?text=Dùng%20mã%20{{ auth()->user()->phone }}%20để%20đăng%20ký%20PhongTroVN247%20nhé!"
                        target="_blank" class="btn-share">
                        <i class="bi bi-chat-dots-fill"></i> Chia sẻ Zalo
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('frontend.home')) }}"
                        target="_blank" class="btn-share">
                        <i class="bi bi-facebook"></i> Facebook
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Cách thức hoạt động ── --}}
        <div class="how-it-works">
            <div class="how-it-works-head">
                <i class="bi bi-info-circle-fill"></i>
                <span>Cách thức hoạt động</span>
            </div>
            <div class="how-it-works-body">
                <div class="how-step">
                    <div class="how-step-num">1</div>
                    <div class="how-step-content">
                        <div class="how-step-title">Chia sẻ mã</div>
                        <div class="how-step-desc">Gửi mã giới thiệu hoặc link đăng ký cho bạn bè</div>
                    </div>
                </div>
                <div class="how-step">
                    <div class="how-step-num">2</div>
                    <div class="how-step-content">
                        <div class="how-step-title">Bạn bè đăng ký</div>
                        <div class="how-step-desc">Bạn bè nhập mã khi đăng ký tài khoản mới</div>
                    </div>
                </div>
                <div class="how-step">
                    <div class="how-step-num">3</div>
                    <div class="how-step-content">
                        <div class="how-step-title">Nhận thưởng</div>
                        <div class="how-step-desc">Bạn nhận thưởng khi họ nạp tiền lần đầu thành công</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Thống kê ── --}}
        <div class="referral-stats">
            <div class="ref-stat-card">
                <div class="ref-stat-card__text">
                    <small>Đã giới thiệu</small>
                    <h3>{{ $referrals->count() }} người</h3>
                </div>
                <div class="ref-stat-card__icon pink">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="ref-stat-card">
                <div class="ref-stat-card__text">
                    <small>Đã nhận thưởng</small>
                    <h3>{{ number_format($totalReward, 0, ',', '.') }} đ</h3>
                </div>
                <div class="ref-stat-card__icon green">
                    <i class="bi bi-wallet2"></i>
                </div>
            </div>
        </div>

        {{-- ── Bảng danh sách ── --}}
        <div class="referral-table-wrap">
            <div class="referral-table-header">
                <h2><i class="bi bi-list-ul me-2" style="color:var(--primary)"></i>Danh sách đã giới thiệu</h2>

            </div>

            {{-- Danh sách người giới thiệu --}}
            @if($referrals->count())

                <div class="table-scroll-wrap">
                    <table class="referral-table">
                        <thead>
                            <tr>
                                <th>Mã TK</th>
                                <th>Tên </th>
                                <th>Số điện thoại</th>
                                <th>Ngày đăng ký</th>
                                <th>Thưởng nạp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($referrals as $item)
                                <tr>
                                    <td class="code-cell">#{{ $item->id }}</td>
                                    <td style="font-weight:500">{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td class="date-cell">{{ optional($item->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($item->has_deposited == true)
                                            @foreach ($transactions as $item)
                                                <span class="ref-badge-deposited"><i class="bi bi-check-circle-fill">Đã nạp</i></span>
                                            @endforeach

                                        @else
                                            <span class="ref-badge-deposited"><i class="bi bi-check-circle-fill"></i>Chưa nạp</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function copyReferralCode() {
            var code = @json(auth()->user()->phone);
            var btn = document.getElementById('copyBtn');

            navigator.clipboard.writeText(code).then(function () {
                btn.innerHTML = '<i class="bi bi-check-lg"></i> Đã sao chép!';
                btn.classList.add('copied');
                setTimeout(function () {
                    btn.innerHTML = '<i class="bi bi-clipboard"></i> Sao chép mã';
                    btn.classList.remove('copied');
                }, 2500);
            }).catch(function () {
                /* fallback cho trình duyệt cũ */
                var ta = document.createElement('textarea');
                ta.value = code;
                ta.style.position = 'fixed';
                ta.style.opacity = '0';
                document.body.appendChild(ta);
                ta.focus(); ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                btn.innerHTML = '<i class="bi bi-check-lg"></i> Đã sao chép!';
                btn.classList.add('copied');
                setTimeout(function () {
                    btn.innerHTML = '<i class="bi bi-clipboard"></i> Sao chép mã';
                    btn.classList.remove('copied');
                }, 2500);
            });
        }
    </script>
@endpush