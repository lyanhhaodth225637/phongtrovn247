<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title') – NhàTrọ24</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #e8401c;
            --primary-dark: #c0310e;
            --primary-light: #fde8e3;
            --text: #1a1a1a;
            --muted: #6b7280;
            --border: #e5e1db;
            --bg: #f7f5f2;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: 14px;
            color: var(--text);
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ── LEFT ── */
        .auth-left {
            display: flex;
            flex-direction: column;
            padding: 36px 56px;
            background: #fff;
            overflow-y: auto;
            min-height: 100vh;
        }

        .auth-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text);
            margin-bottom: auto;
            flex-shrink: 0;
        }

        .auth-brand-icon {
            width: 38px;
            height: 38px;
            background: var(--primary);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1rem;
        }

        .auth-brand-name {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .auth-brand-name span {
            color: var(--primary);
        }

        .auth-form-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px 0;
            max-width: 360px;
        }

        .auth-title {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .auth-sub {
            font-size: 0.84rem;
            color: var(--muted);
            margin-bottom: 28px;
        }

        .auth-sub a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-sub a:hover {
            text-decoration: underline;
        }

        /* Fields */
        .field {
            margin-bottom: 12px;
        }

        .input-box {
            display: flex;
            align-items: center;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
        }

        .input-box:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(232, 64, 28, 0.08);
        }

        .input-box.is-error {
            border-color: #dc2626;
        }

        .input-box input {
            flex: 1;
            border: none;
            outline: none;
            padding: 13px 16px;
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: 0.87rem;
            color: var(--text);
            background: transparent;
        }

        .input-box input::placeholder {
            color: #c4c4c4;
        }

        .input-box .eye-btn {
            padding: 0 13px;
            color: var(--muted);
            cursor: pointer;
            font-size: 1rem;
            background: none;
            border: none;
            transition: color .15s;
        }

        .input-box .eye-btn:hover {
            color: var(--primary);
        }

        .err {
            font-size: 0.71rem;
            color: #dc2626;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        /* Row */
        .row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .remember input {
            width: 15px;
            height: 15px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .remember label {
            font-size: 0.8rem;
            color: var(--muted);
            cursor: pointer;
        }

        .forgot {
            font-size: 0.8rem;
            color: var(--muted);
            text-decoration: none;
            transition: color .15s;
        }

        .forgot:hover {
            color: var(--primary);
        }

        /* Referral */
        .referral {
            background: #fffbeb;
            border: 1.5px solid #fde68a;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 14px;
        }

        .referral-title {
            font-size: 0.78rem;
            font-weight: 700;
            color: #92400e;
            margin-bottom: 7px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .referral-title small {
            font-weight: 400;
            color: #a16207;
        }

        .referral .input-box {
            border-color: #fde68a;
        }

        .referral .input-box:focus-within {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        .referral-hint {
            font-size: 0.7rem;
            color: #a16207;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        /* Button */
        .btn-auth {
            width: 100%;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-family: 'Be Vietnam Pro', sans-serif;
            font-weight: 700;
            font-size: 0.92rem;
            cursor: pointer;
            transition: background .2s, transform .15s;
            margin-bottom: 18px;
        }

        .btn-auth:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        /* Divider */
        .or {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--muted);
            font-size: 0.76rem;
            margin-bottom: 14px;
        }

        .or::before,
        .or::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* Social */
        .socials {
            display: flex;
            gap: 8px;
        }

        .btn-social {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 6px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text);
            text-decoration: none;
            background: #fff;
            transition: all .2s;
        }

        .btn-social:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-light);
        }

        /* ── RIGHT ── */
        .auth-right {
            position: sticky;
            top: 0;
            height: 100vh;
            background: linear-gradient(160deg, #dbeafe, #bfdbfe 50%, #c7d2fe);
            overflow: hidden;
            display: flex;
            align-items: flex-end;
        }

        .auth-right img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
        }

        .auth-card {
            position: relative;
            z-index: 1;
            margin: 0 32px 36px;
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(12px);
            border-radius: 14px;
            padding: 18px 22px;
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .auth-card p {
            font-size: 0.88rem;
            font-weight: 600;
            line-height: 1.6;
            margin-bottom: 12px;
        }

        .auth-stats {
            display: flex;
            gap: 20px;
        }

        .auth-stat strong {
            display: block;
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--primary);
        }

        .auth-stat span {
            font-size: 0.7rem;
            color: var(--muted);
        }

        @media (max-width: 768px) {
            body {
                grid-template-columns: 1fr;
            }

            .auth-right {
                display: none;
            }

            .auth-left {
                padding: 28px 20px;
            }

            .auth-form-wrap {
                max-width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <div class="auth-left">
        <a href="{{ route('frontend.home') }}" class="auth-brand">
            <div class="auth-brand-icon"><i class="bi bi-house-heart-fill"></i></div>
            <div class="auth-brand-name">Nhà<span>Trọ</span>24</div>
        </a>

        <div class="auth-form-wrap">
            @yield('form')
        </div>
    </div>

    <div class="auth-right">
        <img src="@yield('bg_image', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=800&q=80')" alt="">
        <div class="auth-card">
            <p>🏠 @yield('right_text', 'Tìm phòng trọ ưng ý trong vài phút — hàng nghìn tin mỗi ngày!')</p>
            <div class="auth-stats">
                <div class="auth-stat"><strong>128K+</strong><span>Tin đăng</span></div>
                <div class="auth-stat"><strong>63</strong><span>Tỉnh thành</span></div>
                <div class="auth-stat"><strong>1.2M+</strong><span>Lượt xem/ngày</span></div>
            </div>
        </div>
    </div>

    <script>
        function togglePw(id, iconId) {
            const el = document.getElementById(id);
            const ic = document.getElementById(iconId);
            el.type = el.type === 'password' ? 'text' : 'password';
            ic.className = el.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
        }
    </script>
    @stack('scripts')

</body>

</html>