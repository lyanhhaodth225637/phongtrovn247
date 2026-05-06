@extends('layouts.user.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">CÃƒÂ¡Ã‚Â»Ã¢â‚¬Â¢ng thanh toÃƒÆ’Ã‚Â¡n giÃƒÂ¡Ã‚ÂºÃ‚Â£ lÃƒÂ¡Ã‚ÂºÃ‚Â­p</h4>
        </div>

        <div class="card-body">
            <p><strong>MÃƒÆ’Ã‚Â£ giao dÃƒÂ¡Ã‚Â»Ã¢â‚¬Â¹ch:</strong> {{ $transaction->transaction_code }}</p>
            <p><strong>SÃƒÂ¡Ã‚Â»Ã¢â‚¬Ëœ tiÃƒÂ¡Ã‚Â»Ã‚Ân:</strong> {{ number_format($transaction->amount, 0, ',', '.') }} Ãƒâ€žÃ¢â‚¬Ëœ</p>
            <p><strong>PhÃƒâ€ Ã‚Â°Ãƒâ€ Ã‚Â¡ng thÃƒÂ¡Ã‚Â»Ã‚Â©c:</strong> VNPAY giÃƒÂ¡Ã‚ÂºÃ‚Â£ lÃƒÂ¡Ã‚ÂºÃ‚Â­p</p>
            <p><strong>TrÃƒÂ¡Ã‚ÂºÃ‚Â¡ng thÃƒÆ’Ã‚Â¡i:</strong> {{ $transaction->status }}</p>

            <hr>

            <div class="d-flex gap-2 flex-wrap">
                <form action="{{ route('user.wallet.fake.success', $transaction->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Thanh toÃƒÆ’Ã‚Â¡n thÃƒÆ’Ã‚Â nh cÃƒÆ’Ã‚Â´ng</button>
                </form>

                <form action="{{ route('user.wallet.fake.failed', $transaction->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Thanh toÃƒÆ’Ã‚Â¡n thÃƒÂ¡Ã‚ÂºÃ‚Â¥t bÃƒÂ¡Ã‚ÂºÃ‚Â¡i</button>
                </form>

                <form action="{{ route('user.wallet.fake.cancel', $transaction->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-secondary">HÃƒÂ¡Ã‚Â»Ã‚Â§y giao dÃƒÂ¡Ã‚Â»Ã¢â‚¬Â¹ch</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
