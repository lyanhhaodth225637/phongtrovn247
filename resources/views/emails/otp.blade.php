<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=Sora:wght@700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #0d6efd;
            --primary-dark: #0b5ed7;
            --primary-light: #e8f0fe;
            --gold: #f59e0b;
            --bg: #f4f6fb;
            --surface: #ffffff;
            --surface2: #f8faff;
            --text: #0f172a;
            --text2: #334155;
            --muted: #64748b;
            --border: #e2e8f0;
            --radius: 12px;
            --shadow: 0 4px 20px rgba(13, 110, 253, .12);
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
            color: var(--text);
            font-size: 14px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .wrapper {
            max-width: 480px;
            margin: 40px auto;
            padding: 0 16px;
        }

        /* Card */
        .card {
            background: var(--surface);
            border-radius: var(--radius);
            border: 1.5px solid var(--border);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        /* Header */
        .card-header {
            background: linear-gradient(135deg, #0f1e4a 0%, #0d2b6e 45%, #0d6efd 100%);
            padding: 24px 32px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(255, 255, 255, .04) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(255, 255, 255, .05) 0%, transparent 50%);
            pointer-events: none;
        }

        .card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .logo {
            font-family: 'Sora', sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
            display: block;
            margin-bottom: 3px;
            position: relative;
        }

        .logo span {
            color: var(--gold);
        }

        .logo-sub {
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .55);
            position: relative;
        }

        /* Body */
        .card-body {
            padding: 32px 32px 28px;
            text-align: center;
        }

        .otp-label {
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 14px;
        }

        .otp-code {
            display: inline-block;
            font-family: 'Sora', sans-serif;
            font-size: 38px;
            font-weight: 800;
            letter-spacing: 12px;
            color: var(--text);
            background: var(--bg);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 28px 16px 40px;
            margin-bottom: 18px;
            line-height: 1;
        }

        .otp-notice {
            font-size: 0.8rem;
            color: var(--muted);
            line-height: 1.7;
        }

        .otp-notice strong {
            color: var(--text);
            font-weight: 700;
        }

        .expire-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin-top: 16px;
            font-size: 0.75rem;
            color: var(--muted);
            font-weight: 500;
        }

        .expire-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--gold);
            flex-shrink: 0;
        }

        .expire-bar strong {
            color: var(--text);
            font-weight: 700;
            margin-left: 2px;
        }

        /* Footer */
        .card-footer {
            border-top: 1.5px solid var(--bg);
            padding: 14px 32px;
            text-align: center;
            font-size: 0.72rem;
            color: #94a3b8;
            line-height: 1.7;
            background: var(--surface2);
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="card">
            <div class="card-header">
                <span class="logo">PhongTro<span>VN</span>247</span>
                <span class="logo-sub">Xác thực tài khoản</span>
            </div>
            <div class="card-body">
                <div class="otp-label">Mã OTP của bạn</div>
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-notice">
                    Nhập mã này để xác thực.<br>
                    <strong>Không chia sẻ mã với bất kỳ ai.</strong>
                </div>
                <div class="expire-bar">
                    <span class="expire-dot"></span>
                    Mã có hiệu lực trong <strong>5 phút</strong>
                </div>
            </div>
            <div class="card-footer">
                Nếu bạn không yêu cầu mã này, hãy bỏ qua email này.<br>
                Hệ thống tự động gửi — vui lòng không phản hồi.
            </div>
        </div>
    </div>
</body>

</html>