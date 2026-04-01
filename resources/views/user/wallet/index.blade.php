@extends('layouts.user.app')

@section('content')
    <style>
        .wallet-wrap {
            /* max-width: 480px; */
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .wallet-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #111;
        }

        .balance-card {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .balance-icon {
            width: 44px;
            height: 44px;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .balance-icon svg {
            width: 20px;
            height: 20px;
            stroke: #6c757d;
            fill: none;
            stroke-width: 1.5;
        }

        .balance-meta {
            flex: 1;
        }

        .balance-label {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 4px;
        }

        .balance-amount {
            font-size: 22px;
            font-weight: 700;
            color: #111;
            letter-spacing: -0.5px;
        }

        .balance-badge {
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 999px;
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            white-space: nowrap;
        }

        .deposit-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 1.5rem;
        }

        .deposit-card h5 {
            font-size: 15px;
            font-weight: 600;
            color: #111;
            margin-bottom: 1.25rem;
        }

        .field-label {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 8px;
            display: block;
        }

        .preset-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 1.25rem;
        }

        .preset-btn {
            font-size: 12px;
            padding: 6px 14px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
            background: transparent;
            color: #495057;
            cursor: pointer;
            transition: all .15s;
        }

        .preset-btn:hover {
            background: #f1f3f5;
            border-color: #adb5bd;
            color: #111;
        }

        .preset-btn.active {
            background: #f1f3f5;
            border-color: #495057;
            color: #111;
        }

        .divider {
            border: none;
            border-top: 1px solid #f1f3f5;
            margin: 1.25rem 0;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap input {
            width: 100%;
            padding: 10px 40px 10px 12px;
            font-size: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: #fff;
            color: #111;
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }

        .input-wrap input:focus {
            border-color: #495057;
            box-shadow: 0 0 0 3px rgba(73, 80, 87, .08);
        }

        .input-unit {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 13px;
            color: #adb5bd;
            pointer-events: none;
        }

        .input-hint {
            font-size: 12px;
            color: #adb5bd;
            margin-top: 6px;
        }

        .btn-deposit {
            margin-top: 1.25rem;
            width: 100%;
            padding: 11px 16px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            background: #111;
            color: #fff;
            cursor: pointer;
            transition: background .15s;
        }

        .btn-deposit:hover {
            background: #333;
        }
    </style>

    <div class="wallet-wrap">
        <div class="wallet-title">Ví tiền của tôi</div>

        {{-- Thẻ số dư --}}
        <div class="balance-card">
            <!-- <div class="balance-icon">
                <svg viewBox="0 0 24 24">
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <path d="M16 12h2" />
                </svg>
            </div> -->
            <div class="balance-meta">
                <div class="balance-label">Số dư hiện tại</div>
                <div class="balance-amount">{{ number_format(auth()->user()->balance ?? 0, 0, ',', '.') }} đ</div>
            </div>
            <!-- <div class="balance-badge">Hoạt động</div> -->
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mb-3">{{ session('error') }}</div>
        @endif

        {{-- Form nạp tiền --}}
        <div class="deposit-card">
            <h5>Nạp tiền</h5>

            <span class="field-label">Chọn nhanh</span>
            <div class="preset-grid">
                <button type="button" class="preset-btn" onclick="pickAmount(50000, this)">50.000đ</button>
                <button type="button" class="preset-btn" onclick="pickAmount(100000, this)">100.000đ</button>
                <button type="button" class="preset-btn" onclick="pickAmount(200000, this)">200.000đ</button>
                <button type="button" class="preset-btn" onclick="pickAmount(500000, this)">500.000đ</button>
                <button type="button" class="preset-btn" onclick="pickAmount(1000000, this)">1.000.000đ</button>
            </div>

            <hr class="divider">

            <form action="{{ route('user.wallet.deposit.store') }}" method="POST">
                @csrf

                <span class="field-label">Hoặc nhập số tiền khác</span>
                <div class="input-wrap">
                    <input type="number" id="amountInput" name="amount" min="10000" step="1000" placeholder="100000"
                        value="{{ old('amount') }}" required oninput="clearPresets()">
                    <span class="input-unit">đ</span>
                </div>
                <div class="input-hint">Tối thiểu 10.000đ · Bội số 1.000đ</div>

                @error('amount')
                    <div class="text-danger mt-1" style="font-size:13px">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn-deposit">Tiếp tục →</button>
            </form>
        </div>
    </div>

    <script>
        function pickAmount(val, btn) {
            document.getElementById('amountInput').value = val;
            document.querySelectorAll('.preset-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }
        function clearPresets() {
            document.querySelectorAll('.preset-btn').forEach(b => b.classList.remove('active'));
        }
    </script>
@endsection