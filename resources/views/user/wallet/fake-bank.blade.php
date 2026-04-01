<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;600&display=swap"
        rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: #0a0f1e;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animated background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(ellipse 80% 60% at 20% 20%, rgba(0, 102, 204, 0.15) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 80%, rgba(0, 168, 107, 0.10) 0%, transparent 60%),
                repeating-linear-gradient(0deg, transparent, transparent 60px, rgba(255, 255, 255, 0.015) 60px, rgba(255, 255, 255, 0.015) 61px),
                repeating-linear-gradient(90deg, transparent, transparent 60px, rgba(255, 255, 255, 0.015) 60px, rgba(255, 255, 255, 0.015) 61px);
            pointer-events: none;
            z-index: 0;
        }

        .page-wrapper {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Top bar */
        .bank-topbar {
            background: rgba(10, 15, 30, 0.95);
            border-bottom: 1px solid rgba(0, 102, 204, 0.3);
            padding: 12px 0;
            backdrop-filter: blur(20px);
        }

        .bank-topbar .logo-text {
            font-size: 20px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .bank-topbar .logo-text span {
            color: #0066cc;
        }

        .secure-badge {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #00a86b;
            font-weight: 500;
        }

        .secure-badge::before {
            content: '';
            width: 8px;
            height: 8px;
            background: #00a86b;
            border-radius: 50%;
            animation: pulse-green 2s infinite;
        }

        @keyframes pulse-green {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(0, 168, 107, 0.4);
            }

            50% {
                box-shadow: 0 0 0 6px rgba(0, 168, 107, 0);
            }
        }

        /* SSL bar */
        .ssl-bar {
            background: linear-gradient(90deg, #003d7a 0%, #0055a8 50%, #003d7a 100%);
            padding: 7px 0;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            letter-spacing: 0.3px;
        }

        .ssl-bar strong {
            color: #fff;
        }

        /* Main content */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 16px;
        }

        .transaction-card {
            width: 100%;
            max-width: 520px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.10);
            border-radius: 20px;
            overflow: hidden;
            backdrop-filter: blur(30px);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(0, 102, 204, 0.15);
            animation: slideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card header */
        .card-header-bank {
            background: linear-gradient(135deg, #0047a0 0%, #0066cc 60%, #0080ff 100%);
            padding: 28px 32px 24px;
            position: relative;
            overflow: hidden;
        }

        .card-header-bank::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
        }

        .card-header-bank::before {
            content: '';
            position: absolute;
            bottom: -30%;
            right: 10%;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
        }

        .header-title {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 500;
            margin-bottom: 6px;
            position: relative;
            z-index: 1;
        }

        .header-amount {
            font-size: 40px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -1px;
            line-height: 1;
            position: relative;
            z-index: 1;
        }

        .header-amount .currency {
            font-size: 18px;
            font-weight: 500;
            vertical-align: super;
            margin-right: 4px;
            color: rgba(255, 255, 255, 0.8);
        }

        .tx-code {
            margin-top: 16px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            padding: 6px 14px;
            position: relative;
            z-index: 1;
        }

        .tx-code .label {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .tx-code .code {
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            color: #fff;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Status badge */
        .status-row {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-top: 14px;
            position: relative;
            z-index: 1;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            background: rgba(255, 190, 0, 0.2);
            border: 1px solid rgba(255, 190, 0, 0.4);
            color: #ffbe00;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #ffbe00;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }
        }

        /* Card body */
        .card-body-bank {
            padding: 28px 32px;
        }

        .info-section-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.35);
            font-weight: 600;
            margin-bottom: 16px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 13px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            gap: 16px;
            animation: fadeIn 0.4s ease forwards;
            opacity: 0;
        }

        .info-row:nth-child(1) {
            animation-delay: 0.1s;
        }

        .info-row:nth-child(2) {
            animation-delay: 0.15s;
        }

        .info-row:nth-child(3) {
            animation-delay: 0.2s;
        }

        .info-row:nth-child(4) {
            animation-delay: 0.25s;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.45);
            font-weight: 400;
            white-space: nowrap;
        }

        .info-value {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            text-align: right;
        }

        .info-value.mono {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            color: #60a5fa;
            letter-spacing: 0.5px;
        }

        .info-value.transfer-content {
            font-size: 12px;
            color: #a78bfa;
            font-weight: 600;
            font-family: 'JetBrains Mono', monospace;
            letter-spacing: 0.3px;
        }

        /* Divider */
        .card-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.08), transparent);
            margin: 4px 32px;
        }

        /* Warning box */
        .warning-box {
            margin: 0 32px 24px;
            background: rgba(255, 190, 0, 0.07);
            border: 1px solid rgba(255, 190, 0, 0.2);
            border-radius: 10px;
            padding: 14px 16px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .warning-icon {
            font-size: 18px;
            line-height: 1;
            flex-shrink: 0;
        }

        .warning-text {
            font-size: 12px;
            color: rgba(255, 190, 0, 0.85);
            line-height: 1.6;
        }

        /* Action buttons */
        .card-actions {
            padding: 0 32px 32px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn-confirm {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.3px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #0066cc 0%, #0080ff 100%);
            color: #fff;
            box-shadow: 0 4px 20px rgba(0, 102, 204, 0.4);
        }

        .btn-confirm::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.4s ease;
        }

        .btn-confirm:hover::before {
            left: 100%;
        }

        .btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 102, 204, 0.55);
        }

        .btn-confirm:active {
            transform: translateY(0);
        }

        .btn-cancel {
            width: 100%;
            padding: 14px;
            border: 1px solid rgba(255, 80, 80, 0.35);
            border-radius: 12px;
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            background: rgba(255, 80, 80, 0.07);
            color: rgba(255, 120, 120, 0.9);
        }

        .btn-cancel:hover {
            background: rgba(255, 80, 80, 0.14);
            border-color: rgba(255, 80, 80, 0.5);
            color: #ff8080;
            transform: translateY(-1px);
        }

        /* Footer */
        .bank-footer {
            background: rgba(10, 15, 30, 0.8);
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            padding: 16px 0;
            text-align: center;
        }

        .footer-logos {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 8px;
        }

        .footer-badge {
            padding: 4px 12px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 20px;
            font-size: 10px;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .footer-text {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.25);
        }

        /* Countdown */
        .countdown-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin: 0 32px 20px;
            padding: 10px 16px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 10px;
        }

        .countdown-label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.35);
        }

        .countdown-timer {
            font-family: 'JetBrains Mono', monospace;
            font-size: 14px;
            font-weight: 600;
            color: #ffbe00;
        }

        .progress-bar-track {
            height: 3px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 2px;
            margin: 8px 32px 0;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #0066cc, #00a86b);
            border-radius: 2px;
            animation: shrink 300s linear forwards;
            width: 100%;
        }

        @keyframes shrink {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">



        <!-- Main -->
        <div class="main-content">
            <div class="transaction-card">

                <!-- Card Header -->
                <div class="card-header-bank">
                    <div class="header-title">Xác nhận chuyển khoản</div>
                    <div class="header-amount">
                        <span class="currency">VNĐ</span>{{ number_format($transaction->amount) }}
                    </div>
                    <div class="tx-code">
                        <span class="label">Mã GD</span>
                        <span class="code">{{ $transaction->transaction_code }}</span>
                    </div>
                    <div class="status-row">
                        <div class="status-badge">
                            <div class="status-dot"></div>
                            Chờ xác nhận
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body-bank">
                    <div class="info-section-title">Thông tin giao dịch</div>

                    <div class="info-row">
                        <span class="info-label">Ngân hàng</span>
                        <span class="info-value">{{ $transaction->bank_name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Chủ tài khoản</span>
                        <span class="info-value">{{ $transaction->bank_account_name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Số tài khoản</span>
                        <span class="info-value mono">{{ $transaction->bank_account_number }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nội dung CK</span>
                        <span class="info-value transfer-content">{{ $transaction->transfer_content }}</span>
                    </div>
                </div>

                <div class="card-divider"></div>

                
                <div class="progress-bar-track">
                    <div class="progress-bar-fill"></div>
                </div>

                <!-- Warning -->
                <div class="warning-box" style="margin-top:20px;">
                    <div class="warning-icon">⚠️</div>
                    <div class="warning-text">Vui lòng kiểm tra kỹ thông tin trước khi xác nhận. Giao dịch sau khi hoàn
                        tất không thể hoàn tác.</div>
                </div>

                <!-- Actions -->
                <div class="card-actions">

                    <form action="{{ route('user.wallet.fake.confirm', $transaction->id) }}" method="POST">
                        @csrf
                        <!-- thêm modal xác nhân  -->
                        <button type="submit" class="btn-confirm">✓ &nbsp; Xác nhận giao dịch</button>
                    </form>

                    <form action="{{ route('user.wallet.fake.cancel', $transaction->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-cancel">Hủy giao dịch</button>
                    </form>

                   
                </div>

            </div>
        </div>



    </div>


</body>

</html>