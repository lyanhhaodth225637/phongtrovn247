@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-university mr-2 text-primary"></i>
                Ví hệ thống
            </h1>

            <a href="" class="btn btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50 mr-1"></i>
                Chỉnh sửa
            </a>
        </div>

        <div class="row">

            {{-- Thông tin chính --}}
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4 border-left-primary">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Thông tin ví nhận tiền
                        </h6>

                        @if($wallet->is_active)
                            <span class="badge badge-success px-3 py-2">
                                <i class="fas fa-check-circle mr-1"></i> Đang hoạt động
                            </span>
                        @else
                            <span class="badge badge-secondary px-3 py-2">
                                <i class="fas fa-times-circle mr-1"></i> Ngừng hoạt động
                            </span>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">

                            <div class="col-md-6 mb-3">
                                <label class="small text-muted mb-1">Tên ví</label>
                                <div class="h5 text-dark mb-0">
                                    {{ $wallet->name }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="small text-muted mb-1">Ngân hàng</label>
                                <div class="h5 text-dark mb-0">
                                    {{ $wallet->bank_name }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="small text-muted mb-1">Chủ tài khoản</label>
                                <div class="h5 text-dark mb-0">
                                    {{ $wallet->account_name }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="small text-muted mb-1">Số tài khoản</label>
                                <div class="h4 font-weight-bold text-primary mb-0">
                                    {{ $wallet->account_number }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="small text-muted mb-1">Số dư hiện tại</label>
                                <div class="h3 font-weight-bold text-success mb-0">
                                    {{ number_format($wallet->balance ?? 0, 0, ',', '.') }} đ
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Thống kê nhanh --}}
            <div class="col-xl-4 col-lg-5">

                <div class="card shadow mb-4 border-left-success">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Tổng số dư ví
                        </div>

                        <div class="h2 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($wallet->balance ?? 0, 0, ',', '.') }} đ
                        </div>
                    </div>
                </div>

                <div class="card shadow mb-4 border-left-info">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Trạng thái
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $wallet->is_active ? 'Đang sử dụng' : 'Đã tắt' }}
                        </div>
                    </div>
                </div>

                <div class="card shadow border-left-warning">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Cập nhật lần cuối
                        </div>

                        <div class="h6 mb-0 text-gray-800">
                            {{ $wallet->updated_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection