<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f4f5;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .wrapper {
            max-width: 480px;
            margin: 40px auto;
            padding: 0 16px;
        }

        .card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e4e4e7;
            overflow: hidden;
        }

        .card-header {
            background: #111;
            padding: 28px 32px 24px;
            text-align: center;
        }

        .card-header .logo {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #a1a1aa;
        }

        .card-body {
            padding: 36px 32px 32px;
            text-align: center;
        }

        .otp-label {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #71717a;
            margin-bottom: 16px;
        }

        .otp-code {
            display: inline-block;
            font-size: 40px;
            font-weight: 700;
            letter-spacing: 10px;
            color: #111;
            background: #f4f4f5;
            border: 1px solid #e4e4e7;
            border-radius: 10px;
            padding: 16px 28px 16px 38px;
            margin-bottom: 20px;
            line-height: 1;
        }

        .otp-notice {
            font-size: 13px;
            color: #71717a;
            line-height: 1.6;
        }

        .otp-notice strong {
            color: #111;
        }

        .expire-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 20px;
            font-size: 12px;
            color: #71717a;
        }

        .expire-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #f59e0b;
            flex-shrink: 0;
        }

        .card-footer {
            border-top: 1px solid #f4f4f5;
            padding: 16px 32px;
            text-align: center;
            font-size: 11px;
            color: #a1a1aa;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="card">
            <div class="card-header">
                <div class="logo">Xác thực tài khoản</div>
            </div>
            <div class="card-body">
                <div class="otp-label">Mã OTP của bạn</div>
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-notice">
                    Nhập mã này để xác thực. <strong>Không chia sẻ mã với bất kỳ ai.</strong>
                </div>
                <div class="expire-bar">
                    <span class="expire-dot"></span>
                    Mã có hiệu lực trong <strong style="color:#111;margin-left:3px">5 phút</strong>
                </div>
            </div>
            <div class="card-footer">
                Nếu bạn không yêu cầu mã này, hãy bỏ qua email này.<br>
                Hệ thống tự động gửi, vui lòng không phản hồi.
            </div>
        </div>
    </div>
</body>

</html>