@extends('layouts.user.app')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-award-fill text-warning"></i>
                Gói thành viên
            </h2>
        </div>

        {{-- Gói đang sử dụng --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-primary text-white rounded-top-4 py-3">
                <h5 class="mb-0">
                    <i class="bi bi-stars me-2"></i>
                    Gói đang sử dụng
                </h5>
            </div>

            <div class="card-body">
                @if ($currentMembership)
                        @php
                            $membership = $currentMembership->membershipPackage->membership;
                            $package = $currentMembership->membershipPackage;
                        @endphp

                        <div class="row align-items-center">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="
                                                            width: 60px;
                                                            height: 60px;
                                                            background: {{ $membership->color ?? '#0d6efd' }};
                                                            color: white;
                                                            font-size: 26px;
                                                        ">
                                        <i class="bi bi-gem"></i>
                                    </div>

                                    <div>
                                        <h3 class="fw-bold mb-1" style="color: {{ $membership->color ?? '#0d6efd' }}">
                                            {{ $membership->name }}
                                        </h3>

                                        <span class="badge bg-success px-3 py-2">
                                            Đang hoạt động
                                        </span>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div class="border rounded-3 p-3 h-100">
                                            <small class="text-muted d-block">Thời hạn</small>
                                            <strong>
                                                {{ \Carbon\Carbon::parse($currentMembership->start_date)->format('d/m/Y') }}
                                                -
                                                {{ \Carbon\Carbon::parse($currentMembership->end_date)->format('d/m/Y') }}
                                            </strong>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="border rounded-3 p-3 h-100">
                                            <small class="text-muted d-block">Số ngày</small>
                                            <strong>{{ $package->duration_days }} ngày</strong>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="border rounded-3 p-3 h-100">
                                            <small class="text-muted d-block">Giá gói</small>
                                            <strong>{{ number_format($package->price, 0, ',', '.') }}đ</strong>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="border rounded-3 p-3 h-100">
                                            <small class="text-muted d-block">Còn lại</small>
                                            <strong>
                                                {{ now()->greaterThan($currentMembership->end_date)
                    ? '0 ngày'
                    : now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($currentMembership->end_date)->startOfDay()) . ' ngày' }}
                                            </strong>
                                        </div>
                                    </div>
                                </div>

                                @if ($membership->description)
                                    <div class="alert alert-light border mt-4 mb-0">
                                        <i class="bi bi-info-circle me-2 text-primary"></i>
                                        {{ $membership->description }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4 text-center">
                                <div class="p-4 rounded-4" style="
                                                        background: linear-gradient(135deg, {{ $membership->color ?? '#0d6efd' }}, #ffffff20);
                                                        border: 2px solid {{ $membership->color ?? '#0d6efd' }};
                                                    ">
                                    <i class="bi bi-award-fill" style="
                                                            font-size: 70px;
                                                            color: {{ $membership->color ?? '#0d6efd' }};
                                                        "></i>

                                    <h4 class="mt-3 fw-bold">
                                        {{ $membership->name }}
                                    </h4>

                                    <p class="text-muted mb-0">
                                        Gói thành viên hiện tại
                                    </p>
                                </div>
                            </div>
                        </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-award text-muted" style="font-size: 70px;"></i>
                        <h4 class="mt-3">Bạn chưa có gói thành viên nào</h4>
                        <p class="text-muted">
                            Hãy đăng ký gói để được ưu tiên hiển thị tin đăng và sử dụng nhiều tính năng hơn.
                        </p>

                        <a href="{{ route('frontend.membership.index') }}" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-cart-plus me-2"></i>
                            Đăng ký gói ngay
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Lịch sử các gói đã đăng ký --}}
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-clock-history text-secondary me-2"></i>
                    Lịch sử gói đã đăng ký
                </h5>
            </div>

            <div class="card-body p-0">
                @if ($userMemberships->count())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Gói</th>
                                    <th>Thời hạn</th>
                                    <th>Giá</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($userMemberships as $item)
                                    @php
                                        $membership = $item->membershipPackage->membership;
                                        $package = $item->membershipPackage;
                                    @endphp

                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle me-3" style="
                                                                                width: 18px;
                                                                                height: 18px;
                                                                                background: {{ $membership->color ?? '#6c757d' }};
                                                                            ">
                                                </div>

                                                <div>
                                                    <div class="fw-bold">
                                                        {{ $membership->name }}
                                                    </div>

                                                    <small class="text-muted">
                                                        {{ $package->duration_days }} ngày
                                                    </small>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            {{ $package->duration_days }} ngày
                                        </td>

                                        <td class="fw-semibold">
                                            {{ number_format($package->price, 0, ',', '.') }}đ
                                        </td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($item->start_date)->format('d/m/Y') }}
                                        </td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($item->end_date)->format('d/m/Y') }}
                                        </td>

                                        <td>
                                            @if ($item->status === 'active' && $item->end_date >= now())
                                                <span class="badge bg-success px-3 py-2">
                                                    Đang hoạt động
                                                </span>
                                            @elseif ($item->status === 'expired')
                                                <span class="badge bg-secondary px-3 py-2">
                                                    Đã hết hạn
                                                </span>
                                            @elseif ($item->status === 'cancelled')
                                                <span class="badge bg-danger px-3 py-2">
                                                    Đã hủy
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark px-3 py-2">
                                                    Không xác định
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-clock-history text-muted" style="font-size: 60px;"></i>
                        <h5 class="mt-3">Chưa có lịch sử đăng ký gói</h5>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection