@extends('layouts.frontend.app')

@push('styles')
    <style>
        /* ── Hero ── */
        .cp-hero {
            background: linear-gradient(135deg, #0f1e4a 0%, #0d2b6e 50%, #0d6efd 100%);
            padding: 48px 0 36px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cp-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(255, 255, 255, .04) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(255, 255, 255, .05) 0%, transparent 50%);
            pointer-events: none;
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
            position: relative;
        }

        .cp-hero p {
            color: rgba(255, 255, 255, .7);
            font-size: .9rem;
            margin-bottom: 0;
            position: relative;
        }

        /* ── Body ── */
        .cp-body {
            max-width: 900px;
            margin: 0 auto;
            padding: 32px 16px 80px;
        }

        /* ── Section title ── */
        .cp-section-title {
            font-weight: 800;
            font-size: .78rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .09em;
            margin-bottom: 16px;
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

        /* ══ ABOUT ══ */
        .cp-about-wrap {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            margin-bottom: 28px;
            box-shadow: var(--shadow-sm);
        }

        .cp-about-top {
            background: linear-gradient(135deg, #0f1e4a 0%, #0d6efd 100%);
            padding: 28px 28px 22px;
            position: relative;
            overflow: hidden;
        }

        .cp-about-top::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, .05);
            border-radius: 50%;
        }

        .cp-about-top::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 110px;
            height: 110px;
            background: rgba(255, 255, 255, .04);
            border-radius: 50%;
        }

        .cp-about-logo {
            font-family: 'Sora', sans-serif;
            font-size: 1.55rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
        }

        .cp-about-logo span {
            color: #f59e0b;
        }

        .cp-about-tagline {
            color: rgba(255, 255, 255, .75);
            font-size: .83rem;
            line-height: 1.6;
            max-width: 560px;
            position: relative;
            z-index: 1;
        }

        .cp-about-body {
            padding: 24px 28px;
        }

        .cp-about-desc {
            font-size: .86rem;
            color: #334155;
            line-height: 1.8;
            margin-bottom: 22px;
        }

        .cp-about-desc strong {
            color: var(--primary);
        }

        .cp-stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 22px;
        }

        .cp-stat-item {
            background: var(--surface2);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 16px 12px;
            text-align: center;
        }

        .cp-stat-num {
            font-family: 'Sora', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1.1;
            margin-bottom: 4px;
        }

        .cp-stat-lbl {
            font-size: .68rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            line-height: 1.4;
        }

        .cp-feature-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .cp-feature-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: .83rem;
            color: #334155;
            line-height: 1.55;
        }

        .cp-feature-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .85rem;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* ══ CONTACT CARDS ══ */
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

        /* ══ MAP ══ */
        .cp-map-wrap {
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            margin-bottom: 28px;
            box-shadow: var(--shadow-sm);
        }

        .cp-map-label {
            background: var(--surface);
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .82rem;
            font-weight: 700;
            color: #334155;
        }

        .cp-map-label i {
            color: #e02424;
            font-size: .95rem;
        }

        .cp-map-wrap iframe {
            display: block;
            width: 100%;
            height: 300px;
            border: none;
        }

        /* ══ CONTACT FORM ══ */
        .cp-form-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 22px;
            margin-bottom: 28px;
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
            font-family: 'Be Vietnam Pro', sans-serif;
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
            font-family: 'Be Vietnam Pro', sans-serif;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: .15s;
        }

        .cp-btn-send:hover {
            background: var(--primary-dark);
        }

        /* ══ POST CTA ══ */
        .cp-post-cta {
            background: linear-gradient(135deg, #0f1e4a 0%, #0d6efd 100%);
            border-radius: var(--radius);
            padding: 32px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            flex-wrap: wrap;
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .cp-post-cta::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, .05);
            border-radius: 50%;
            pointer-events: none;
        }

        .cp-post-cta-left {
            position: relative;
            z-index: 1;
        }

        .cp-post-cta-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(245, 158, 11, .2);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, .35);
            font-size: .65rem;
            font-weight: 800;
            padding: 3px 11px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: .3px;
            margin-bottom: 10px;
        }

        .cp-post-cta-title {
            font-family: 'Sora', sans-serif;
            font-size: 1.15rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 8px;
            line-height: 1.35;
        }

        .cp-post-cta-desc {
            font-size: .8rem;
            color: rgba(255, 255, 255, .72);
            line-height: 1.65;
            max-width: 440px;
        }

        .cp-post-cta-actions {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .cp-post-cta-btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            background: #f59e0b;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-family: 'Be Vietnam Pro', sans-serif;
            font-weight: 700;
            font-size: .85rem;
            padding: 12px 24px;
            text-decoration: none;
            transition: filter .15s, transform .12s;
            white-space: nowrap;
            cursor: pointer;
        }

        .cp-post-cta-btn-primary:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
            color: #fff;
        }

        .cp-post-cta-btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            background: rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .9);
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 10px;
            font-family: 'Be Vietnam Pro', sans-serif;
            font-weight: 600;
            font-size: .82rem;
            padding: 10px 24px;
            text-decoration: none;
            transition: background .15s;
            white-space: nowrap;
        }

        .cp-post-cta-btn-secondary:hover {
            background: rgba(255, 255, 255, .2);
            color: #fff;
        }

        .cp-post-steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 8px;
        }

        .cp-post-step {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 16px 14px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
            transition: box-shadow .18s, transform .18s;
        }

        .cp-post-step:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }

        .cp-step-num {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: var(--primary-light);
            color: var(--primary);
            font-size: .78rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cp-step-title {
            font-size: .8rem;
            font-weight: 700;
            color: #1e293b;
            line-height: 1.4;
        }

        .cp-step-desc {
            font-size: .72rem;
            color: #64748b;
            line-height: 1.55;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .cp-stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .cp-post-steps {
                grid-template-columns: repeat(2, 1fr);
            }

            .cp-post-cta {
                flex-direction: column;
            }

            .cp-post-cta-actions {
                flex-direction: row;
                flex-wrap: wrap;
                width: 100%;
            }

            .cp-about-body {
                padding: 18px;
            }

            .cp-about-top {
                padding: 22px 18px 18px;
            }
        }

        @media (max-width: 540px) {
            .cp-form-row {
                grid-template-columns: 1fr;
            }

            .cp-feature-list {
                grid-template-columns: 1fr;
            }

            .cp-stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .cp-post-steps {
                grid-template-columns: 1fr;
            }

            .cp-post-cta-actions {
                flex-direction: column;
            }

            .cp-post-cta-actions a {
                width: 100%;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')

    {{-- Hero --}}
    <div class="cp-hero">
        <div class="container">
            <h1>Liên hệ & Giới thiệu</h1>
            <p>PhongTroVN247 — Nền tảng tìm phòng trọ hàng đầu Việt Nam</p>
        </div>
    </div>

    <div class="cp-body">

        {{-- ══ ABOUT ══ --}}
        <div class="cp-section-title">
            <i class="bi bi-info-circle-fill" style="color:var(--primary)"></i>
            Về chúng tôi
        </div>

        <div class="cp-about-wrap">
            <div class="cp-about-top">
                <div class="cp-about-logo">PhongTro<span>VN</span>247</div>
                <p class="cp-about-tagline">
                    Kết nối người thuê và chủ phòng nhanh chóng, minh bạch, tin cậy — hoạt động 24/7 trên toàn quốc.
                </p>
            </div>

            <div class="cp-about-body">
                <p class="cp-about-desc">
                    <strong>PhongTroVN247.com</strong> là nền tảng trực tuyến chuyên về thị trường cho thuê phòng trọ, nhà
                    trọ và căn hộ dịch vụ tại Việt Nam. Chúng tôi cung cấp hệ thống đăng tin hiện đại với nhiều gói hội viên
                    linh hoạt, giúp chủ nhà tiếp cận hàng nghìn người thuê tiềm năng mỗi ngày. Với giao diện thân thiện, bộ
                    lọc tìm kiếm thông minh và hệ thống xác thực tin đăng, chúng tôi cam kết mang đến trải nghiệm an toàn và
                    hiệu quả cho cả hai phía.
                </p>

                <div class="cp-stat-grid">
                    <div class="cp-stat-item">
                        <div class="cp-stat-num">10K+</div>
                        <div class="cp-stat-lbl">Tin đăng hoạt động</div>
                    </div>
                    <div class="cp-stat-item">
                        <div class="cp-stat-num">50K+</div>
                        <div class="cp-stat-lbl">Người dùng</div>
                    </div>
                    <div class="cp-stat-item">
                        <div class="cp-stat-num">63</div>
                        <div class="cp-stat-lbl">Tỉnh thành</div>
                    </div>
                    <div class="cp-stat-item">
                        <div class="cp-stat-num">24/7</div>
                        <div class="cp-stat-lbl">Hỗ trợ khách hàng</div>
                    </div>
                </div>

                <div class="cp-feature-list">
                    <div class="cp-feature-item">
                        <div class="cp-feature-icon"><i class="bi bi-shield-check-fill"></i></div>
                        <div><strong>Tin đăng xác thực</strong> — Mỗi tin đăng đều được kiểm duyệt, đảm bảo thông tin chính
                            xác và minh bạch.</div>
                    </div>
                    <div class="cp-feature-item">
                        <div class="cp-feature-icon"><i class="bi bi-search"></i></div>
                        <div><strong>Tìm kiếm thông minh</strong> — Bộ lọc đa tiêu chí: khu vực, giá, diện tích, tiện nghi
                            kèm theo.</div>
                    </div>
                    <div class="cp-feature-item">
                        <div class="cp-feature-icon"><i class="bi bi-star-fill"></i></div>
                        <div><strong>Gói VIP ưu tiên</strong> — Hiển thị nổi bật, tiếp cận nhiều người thuê hơn với các gói
                            hội viên cao cấp.</div>
                    </div>
                    <div class="cp-feature-item">
                        <div class="cp-feature-icon"><i class="bi bi-phone-fill"></i></div>
                        <div><strong>Giao diện di động</strong> — Tối ưu hoàn toàn trên smartphone, dễ dùng mọi lúc mọi nơi.
                        </div>
                    </div>
                    <div class="cp-feature-item">
                        <div class="cp-feature-icon"><i class="bi bi-bell-fill"></i></div>
                        <div><strong>Thông báo tức thì</strong> — Nhận ngay khi có tin phòng phù hợp với nhu cầu của bạn.
                        </div>
                    </div>
                    <div class="cp-feature-item">
                        <div class="cp-feature-icon"><i class="bi bi-headset"></i></div>
                        <div><strong>Hỗ trợ tận tâm</strong> — Đội ngũ CSKH phản hồi nhanh qua Zalo, Facebook và điện thoại.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ CONTACT INFO ══ --}}
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
                    <a href="tel:0855657770" class="cp-contact-value">0855 657 770</a>
                </div>
                <a href="tel:0855657770" class="cp-contact-btn" style="background:#fee2e2;color:#dc2626">
                    <i class="bi bi-telephone"></i> Gọi ngay
                </a>
            </div>

            <div class="cp-contact-card">
                <div class="cp-contact-icon" style="background:#e0f2fe;color:#0284c7">
                    <i class="bi bi-chat-dots-fill"></i>
                </div>
                <div>
                    <div class="cp-contact-label">Zalo</div>
                    <a href="https://zalo.me/0855657770" class="cp-contact-value">0855 657 770</a>
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
                <a href="https://www.facebook.com/nguyen.hao.931157" class="cp-contact-btn"
                    style="background:#e8f0fe;color:#1a56db">
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

        {{-- ══ MAP ══ --}}
        <div class="cp-section-title">
            <i class="bi bi-geo-alt-fill" style="color:#e02424"></i>
            Vị trí văn phòng
        </div>

        <div class="cp-map-wrap">
            <div class="cp-map-label">
                <i class="bi bi-geo-alt-fill"></i>
                Trường Đại học An Giang — 18 Ung Văn Khiêm, P. Đông Xuyên, TP. Long Xuyên, An Giang
            </div>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.6299953616!2d105.41719227586853!3d10.385778789720775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310a6910c9f48a25%3A0x7dd5d5b5e4b7b8e!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBBbiBHaWFuZw!5e0!3m2!1svi!2svn!4v1717000000000!5m2!1svi!2svn"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        {{-- ══ FORM ══ --}}
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

        {{-- ══ POST CTA ══ --}}
        <div class="cp-section-title">
            <i class="bi bi-megaphone-fill" style="color:#f59e0b"></i>
            Đăng tin cho thuê
        </div>

        <div class="cp-post-cta">
            <div class="cp-post-cta-left">
                <div class="cp-post-cta-badge">
                    <i class="bi bi-lightning-fill"></i>
                    Tiếp cận hàng nghìn người thuê
                </div>
                <div class="cp-post-cta-title">
                    Bạn là chủ nhà?<br>Đăng tin ngay hôm nay!
                </div>
                <p class="cp-post-cta-desc">
                    Đăng tin miễn phí hoặc nâng cấp VIP để hiển thị nổi bật, tiếp cận nhiều người thuê hơn. Hệ thống duyệt
                    tin nhanh, giao diện đăng đơn giản, hỗ trợ 24/7.
                </p>
            </div>
            <div class="cp-post-cta-actions">
                <a href="{{ route('user.post.create') }}" class="cp-post-cta-btn-primary">
                    <i class="bi bi-plus-circle-fill"></i>
                    Đăng tin miễn phí
                </a>
                <a href="{{ route('frontend.membership.index') }}" class="cp-post-cta-btn-secondary">
                    <i class="bi bi-star-fill"></i>
                    Xem gói VIP
                </a>
            </div>
        </div>

        {{-- Steps --}}
        <div class="cp-post-steps">
            <div class="cp-post-step">
                <div class="cp-step-num">1</div>
                <div class="cp-step-title">Tạo tài khoản và xác thực quyền Chủ cho thuê</div>
                <div class="cp-step-desc">Đăng ký miễn phí trong vài giây, xác thực nhanh</div>
            </div>
            <div class="cp-post-step">
                <div class="cp-step-num">2</div>
                <div class="cp-step-title">Soạn tin đăng</div>
                <div class="cp-step-desc">Điền thông tin phòng, tải ảnh thực tế và chọn gói hiển thị phù hợp.</div>
            </div>
            <div class="cp-post-step">
                <div class="cp-step-num">3</div>
                <div class="cp-step-title">Chờ duyệt tin</div>
                <div class="cp-step-desc">Đội ngũ kiểm duyệt nhanh chóng, tin được duyệt nhanh chống.</div>
            </div>
            <div class="cp-post-step">
                <div class="cp-step-num">4</div>
                <div class="cp-step-title">Nhận người thuê</div>
                <div class="cp-step-desc">Người thuê liên hệ trực tiếp qua số điện thoại, Zalo hoặc tin nhắn.</div>
            </div>
        </div>

    </div>
@endsection