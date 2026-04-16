@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid py-3">

        {{-- Topbar --}}
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap: 8px">
            <div>
                <h1 class="h4 mb-0 text-gray-800 font-weight-bold">
                    <i class="fas fa-file-invoice-dollar text-primary mr-2"></i>
                    Chi tiết thông báo nạp tiền
                </h1>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: .8rem">
                        <li class="breadcrumb-item">
                            <a href="#">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.wallet_notifications.index') }}">
                                Thông báo nạp tiền
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            #{{ $notification->id }}
                        </li>
                    </ol>
                </nav>
            </div>

            <a href="{{ route('admin.wallet_notifications.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left mr-1"></i> Quay lại
            </a>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle mr-1"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle mr-1"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <div class="row">

            {{-- Thông tin người nạp --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-user mr-1"></i> Thông tin người nạp
                        </h6>
                    </div>

                    <div class="card-body">

                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white font-weight-bold mr-3"
                                style="width: 42px; height: 42px; font-size: .85rem; flex-shrink: 0;">
                                {{ strtoupper(substr($notification->walletTransaction?->user?->name ?? 'N', 0, 1)) }}
                            </div>

                            <div>
                                <div class="font-weight-bold">
                                    {{ $notification->walletTransaction?->user?->name ?? 'N/A' }}
                                </div>

                                <div class="text-muted" style="font-size: .8rem">
                                    {{ $notification->walletTransaction?->user?->email ?? '' }}
                                </div>
                            </div>
                        </div>

                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="width:45%">ID thông báo</td>
                                    <td class="font-weight-bold">#{{ $notification->id }}</td>
                                </tr>

                                <tr>
                                    <td class="text-muted">ID giao dịch</td>
                                    <td>{{ $notification->walletTransaction?->id ?? 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <td class="text-muted">Mã giao dịch</td>
                                    <td>
                                        <code class="text-primary bg-light px-1 rounded">
                                                {{ $notification->walletTransaction?->transaction_code ?? 'N/A' }}
                                            </code>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-muted">Số tiền nạp</td>
                                    <td class="font-weight-bold text-primary">
                                        {{ number_format((int) $notification->amount, 0, ',', '.') }} đ
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-muted">Nội dung chuyển khoản</td>
                                    <td>
                                        <code class="text-info bg-light px-1 rounded">
                                                {{ $notification->transfer_content ?? 'N/A' }}
                                            </code>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-muted">Trạng thái giao dịch</td>
                                    <td>
                                        @if($notification->walletTransaction && $notification->walletTransaction->status === 'pending')
                                            <span class="badge badge-secondary badge-pill">
                                                Chờ xác nhận
                                            </span>
                                        @elseif($notification->walletTransaction && $notification->walletTransaction->status === 'processing')
                                            <span class="badge badge-warning badge-pill">
                                                Chờ admin duyệt
                                            </span>
                                        @elseif($notification->walletTransaction && $notification->walletTransaction->status === 'success')
                                            <span class="badge badge-success badge-pill">
                                                Thành công
                                            </span>
                                        @elseif($notification->walletTransaction && $notification->walletTransaction->status === 'failed')
                                            <span class="badge badge-danger badge-pill">
                                                Thất bại
                                            </span>
                                        @elseif($notification->walletTransaction && $notification->walletTransaction->status === 'cancelled')
                                            <span class="badge badge-dark badge-pill">
                                                Đã hủy
                                            </span>
                                        @else
                                            <span class="badge badge-secondary badge-pill">
                                                N/A
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-muted">Trạng thái đối soát</td>
                                    <td>
                                        @if($notification->match_status === 'unmatched')
                                            <span class="badge badge-secondary badge-pill">
                                                <i class="fas fa-question-circle mr-1" style="font-size:.65rem"></i>
                                                Chưa khớp
                                            </span>
                                        @elseif($notification->match_status === 'matched')
                                            <span class="badge badge-warning badge-pill">
                                                <i class="fas fa-link mr-1" style="font-size:.65rem"></i>
                                                Đã khớp, chờ duyệt
                                            </span>
                                        @elseif($notification->match_status === 'approved')
                                            <span class="badge badge-success badge-pill">
                                                <i class="fas fa-check-circle mr-1" style="font-size:.65rem"></i>
                                                Đã duyệt
                                            </span>
                                        @elseif($notification->match_status === 'rejected')
                                            <span class="badge badge-danger badge-pill">
                                                <i class="fas fa-times-circle mr-1" style="font-size:.65rem"></i>
                                                Từ chối
                                            </span>
                                        @else
                                            <span class="badge badge-secondary badge-pill">
                                                {{ $notification->match_status }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-muted">Thời gian báo</td>
                                    <td>
                                        {{ optional($notification->created_at)->format('d/m/Y H:i:s') ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-muted">Người xử lý</td>
                                    <td>
                                        {{ $notification->handler->name ?? 'Chưa có' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Biến động ví hệ thống --}}
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-university mr-1"></i> Biến động số dư ví hệ thống
                        </h6>
                    </div>

                    <div class="card-body">
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="width:45%">Tên ví</td>
                                    <td class="font-weight-bold">
                                        {{ $notification->systemWallet?->name ?? 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-muted">Ngân hàng</td>
                                    <td>
                                        {{ $notification->bank_name ?? ($notification->systemWallet?->bank_name ?? 'N/A') }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-muted">Tài khoản nhận</td>
                                    <td>
                                        <code class="text-primary bg-light px-1 rounded">
                                                {{ $notification->receiver_account_number ?? ($notification->systemWallet?->account_number ?? 'N/A') }}
                                            </code>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <hr class="my-3">

                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="width:45%">Số tiền biến động</td>
                                    <td class="font-weight-bold text-success">
                                        +{{ number_format((int) $notification->amount, 0, ',', '.') }} đ
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-muted">Số dư hiện tại</td>
                                    <td class="font-weight-bold text-primary">
                                        @if(isset($notification->systemWallet?->balance))
                                            {{ number_format((int) $notification->systemWallet->balance, 0, ',', '.') }} đ
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-3">
                            <p class="text-muted mb-1"
                                style="font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:.4px">
                                Nội dung raw message
                            </p>

                            <div class="bg-light border rounded p-2"
                                style="font-family:monospace;font-size:.8rem;white-space:normal;word-break:break-word;color:#5a5c69">
                                {{ trim(($notification->raw_message ?? 'Không có dữ liệu') . ' tại thời điểm ' . optional($notification->created_at)->format('d/m/Y H:i:s')) }}
                            </div>
                        </div>

                        @if(!empty($notification->admin_note))
                            <div class="mt-3">
                                <p class="text-muted mb-1"
                                    style="font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:.4px">
                                    Ghi chú admin
                                </p>

                                <div class="bg-light border rounded p-2" style="font-size:.85rem">
                                    {{ $notification->admin_note }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Khối duyệt / từ chối --}}
        @if(
                in_array($notification->match_status, ['matched', 'unmatched']) &&
                $notification->walletTransaction &&
                in_array($notification->walletTransaction->status, ['processing', 'pending'])
            )
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-gavel mr-1"></i> Thao tác kiểm duyệt
                    </h6>
                </div>

                <div class="card-body">
                    <div class="alert alert-info shadow-sm">
                        <i class="fas fa-info-circle mr-1"></i>
                        Duyệt sẽ cộng
                        <strong>{{ number_format((int) $notification->amount, 0, ',', '.') }} đ</strong>
                        vào ví của người dùng
                        <strong>{{ $notification->walletTransaction?->user?->name ?? 'N/A' }}</strong>.
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3 mb-md-0 d-flex align-items-end">
                            <form action="{{ route('admin.wallet_notifications.approve', $notification->id) }}" method="POST"
                                class="w-100">
                                @csrf

                                <button type="submit" class="btn btn-success btn-block font-weight-bold"
                                    onclick="return confirm('Xác nhận duyệt giao dịch này và cộng tiền cho người dùng?')">
                                    <i class="fas fa-check mr-1"></i>
                                    Duyệt và cộng tiền
                                </button>
                            </form>
                        </div>

                        <div class="col-md-7">
                            <form action="{{ route('admin.wallet_notifications.reject', $notification->id) }}" method="POST">
                                @csrf

                                <div class="form-group mb-2">
                                    <label class="text-muted"
                                        style="font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:.4px">
                                        Lý do từ chối
                                    </label>

                                    <textarea name="admin_note" rows="3"
                                        class="form-control form-control-sm @error('admin_note') is-invalid @enderror"
                                        placeholder="Nhập lý do từ chối..." required>{{ old('admin_note') }}</textarea>

                                    @error('admin_note')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-danger btn-block font-weight-bold"
                                    onclick="return confirm('Xác nhận từ chối giao dịch này?')">
                                    <i class="fas fa-times mr-1"></i>
                                    Từ chối giao dịch
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection