@extends('layouts.frontend.app')

@push('styles')
    <style>
        .cp-hero {
            background: linear-gradient(135deg, #0f1e4a 0%, #0d2b6e 50%, #0d6efd 100%);
            padding: 48px 0 36px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cp-hero::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, #f59e0b, transparent);
        }

        .cp-hero h1 {
            font-family: 'Sora', sans-serif;
            font-size: clamp(1.3rem, 4vw, 1.9rem);
            font-weight: 800;
            color: #fff;
            margin-bottom: 8px;
        }

        .cp-hero p {
            color: rgba(255, 255, 255, .7);
            font-size: .9rem;
            margin-bottom: 0;
        }

        .cp-body {
            max-width: 860px;
            margin: 0 auto;
            padding: 28px 16px 80px;
        }

        .cp-section-title {
            font-weight: 800;
            font-size: .78rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .09em;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cp-section-title::after {
            content: '';
            flex: 1;
            height: 1.5px;
            background: #e2e8f0;
        }

        .cp-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 12px;
            margin-bottom: 28px;
        }

        .cp-contact-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            text-align: center;
            transition: .18s;
        }

        .cp-contact-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }

        .cp-contact-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        .cp-contact-label {
            font-size: .68rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .07em;
        }

        .cp-contact-value {
            font-size: .88rem;
            font-weight: 700;
            color: #1e293b;
            text-decoration: none;
        }

        .cp-contact-value:hover {
            color: var(--primary);
        }

        .cp-contact-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 4px;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: .74rem;
            font-weight: 700;
            border: none;
            text-decoration: none;
            transition: .15s;
        }

        .cp-contact-btn:hover {
            filter: brightness(.95);
        }

        .cp-map-placeholder {
            background: #e8f0fe;
            border: 1.5px solid #bfdbfe;
            border-radius: var(--radius);
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 10px;
            color: #1d4ed8;
            margin-bottom: 28px;
            padding: 24px;
            text-align: center;
            font-size: .88rem;
            font-weight: 600;
        }

        .cp-form-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 22px;
            margin-bottom: 32px;
        }

        .cp-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .cp-input,
        .cp-textarea {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: .84rem;
            color: #1e293b;
            outline: none;
            background: #f8fafc;
            box-sizing: border-box;
            margin-bottom: 12px;
            transition: .15s;
        }

        .cp-input:focus,
        .cp-textarea:focus {
            border-color: var(--primary);
            background: #fff;
        }

        .cp-textarea {
            resize: none;
        }

        .cp-btn-send {
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 11px 28px;
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: .15s;
        }

        .cp-btn-send:hover {
            background: var(--primary-dark);
        }

        .cp-summary {
            display: flex;
            gap: 20px;
            align-items: center;
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 18px 22px;
            margin-bottom: 16px;
        }

        .cp-big-score {
            font-family: 'Sora', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        .cp-stars-yellow {
            color: #f59e0b;
            font-size: .95rem;
            letter-spacing: 1px;
        }

        .cp-bar-row {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: .72rem;
            color: #64748b;
            margin-top: 5px;
        }

        .cp-bar {
            flex: 1;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
            min-width: 80px;
        }

        .cp-bar-fill {
            height: 100%;
            border-radius: 3px;
            background: #f59e0b;
        }

        .cp-review-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
            margin-bottom: 16px;
        }

        .cp-review-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .cp-review-text {
            font-size: .82rem;
            color: #334155;
            line-height: 1.7;
            flex: 1;
        }

        .cp-reviewer {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-top: 4px;
        }

        .cp-reviewer-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .cp-reviewer-name {
            font-size: .78rem;
            font-weight: 700;
            color: #1e293b;
        }

        .cp-reviewer-date {
            font-size: .68rem;
            color: #94a3b8;
        }

        .cp-write-review {
            background: #f8fafc;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            margin-top: 8px;
        }

        .cp-star-row {
            display: flex;
            gap: 6px;
            font-size: 1.6rem;
            color: #d1d5db;
            cursor: pointer;
            margin-bottom: 12px;
        }

        @media (max-width: 540px) {
            .cp-form-row {
                grid-template-columns: 1fr;
            }

            .cp-summary {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush

@section('content')
    <div class="cp-hero">
        <div class="container">
            <h1>Liên hệ với chúng tôi</h1>
            <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn mọi lúc, mọi nơi.</p>
        </div>
    </div>

    <div class="cp-body">

        <div class="cp-section-title">
            <i class="bi bi-telephone-fill" style="color:var(--primary)"></i>
            Thông tin liên hệ
        </div>

        <div class="cp-cards">
            <div class="cp-contact-card">
                <div class="cp-contact-icon" style="background:#fee2e2;color:#dc2626">
                    <i class="bi bi-telephone-fill"></i>
                </div>

                <div>
                    <div class="cp-contact-label">Điện thoại</div>
                    <a href="tel:0901234567" class="cp-contact-value">0855657770</a>
                </div>

                <a href="tel:0901234567" class="cp-contact-btn" style="background:#fee2e2;color:#dc2626">
                    <i class="bi bi-telephone"></i> Gọi ngay
                </a>
            </div>

            <div class="cp-contact-card">
                <div class="cp-contact-icon" style="background:#e0f2fe;color:#0284c7">
                    <i class="bi bi-chat-dots-fill"></i>
                </div>

                <div>
                    <div class="cp-contact-label">Zalo</div>
                    <a href="https://zalo.me/0855657770" class="cp-contact-value">0855657770</a>
                </div>

                <a href="https://zalo.me/0855657770" class="cp-contact-btn" style="background:#e0f2fe;color:#0284c7">
                    <i class="bi bi-chat-dots"></i> Nhắn Zalo
                </a>
            </div>

            <div class="cp-contact-card">
                <div class="cp-contact-icon" style="background:#e8f0fe;color:#1a56db">
                    <i class="bi bi-facebook"></i>
                </div>

                <div>
                    <div class="cp-contact-label">Facebook</div>
                    <a href="https://www.facebook.com/nguyen.hao.931157" class="cp-contact-value">PhongTroVN247</a>
                </div>

                <a href="https://www.facebook.com/nguyen.hao.931157" class="cp-contact-btn" style="background:#e8f0fe;color:#1a56db">
                    <i class="bi bi-facebook"></i> Nhắn tin FB
                </a>
            </div>
            <div class="cp-contact-card">
                <div class="cp-contact-icon" style="background:#fef3c7;color:#d97706">
                    <i class="bi bi-envelope-fill"></i>
                </div>

                <div>
                    <div class="cp-contact-label">Email</div>
                    <a href="mailto:lienhe@phongtrovn247.com" class="cp-contact-value" style="font-size:.8rem">
                        lienhe@phongtrovn247.com
                    </a>
                </div>

                <a href="mailto:lienhe@phongtrovn247.com" class="cp-contact-btn" style="background:#fef3c7;color:#d97706">
                    <i class="bi bi-envelope"></i> Gửi email
                </a>
            </div>
        </div>

        <div class="cp-map-placeholder">
            <i class="bi bi-geo-alt-fill" style="font-size:2rem"></i>
            <span>123 Trần Hưng Đạo, P. Mỹ Xuyên, TP. Long Xuyên, An Giang</span>
        </div>

        <div class="cp-section-title">
            <i class="bi bi-pencil-square" style="color:var(--primary)"></i>
            Gửi tin nhắn cho chúng tôi
        </div>

        <div class="cp-form-card">
            <form action="#" method="POST">
                @csrf

                <div class="cp-form-row">
                    <input type="text" name="name" class="cp-input" placeholder="Họ và tên của bạn" required>

                    <input type="text" name="phone_or_email" class="cp-input" placeholder="Số điện thoại / Email" required>
                </div>

                <input type="text" name="subject" class="cp-input" placeholder="Tiêu đề nội dung" required>

                <textarea name="message" class="cp-textarea" rows="4" placeholder="Nội dung bạn muốn liên hệ..."
                    required></textarea>

                <button type="submit" class="cp-btn-send">
                    <i class="bi bi-send-fill"></i> Gửi tin nhắn
                </button>
            </form>
        </div>

        <div class="cp-section-title">
            <i class="bi bi-star-fill" style="color:#f59e0b"></i>
            Đánh giá từ người dùng
        </div>

        <div class="cp-summary">
            <div style="text-align:center;flex-shrink:0">
                <div class="cp-big-score">4.8</div>
                <div class="cp-stars-yellow">★★★★★</div>
                <div style="font-size:.72rem;color:#64748b;margin-top:4px">
                    128 đánh giá
                </div>
            </div>

            <div style="flex:1;min-width:0">
                <div class="cp-bar-row">
                    <span style="min-width:14px">5★</span>
                    <div class="cp-bar">
                        <div class="cp-bar-fill" style="width:82%"></div>
                    </div>
                    <span>105</span>
                </div>

                <div class="cp-bar-row">
                    <span style="min-width:14px">4★</span>
                    <div class="cp-bar">
                        <div class="cp-bar-fill" style="width:12%;background:#94a3b8"></div>
                    </div>
                    <span>15</span>
                </div>

                <div class="cp-bar-row">
                    <span style="min-width:14px">3★</span>
                    <div class="cp-bar">
                        <div class="cp-bar-fill" style="width:5%;background:#cbd5e1"></div>
                    </div>
                    <span>6</span>
                </div>

                <div class="cp-bar-row">
                    <span style="min-width:14px">2★</span>
                    <div class="cp-bar">
                        <div class="cp-bar-fill" style="width:1%;background:#e2e8f0"></div>
                    </div>
                    <span>2</span>
                </div>

                <div class="cp-bar-row">
                    <span style="min-width:14px">1★</span>
                    <div class="cp-bar">
                        <div class="cp-bar-fill" style="width:0%"></div>
                    </div>
                    <span>0</span>
                </div>
            </div>
        </div>

        <div class="cp-review-grid">
            @forelse($reviews ?? [] as $review)
                <div class="cp-review-card">
                    <div class="cp-stars-yellow">
                        @for($i = 1; $i <= 5; $i++)
                            <span style="{{ $i > $review->rating ? 'color:#e2e8f0' : '' }}">★</span>
                        @endfor
                    </div>

                    <p class="cp-review-text">{{ $review->content }}</p>

                    <div class="cp-reviewer">
                        <div class="cp-reviewer-avatar" style="background:var(--primary)">
                            {{ strtoupper(substr($review->user->name ?? '?', 0, 1)) }}
                        </div>

                        <div>
                            <div class="cp-reviewer-name">
                                {{ $review->user->name ?? 'Ẩn danh' }}
                            </div>

                            <div class="cp-reviewer-date">
                                {{ $review->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="cp-review-card">
                    <div class="cp-stars-yellow">★★★★★</div>
                    <p class="cp-review-text">
                        Trang web rất dễ dùng, tìm phòng nhanh chóng. Thông tin chính xác, liên hệ chủ nhà thuận tiện!
                    </p>

                    <div class="cp-reviewer">
                        <div class="cp-reviewer-avatar" style="background:#0d6efd">T</div>

                        <div>
                            <div class="cp-reviewer-name">Trần Minh Tuấn</div>
                            <div class="cp-reviewer-date">12/03/2025</div>
                        </div>
                    </div>
                </div>

                <div class="cp-review-card">
                    <div class="cp-stars-yellow">★★★★★</div>
                    <p class="cp-review-text">
                        Đội ngũ hỗ trợ nhiệt tình, phản hồi nhanh. Được giải quyết vấn đề trong vòng 30 phút. Rất hài lòng!
                    </p>

                    <div class="cp-reviewer">
                        <div class="cp-reviewer-avatar" style="background:#059669">L</div>

                        <div>
                            <div class="cp-reviewer-name">Lê Thị Hoa</div>
                            <div class="cp-reviewer-date">28/02/2025</div>
                        </div>
                    </div>
                </div>

                <div class="cp-review-card">
                    <div class="cp-stars-yellow">★★★★<span style="color:#e2e8f0">★</span></div>
                    <p class="cp-review-text">
                        Giao diện đẹp, bộ lọc tìm kiếm đầy đủ. Nhìn chung là nền tảng tốt nhất hiện tại.
                    </p>

                    <div class="cp-reviewer">
                        <div class="cp-reviewer-avatar" style="background:#7c3aed">N</div>

                        <div>
                            <div class="cp-reviewer-name">Nguyễn Văn Nam</div>
                            <div class="cp-reviewer-date">15/01/2025</div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        @auth
            <div class="cp-write-review">
                <div
                    style="font-weight:800;font-size:.88rem;color:#1e293b;margin-bottom:12px;display:flex;align-items:center;gap:7px">
                    <i class="bi bi-pencil" style="color:var(--primary)"></i>
                    Viết đánh giá của bạn
                </div>

                <form action="#" method="POST">
                    @csrf

                    <input type="hidden" name="rating" id="ratingInput" value="0">

                    <div class="cp-star-row" id="starRow">
                        <span data-v="1">★</span>
                        <span data-v="2">★</span>
                        <span data-v="3">★</span>
                        <span data-v="4">★</span>
                        <span data-v="5">★</span>
                    </div>

                    <textarea name="content" class="cp-textarea" rows="3"
                        placeholder="Chia sẻ trải nghiệm của bạn..."></textarea>

                    <button type="submit" class="cp-btn-send" style="font-size:.82rem;padding:9px 20px">
                        <i class="bi bi-send"></i> Gửi đánh giá
                    </button>
                </form>
            </div>
        @else
            <div
                style="text-align:center;padding:20px;background:#f8fafc;border:1.5px solid var(--border);border-radius:var(--radius);color:#64748b;font-size:.85rem">
                <i class="bi bi-lock" style="font-size:1.3rem;display:block;margin-bottom:8px;color:#94a3b8"></i>

                <a href="{{ route('login') }}" style="color:var(--primary);font-weight:700">
                    Đăng nhập
                </a>
                để viết đánh giá của bạn.
            </div>
        @endauth

    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            let selected = 0;
            const stars = document.querySelectorAll('#starRow span');

            if (!stars.length) return;

            stars.forEach((star, index) => {
                star.addEventListener('mouseover', () => {
                    stars.forEach((s, i) => {
                        s.style.color = i <= index ? '#f59e0b' : '#d1d5db';
                    });
                });

                star.addEventListener('click', () => {
                    selected = parseInt(star.dataset.v);
                    document.getElementById('ratingInput').value = selected;

                    stars.forEach((s, i) => {
                        s.style.color = i < selected ? '#f59e0b' : '#d1d5db';
                    });
                });
            });

            document.getElementById('starRow').addEventListener('mouseleave', () => {
                stars.forEach((s, i) => {
                    s.style.color = i < selected ? '#f59e0b' : '#d1d5db';
                });
            });
        })();
    </script>
@endpush