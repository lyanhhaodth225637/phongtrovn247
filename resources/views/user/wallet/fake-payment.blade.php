@extends('layouts.user.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Cổng thanh toán giả lập</h4>
        </div>

        <div class="card-body">
            <p><strong>Mã giao dịch:</strong> {{ $transaction->transaction_code }}</p>
            <p><strong>Số tiền:</strong> {{ number_format($transaction->amount, 0, ',', '.') }} đ</p>
            <p><strong>Phương thức:</strong> VNPAY giả lập</p>
            <p><strong>Trạng thái:</strong> {{ $transaction->status }}</p>

            <hr>

            <div class="d-flex gap-2 flex-wrap">
                <form action="{{ route('user.wallet.fake.success', $transaction->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Thanh toán thành công</button>
                </form>

                <form action="{{ route('user.wallet.fake.failed', $transaction->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Thanh toán thất bại</button>
                </form>

                <form action="{{ route('user.wallet.fake.cancel', $transaction->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Hủy giao dịch</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection