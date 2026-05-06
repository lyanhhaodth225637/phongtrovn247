<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>403 — Truy cập bị từ chối | PhongTroVN247</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&family=Sora:wght@700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #0d6efd;
            --primary-dark: #0b5ed7;
            --primary-light: #e8f0fe;
            --primary-soft: #eff6ff;
            --bg: #f4f6fb;
            --surface: #ffffff;
            --text: #0f172a;
            --text2: #334155;
            --muted: #64748b;
            --border: #e2e8f0;
            --border2: #cbd5e1;
            --radius: 12px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Card ── */
        .error-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(13, 110, 253, .10);
            padding: 52px 48px 44px;
            max-width: 520px;
            width: 100%;
            text-align: center;
            animation: slideUp .55s cubic-bezier(.22, 1, .36, 1) both;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(28px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── Icon ── */
        .error-icon-wrap {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--primary-soft);
            border: 1.5px solid #bfdbfe;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .error-icon-wrap svg {
            width: 36px;
            height: 36px;
        }

        /* ── 403 number ── */
        .error-code {
            font-family: 'Sora', sans-serif;
            font-size: 96px;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            letter-spacing: -4px;
            margin-bottom: 10px;
        }

        .error-code span {
            display: inline-block;
            animation: bounce .8s ease infinite alternate;
        }

        .error-code span:nth-child(2) {
            animation-delay: .12s;
        }

        .error-code span:nth-child(3) {
            animation-delay: .24s;
        }

        @keyframes bounce {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateY(-8px);
            }
        }

        /* ── Badge ── */
        .error-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--primary-soft);
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            font-size: 0.68rem;
            font-weight: 800;
            padding: 4px 14px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: .4px;
            margin-bottom: 18px;
        }

        /* ── Title / desc ── */
        .error-title {
            font-family: 'Sora', sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .error-desc {
            font-size: 0.84rem;
            color: var(--muted);
            line-height: 1.75;
            margin: 0 auto 32px;
            max-width: 380px;
        }

        /* ── Divider ── */
        .error-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }

        .error-divider-line {
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .error-divider-text {
            font-size: 0.72rem;
            color: #94a3b8;
            font-weight: 600;
            white-space: nowrap;
        }

        /* ── Buttons ── */
        .error-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-primary-custom {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: var(--radius);
            font-family: 'Be Vietnam Pro', sans-serif;
            font-weight: 700;
            font-size: 0.88rem;
            padding: 13px 24px;
            text-decoration: none;
            transition: background .18s, transform .12s;
            cursor: pointer;
        }

        .btn-primary-custom:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            color: #fff;
        }

        .btn-secondary-custom {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: transparent;
            color: var(--text2);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            font-family: 'Be Vietnam Pro', sans-serif;
            font-weight: 600;
            font-size: 0.84rem;
            padding: 11px 24px;
            text-decoration: none;
            transition: border-color .18s, color .18s;
            cursor: pointer;
        }

        .btn-secondary-custom:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* ── Footer branding ── */
        .error-footer {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
            font-size: 0.74rem;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .error-footer strong {
            color: var(--text2);
            font-weight: 700;
        }

        /* ── Responsive ── */
        @media (max-width: 540px) {
            .error-card {
                padding: 36px 22px 32px;
            }

            .error-code {
                font-size: 72px;
            }

            .error-title {
                font-size: 1.05rem;
            }
        }
    </style>
</head>

<body>

    <div class="error-card">

        {{-- Icon --}}
        <div class="error-icon-wrap">
            <svg viewBox="0 0 36 36" fill="none">
                <circle cx="18" cy="18" r="16" stroke="#0d6efd" stroke-width="1.5" />
                <path d="M18 10v10" stroke="#0d6efd" stroke-width="2" stroke-linecap="round" />
                <circle cx="18" cy="25.5" r="1.5" fill="#0d6efd" />
            </svg>
        </div>

        {{-- Code --}}
        <div class="error-code">
            <span>4</span><span>0</span><span>3</span>
        </div>

        {{-- Badge --}}
        <div class="error-badge">
            <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                <rect x="1" y="1" width="8" height="8" rx="2" stroke="#1d4ed8" stroke-width="1" />
                <path d="M5 3v4M3 5h4" stroke="#1d4ed8" stroke-width="1.2" stroke-linecap="round" />
            </svg>
            Truy cập bị từ chối
        </div>

        {{-- Title --}}
        <h1 class="error-title">Bạn không có quyền<br>truy cập trang này</h1>

        {{-- Description --}}
        <p class="error-desc">
            Trang bạn đang cố truy cập yêu cầu đăng nhập hoặc quyền đặc biệt.
            Vui lòng đăng nhập bằng tài khoản hợp lệ hoặc liên hệ quản trị viên để được hỗ trợ.
        </p>

        {{-- Divider --}}
        <div class="error-divider">
            <div class="error-divider-line"></div>
            <span class="error-divider-text">Bạn muốn làm gì?</span>
            <div class="error-divider-line"></div>
        </div>

        {{-- Actions --}}
        <div class="error-actions">
            <a href="{{ url('/') }}" class="btn-primary-custom">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M2 8L8 2L14 8" stroke="#fff" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M4 6.5V13H12V6.5" stroke="#fff" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Về trang chủ
            </a>

            <a href="{{ route('login') }}" class="btn-secondary-custom">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M6 2H3a1 1 0 00-1 1v10a1 1 0 001 1h3" stroke="#475569" stroke-width="1.5"
                        stroke-linecap="round" />
                    <path d="M10 5l3 3-3 3M13 8H6" stroke="#475569" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                Đăng nhập tài khoản
            </a>
        </div>

        {{-- Footer branding --}}
        <div class="error-footer">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <circle cx="7" cy="7" r="6" stroke="#94a3b8" stroke-width="1" />
                <path d="M7 4.5v3l1.5 1.5" stroke="#94a3b8" stroke-width="1" stroke-linecap="round" />
            </svg>
            <strong>PhongTroVN247</strong> · Nền tảng tìm phòng trọ hàng đầu Việt Nam
        </div>

    </div>

</body>

</html>