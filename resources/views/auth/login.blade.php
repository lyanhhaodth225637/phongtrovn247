@extends('layouts.frontend.app')

@section('content')
    <style>
        /* ═══════════════════════════════════════
           AUTH — login / register
           Dùng chung biến từ home.css
        ═══════════════════════════════════════ */

        .auth-page {
            min-height: calc(100vh - 60px);
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
        }

        .auth-card {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1.5px solid var(--border);
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
        }

        /* —— Header —— */
        .auth-card-header {
            background: linear-gradient(135deg, #0f1e4a 0%, #0d2b6e 50%, #0d6efd 100%);
            padding: 28px 32px 24px;
            text-align: center;
            position: relative;
        }

        .auth-card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .auth-logo {
            font-family: 'Sora', sans-serif;
            font-size: 1.3rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 6px;
            letter-spacing: -.5px;
        }

        .auth-logo span {
            color: var(--gold);
        }

        .auth-subtitle {
            font-size: .78rem;
            color: rgba(255, 255, 255, .65);
        }

        /* —— Body —— */
        .auth-card-body {
            padding: 28px 32px 32px;
        }

        /* —— Alert —— */
        .auth-alert-error {
            background: #fff1f2;
            border: 1.5px solid #fecdd3;
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            font-size: .78rem;
            color: #be123c;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* —— Form —— */
        .auth-form-group {
            margin-bottom: 18px;
        }

        .auth-label {
            display: block;
            font-size: .78rem;
            font-weight: 700;
            color: var(--muted);
            margin-bottom: 6px;
            letter-spacing: .02em;
        }

        .auth-input-wrap {
            position: relative;
        }

        .auth-input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: .9rem;
            pointer-events: none;
        }

        .auth-input {
            width: 100%;
            padding: 10px 12px 10px 36px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: .85rem;
            color: var(--text);
            background: var(--surface);
            outline: none;
            transition: border-color .18s, box-shadow .18s;
        }

        .auth-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, .12);
        }

        .auth-input.is-invalid {
            border-color: #e02424;
        }

        .auth-invalid {
            display: block;
            font-size: .73rem;
            color: #e02424;
            margin-top: 4px;
            font-weight: 500;
        }

        /* —— Check row —— */
        .auth-check-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .auth-check-label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: .78rem;
            color: var(--muted);
            cursor: pointer;
            user-select: none;
        }

        .auth-check-label input {
            width: 15px;
            height: 15px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .auth-forgot-link {
            font-size: .76rem;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .auth-forgot-link:hover {
            text-decoration: underline;
        }

        /* —— Submit —— */
        .auth-btn-login {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: .88rem;
            font-weight: 700;
            cursor: pointer;
            transition: background .18s, transform .1s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .auth-btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        /* —— Divider —— */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 18px 0;
            color: var(--border2);
            font-size: .72rem;
            font-weight: 600;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* —— Register link —— */
        .auth-register-row {
            text-align: center;
            font-size: .78rem;
            color: var(--muted);
        }

        .auth-register-link {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-register-link:hover {
            text-decoration: underline;
        }

        /* —— Mobile —— */
        @media (max-width: 480px) {
            .auth-card-body {
                padding: 20px 20px 24px;
            }

            .auth-card-header {
                padding: 22px 20px 18px;
            }
        }
    </style>

    <div class="auth-page">
        <div class="auth-card">

            {{-- Header --}}
            <div class="auth-card-header">
                <div class="auth-logo">Phong<span>Tro</span>VN247</div>
                <div class="auth-subtitle">Đăng nhập vào tài khoản của bạn</div>
            </div>

            {{-- Body --}}
            <div class="auth-card-body">

                {{-- Error --}}
                @if ($errors->any())
                    <div class="auth-alert-error">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Phone --}}
                    <div class="auth-form-group">
                        <label class="auth-label" for="phone">Số điện thoại</label>
                        <div class="auth-input-wrap">
                            <i class="bi bi-telephone auth-input-icon"></i>
                            <input
                                id="phone"
                                type="text"
                                name="phone"
                                class="auth-input @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}"
                                placeholder="Nhập số điện thoại..."
                                required
                                autofocus
                                autocomplete="tel"
                            >
                            @error('phone')
                                <span class="auth-invalid">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="auth-form-group">
                        <label class="auth-label" for="password">Mật khẩu</label>
                        <div class="auth-input-wrap">
                            <i class="bi bi-lock auth-input-icon"></i>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="auth-input @error('password') is-invalid @enderror"
                                placeholder="••••••••"
                                required
                                autocomplete="current-password"
                            >
                            @error('password')
                                <span class="auth-invalid">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Remember + Forgot --}}
                    <div class="auth-check-row">
                        <label class="auth-check-label">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            Ghi nhớ đăng nhập
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="auth-forgot-link">Quên mật khẩu?</a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="auth-btn-login">
                        <i class="bi bi-box-arrow-in-right"></i> Đăng nhập
                    </button>
                </form>

                <div class="auth-divider">hoặc</div>

                <div class="auth-register-row">
                    Chưa có tài khoản?
                    <a href="{{ route('register') }}" class="auth-register-link">Đăng ký ngay</a>
                </div>

            </div>
        </div>
    </div>
@endsection