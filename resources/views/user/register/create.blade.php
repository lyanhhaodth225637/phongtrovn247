@extends('layouts.frontend.app')

@section('content')
  <style>
    /* ═══════════════════════════════════════════════════════════════
         XÁC THỰC EMAIL — page styles
         Dùng chung CSS variables từ home.css
      ═══════════════════════════════════════════════════════════════ */

    .verify-wrap {
      min-height: calc(100vh - 200px);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 16px 60px;
    }

    .verify-card {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: var(--radius);
      box-shadow: 0 8px 40px rgba(13, 110, 253, .10);
      width: 100%;
      max-width: 480px;
      overflow: hidden;
    }

    /* Card header */
    .verify-card-head {
      background: linear-gradient(135deg, #0f1e4a 0%, #0d6efd 100%);
      padding: 28px 28px 24px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .verify-card-head::before {
      content: '';
      position: absolute;
      top: -40px;
      right: -40px;
      width: 130px;
      height: 130px;
      background: rgba(255, 255, 255, .06);
      border-radius: 50%;
    }

    .verify-card-head::after {
      content: '';
      position: absolute;
      bottom: -30px;
      left: -30px;
      width: 90px;
      height: 90px;
      background: rgba(255, 255, 255, .04);
      border-radius: 50%;
    }

    .verify-card-icon {
      width: 56px;
      height: 56px;
      border-radius: 50%;
      background: rgba(255, 255, 255, .15);
      border: 2px solid rgba(255, 255, 255, .3);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: #fff;
      margin: 0 auto 12px;
      position: relative;
      z-index: 1;
    }

    .verify-card-head h2 {
      font-family: 'Sora', sans-serif;
      font-size: 1.15rem;
      font-weight: 800;
      color: #fff;
      margin: 0 0 4px;
      position: relative;
      z-index: 1;
    }

    .verify-card-head p {
      font-size: .78rem;
      color: rgba(255, 255, 255, .7);
      margin: 0;
      position: relative;
      z-index: 1;
    }

    /* Card body */
    .verify-card-body {
      padding: 24px 28px 28px;
    }

    /* Alert states */
    .verify-state {
      text-align: center;
      padding: 16px 0 8px;
    }

    .verify-state-icon {
      width: 72px;
      height: 72px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      margin: 0 auto 16px;
    }

    .verify-state-icon.success {
      background: #f0fdf4;
      color: #15803d;
    }

    .verify-state-icon.warning {
      background: #fffbeb;
      color: #d97706;
    }

    .verify-state-title {
      font-family: 'Sora', sans-serif;
      font-size: 1.05rem;
      font-weight: 800;
      color: var(--text);
      margin-bottom: 8px;
    }

    .verify-state-sub {
      font-size: .82rem;
      color: var(--muted);
      line-height: 1.75;
      margin-bottom: 20px;
    }

    .verify-state-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: .75rem;
      font-weight: 600;
      padding: 6px 14px;
      border-radius: 20px;
      margin-bottom: 20px;
    }

    .verify-state-badge.success {
      background: #f0fdf4;
      color: #15803d;
      border: 1px solid #bbf7d0;
    }

    .verify-state-badge.warning {
      background: #fffbeb;
      color: #92400e;
      border: 1px solid #fde68a;
    }

    /* Flash alerts */
    .verify-alert {
      display: flex;
      align-items: flex-start;
      gap: 9px;
      padding: 11px 14px;
      border-radius: var(--radius-sm);
      font-size: .8rem;
      font-weight: 500;
      margin-bottom: 16px;
      line-height: 1.5;
    }

    .verify-alert.success {
      background: #f0fdf4;
      color: #166534;
      border: 1px solid #bbf7d0;
    }

    .verify-alert.success i {
      color: #16a34a;
      margin-top: 1px;
      flex-shrink: 0;
    }

    .verify-alert.danger {
      background: #fff1f2;
      color: #9f1239;
      border: 1px solid #fecdd3;
    }

    .verify-alert.danger i {
      color: #e02424;
      margin-top: 1px;
      flex-shrink: 0;
    }

    /* Form fields */
    .verify-field {
      margin-bottom: 16px;
    }

    .verify-label {
      display: block;
      font-size: .75rem;
      font-weight: 700;
      color: var(--text2);
      margin-bottom: 6px;
      text-transform: uppercase;
      letter-spacing: .04em;
    }

    .verify-input-wrap {
      position: relative;
    }

    .verify-input-wrap i {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--muted);
      font-size: .9rem;
      pointer-events: none;
    }

    .verify-input {
      width: 100%;
      padding: 10px 12px 10px 36px;
      border: 1.5px solid var(--border);
      border-radius: var(--radius-sm);
      font-family: 'Be Vietnam Pro', sans-serif;
      font-size: .85rem;
      color: var(--text);
      background: var(--surface);
      transition: border-color .18s, box-shadow .18s;
      outline: none;
    }

    .verify-input:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(13, 110, 253, .1);
    }

    .verify-input::placeholder {
      color: #94a3b8;
    }

    .verify-input.is-invalid {
      border-color: #e02424;
    }

    .verify-input:read-only {
      background: #f8fafc;
      color: var(--muted);
      cursor: default;
    }

    .verify-invalid-feedback {
      font-size: .73rem;
      color: #e02424;
      margin-top: 4px;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    /* OTP row */
    .verify-otp-row {
      display: flex;
      gap: 8px;
      align-items: flex-start;
    }

    .verify-otp-row .verify-input-wrap {
      flex: 1;
    }

    .btn-send-otp {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 10px 14px;
      border-radius: var(--radius-sm);
      border: 1.5px solid var(--border);
      background: var(--surface);
      font-family: 'Be Vietnam Pro', sans-serif;
      font-size: .78rem;
      font-weight: 700;
      color: var(--primary);
      cursor: pointer;
      transition: background .15s, border-color .15s;
      white-space: nowrap;
      flex-shrink: 0;
    }

    .btn-send-otp:hover:not(:disabled) {
      background: var(--primary-light);
      border-color: var(--primary);
    }

    .btn-send-otp:disabled {
      color: var(--muted);
      border-color: var(--border);
      cursor: not-allowed;
      opacity: .7;
    }

    .otp-countdown {
      font-size: .72rem;
      color: #e02424;
      font-weight: 600;
      margin-top: 5px;
      display: flex;
      align-items: center;
      gap: 4px;
      min-height: 18px;
    }

    /* Submit btn */
    .btn-verify {
      width: 100%;
      padding: 12px;
      background: var(--primary);
      color: #fff;
      border: none;
      border-radius: var(--radius-sm);
      font-family: 'Be Vietnam Pro', sans-serif;
      font-size: .9rem;
      font-weight: 700;
      cursor: pointer;
      transition: background .18s, transform .1s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 8px;
    }

    .btn-verify:hover {
      background: var(--primary-dark);
      transform: translateY(-1px);
    }

    .btn-home {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 11px 24px;
      background: var(--primary);
      color: #fff;
      border-radius: var(--radius-sm);
      font-family: 'Be Vietnam Pro', sans-serif;
      font-weight: 700;
      font-size: .85rem;
      text-decoration: none;
      transition: background .18s;
    }

    .btn-home:hover {
      background: var(--primary-dark);
      color: #fff;
    }

    /* Divider */
    .verify-divider {
      border: none;
      border-top: 1px solid var(--border);
      margin: 20px 0;
    }

    /* Security note */
    .verify-security {
      display: flex;
      align-items: flex-start;
      gap: 8px;
      background: #fffbeb;
      border: 1px solid #fde68a;
      border-radius: var(--radius-sm);
      padding: 10px 13px;
      font-size: .75rem;
      color: #92400e;
      line-height: 1.6;
      margin-top: 16px;
    }

    .verify-security i {
      color: #d97706;
      flex-shrink: 0;
      margin-top: 1px;
    }

    @media (max-width: 480px) {
      .verify-card-body {
        padding: 20px 18px 24px;
      }

      .verify-card-head {
        padding: 22px 18px 20px;
      }

      .verify-otp-row {
        flex-direction: column;
      }

      .btn-send-otp {
        width: 100%;
        justify-content: center;
      }
    }
  </style>

  <div class="verify-wrap">
    <div class="verify-card">

      <div class="verify-card-head">
        <div class="verify-card-icon">
          <i class="bi bi-envelope-check"></i>
        </div>
        <h2>Xác thực Email</h2>
        <p>Bảo vệ tài khoản và nhận tin tức mới nhất từ PhongTroVN247</p>
      </div>

      <div class="verify-card-body">

        @if(session('success'))
          <div class="verify-alert success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
          </div>
        @endif
        @if(session('error'))
          <div class="verify-alert danger">
            <i class="bi bi-x-circle-fill"></i>
            {{ session('error') }}
          </div>
        @endif

        @php
          $user = auth()->user();
          $emailVerified = $user->hasVerifiedEmail();
          $isApproved = $user->hasRole('landlord');
        @endphp

        @if($emailVerified && $isApproved)
          <div class="verify-state">
            <div class="verify-state-icon success">
              <i class="bi bi-patch-check-fill"></i>
            </div>

            <div class="verify-state-badge success">
              <i class="bi bi-check-circle-fill"></i> Đã phê duyệt thành công
            </div>

            <div class="verify-state-title">
              Chúc mừng, tài khoản của bạn đã được kích hoạt!
            </div>

            <div class="verify-state-sub">
              Tài khoản chủ cho thuê của bạn đã được xác minh và phê duyệt thành công.<br>
              Giờ đây bạn đã có thể đăng tin, quản lý phòng trọ và sử dụng đầy đủ các tính năng trên PhongTroVN247.
            </div>

            <a href="{{ route('user.profile.index') }}" class="btn-home">
              <i class="bi bi-house-fill"></i> Về Trang Chủ
            </a>
          </div>

        @elseif($emailVerified && !$isApproved)
          <div class="verify-state">
            <div class="verify-state-icon warning">
              <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="verify-state-badge warning">
              <i class="bi bi-clock-fill"></i> Đang chờ phê duyệt
            </div>
            <div class="verify-state-title">Email đã xác thực thành công!</div>
            <div class="verify-state-sub">
              Tài khoản của bạn đang chờ quản trị viên kiểm tra và phê duyệt.<br>
              Quá trình này thường mất <strong>vài giờ làm việc</strong>.<br>
              Vui lòng kiểm tra email để nhận thông báo kết quả.
            </div>
            <div class="verify-security">
              <i class="bi bi-info-circle-fill"></i>
              Nếu cần hỗ trợ, hãy liên hệ hotline 1900 6868 hoặc gửi email tới
              support@phongtrovn247.com
            </div>
          </div>

        @else
          <form method="POST" action="{{ route('verify.email') }}">
            @csrf

            <div class="verify-field">
              <label class="verify-label">Số điện thoại</label>
              <div class="verify-input-wrap">
                <i class="bi bi-telephone"></i>
                <input type="text" class="verify-input" value="{{ $user->phone }}" readonly>
              </div>
            </div>

            <div class="verify-field">
              <label class="verify-label">Địa chỉ Email</label>
              <div class="verify-input-wrap">
                <i class="bi bi-envelope"></i>
                <input type="email" name="email" class="verify-input @error('email') is-invalid @enderror"
                  value="{{ $user->email }}" {{ $user->email ? 'readonly' : 'required' }}
                  placeholder="Nhập email để xác thực">
              </div>
              @error('email')
                <div class="verify-invalid-feedback">
                  <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                </div>
              @enderror
            </div>

            <div class="verify-field">
              <label class="verify-label">Mã OTP</label>
              <div class="verify-otp-row">
                <div class="verify-input-wrap">
                  <i class="bi bi-shield-lock"></i>
                  <input type="text" name="otp" class="verify-input @error('otp') is-invalid @enderror"
                    placeholder="Nhập mã OTP 6 chữ số" maxlength="6" inputmode="numeric" autocomplete="one-time-code">
                </div>
                <button type="button" id="sendOtpBtn" class="btn-send-otp">
                  <i class="bi bi-send"></i> Gửi OTP
                </button>
              </div>
              <div class="otp-countdown" id="countdown"></div>
              @error('otp')
                <div class="verify-invalid-feedback">
                  <i class="bi bi-exclamation-circle-fill"></i> {{ $message }}
                </div>
              @enderror
            </div>

            <hr class="verify-divider">

            <button type="submit" class="btn-verify">
              <i class="bi bi-check2-circle"></i> Xác thực ngay
            </button>
          </form>

          <div class="verify-security">
            <i class="bi bi-shield-check"></i>
            Mã OTP có hiệu lực trong <strong>5 phút</strong>. Nếu không nhận được, hãy kiểm tra hộp thư rác hoặc gửi lại.
          </div>
        @endif

      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      let timeLeft = 0;
      let timer;

      const btn = document.getElementById('sendOtpBtn');
      const countdownEl = document.getElementById('countdown');
      if (!btn) return;

      btn.addEventListener('click', () => {
        const emailInput = document.querySelector('input[name="email"]');
        const email = emailInput?.value.trim();

        if (!email) {
          emailInput?.focus();
          showCountdown('Vui lòng nhập email trước!', true);
          return;
        }
        if (!/^\S+@\S+\.\S+$/.test(email)) {
          emailInput?.focus();
          showCountdown('Email không hợp lệ!', true);
          return;
        }
        if (timeLeft > 0) return;

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Đang gửi...';

        fetch("{{ route('verify.send.otp') }}", {
          method: 'POST',
          headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          body: new URLSearchParams({ email })
        })
          .then(res => res.json())
          .then(() => {
            btn.innerHTML = '<i class="bi bi-check2"></i> Đã gửi';
            timeLeft = 300;
            timer = setInterval(() => {
              timeLeft--;
              const m = String(Math.floor(timeLeft / 60)).padStart(2, '0');
              const s = String(timeLeft % 60).padStart(2, '0');
              countdownEl.innerHTML = `<i class="bi bi-clock"></i> Gửi lại sau ${m}:${s}`;
              if (timeLeft <= 0) {
                clearInterval(timer);
                countdownEl.innerHTML = '';
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-send"></i> Gửi OTP';
              }
            }, 1000);
          })
          .catch(() => {
            countdownEl.innerHTML = '<i class="bi bi-exclamation-circle"></i> Có lỗi, vui lòng thử lại!';
            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-send"></i> Gửi OTP';
          });
      });

      function showCountdown(msg, isError) {
        countdownEl.style.color = isError ? '#e02424' : '';
        countdownEl.innerHTML = msg;
        setTimeout(() => { countdownEl.innerHTML = ''; }, 3000);
      }
    });
  </script>

@endsection