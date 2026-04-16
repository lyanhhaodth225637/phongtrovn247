@extends('layouts.frontend.app')

@section('content')
<style>
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
        color: rgba(255,255,255,.65);
    }

    .auth-card-body {
        padding: 28px 32px 32px;
    }

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

    .auth-form-group {
        margin-bottom: 14px;
    }

    .auth-label {
        display: block;
        font-size: .78rem;
        font-weight: 700;
        color: var(--muted);
        margin-bottom: 6px;
        letter-spacing: .02em;
    }

    .auth-label .optional {
        font-weight: 400;
        color: #94a3b8;
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
        box-shadow: 0 0 0 3px rgba(13,110,253,.12);
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

    .auth-hint {
        display: block;
        font-size: .7rem;
        color: #94a3b8;
        margin-top: 3px;
    }

    .auth-pw-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #94a3b8;
        font-size: .9rem;
        display: flex;
        align-items: center;
        padding: 0 2px;
        transition: color .15s;
    }

    .auth-pw-toggle:hover {
        color: var(--primary);
    }

    .auth-input.has-toggle {
        padding-right: 36px;
    }

    .auth-form-divider {
        height: 1px;
        background: var(--border);
        margin: 6px 0 14px;
    }

    .auth-referral-bonus {
        display: flex;
        align-items: center;
        gap: 7px;
        background: #fffbeb;
        border: 1px solid #fde68a;
        border-radius: var(--radius-sm);
        padding: 8px 12px;
        margin-top: 7px;
        font-size: .7rem;
        color: #92400e;
        font-weight: 600;
        line-height: 1.5;
    }

    .auth-referral-bonus i {
        color: var(--gold);
        font-size: .85rem;
        flex-shrink: 0;
    }

    .auth-btn-submit {
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
        margin-top: 6px;
    }

    .auth-btn-submit:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

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

    .auth-footer-row {
        text-align: center;
        font-size: .78rem;
        color: var(--muted);
    }

    .auth-footer-link {
        color: var(--primary);
        font-weight: 700;
        text-decoration: none;
    }

    .auth-footer-link:hover {
        text-decoration: underline;
    }

    .auth-terms {
        text-align: center;
        font-size: .68rem;
        color: #94a3b8;
        margin-top: 14px;
        line-height: 1.6;
    }

    .auth-terms a {
        color: var(--primary);
        text-decoration: none;
    }

    .auth-terms a:hover {
        text-decoration: underline;
    }

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
            <div class="auth-subtitle">Tạo tài khoản để đăng tin và tìm phòng dễ dàng hơn</div>
        </div>

        {{-- Body --}}
        <div class="auth-card-body">

            @if ($errors->any())
                <div class="auth-alert-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Họ tên --}}
                <div class="auth-form-group">
                    <label class="auth-label" for="name">Họ tên</label>
                    <div class="auth-input-wrap">
                        <i class="bi bi-person auth-input-icon"></i>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            class="auth-input @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Nguyễn Văn A"
                            required
                            autocomplete="name"
                            autofocus
                        >
                    </div>
                    @error('name')
                        <span class="auth-invalid">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Số điện thoại --}}
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
                            placeholder="0901 234 567"
                            required
                            autocomplete="tel"
                        >
                    </div>
                    @error('phone')
                        <span class="auth-invalid">{{ $message }}</span>
                    @else
                        <span class="auth-hint">Dùng để đăng nhập, không hiển thị công khai</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="auth-form-group">
                    <label class="auth-label" for="email">
                        Email <span class="optional">(nếu có)</span>
                    </label>
                    <div class="auth-input-wrap">
                        <i class="bi bi-envelope auth-input-icon"></i>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="auth-input @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="example@email.com"
                            autocomplete="email"
                        >
                    </div>
                    @error('email')
                        <span class="auth-invalid">{{ $message }}</span>
                    @enderror
                </div>

                <div class="auth-form-divider"></div>

                {{-- Mật khẩu --}}
                <div class="auth-form-group">
                    <label class="auth-label" for="password">Mật khẩu</label>
                    <div class="auth-input-wrap">
                        <i class="bi bi-lock auth-input-icon"></i>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="auth-input has-toggle @error('password') is-invalid @enderror"
                            placeholder="Tối thiểu 8 ký tự"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" class="auth-pw-toggle" tabindex="-1" onclick="togglePw('password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="auth-invalid">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Xác nhận mật khẩu --}}
                <div class="auth-form-group">
                    <label class="auth-label" for="password-confirm">Xác nhận mật khẩu</label>
                    <div class="auth-input-wrap">
                        <i class="bi bi-lock-fill auth-input-icon"></i>
                        <input
                            id="password-confirm"
                            type="password"
                            name="password_confirmation"
                            class="auth-input has-toggle"
                            placeholder="Nhập lại mật khẩu"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" class="auth-pw-toggle" tabindex="-1" onclick="togglePw('password-confirm', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="auth-form-divider"></div>

                {{-- Người giới thiệu --}}
                <div class="auth-form-group">
                    <label class="auth-label" for="referred_by">
                        SĐT người giới thiệu <span class="optional">(nếu có)</span>
                    </label>
                    <div class="auth-input-wrap">
                        <i class="bi bi-gift auth-input-icon"></i>
                        <input
                            id="referred_by"
                            type="text"
                            name="referred_by"
                            class="auth-input @error('referred_by') is-invalid @enderror"
                            value="{{ old('referred_by') }}"
                            placeholder="Số điện thoại người giới thiệu"
                            autocomplete="tel"
                        >
                    </div>
                    @error('referred_by')
                        <span class="auth-invalid">{{ $message }}</span>
                    @enderror

                    <div class="auth-referral-bonus">
                        <i class="bi bi-star-fill"></i>
                        Cả hai sẽ nhận được ưu đãi khi đăng ký thành công!
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="auth-btn-submit">
                    <i class="bi bi-person-plus-fill"></i> Đăng ký ngay
                </button>
            </form>

            <div class="auth-divider">hoặc</div>

            <div class="auth-footer-row">
                Đã có tài khoản?
                <a href="{{ route('login') }}" class="auth-footer-link">Đăng nhập</a>
            </div>
        </div>
    </div>
</div>

<div class="auth-terms">
    Bằng cách đăng ký, bạn đồng ý với
    <a href="#">Điều khoản dịch vụ</a> và
    <a href="#">Chính sách bảo mật</a> của PhongTroVN247.
</div>

<script>
    function togglePw(id, btn) {
        const inp = document.getElementById(id);
        const icon = btn.querySelector('i');

        if (inp.type === 'password') {
            inp.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            inp.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>

@endsection