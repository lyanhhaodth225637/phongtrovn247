@extends('layouts.frontend.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                @php
                    $currentMembership = Auth::check()
                        ? Auth::user()
                            ->userMemberships()
                            ->where('status', 'active')
                            ->with('membershipPackage.membership')
                            ->latest('id')
                            ->first()
                        : null;

                    $currentPriority = $currentMembership->membershipPackage->membership->priority ?? 0;
                    $newPriority = $package->membership->priority ?? 0;

                    $isBlockedByPriority = $currentMembership && $currentPriority >= $newPriority;
                @endphp

                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-credit-card mr-2"></i>
                            Xác nhận đăng ký gói dịch vụ
                        </h4>
                    </div>

                    <div class="card-body p-4">

                        <div class="mb-4 text-center">
                            <h3 class="font-weight-bold mb-1" style="color: {{ $package->membership->color ?? '#0d6efd' }}">
                                {{ $package->membership->name }}
                            </h3>
                            <p class="text-muted mb-0">
                                {{ $package->membership->description }}
                            </p>
                        </div>

                        <div class="border rounded p-3 mb-4 bg-light">
                            <div class="row mb-3">
                                <div class="col-5 text-muted">Tên gói</div>
                                <div class="col-7 font-weight-bold">
                                    {{ $package->membership->name }}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-5 text-muted">Thời hạn</div>
                                <div class="col-7">
                                    {{ $package->duration_days }} ngày
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-5 text-muted">Giá thanh toán</div>
                                <div class="col-7 text-danger font-weight-bold h5 mb-0">
                                    {{ number_format($package->price) }}đ
                                </div>
                            </div>

                            @if($package->description)
                                <div class="row">
                                    <div class="col-5 text-muted">Mô tả</div>
                                    <div class="col-7">
                                        {{ $package->description }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        @auth
                            <div class="alert alert-info">
                                <div class="d-flex justify-content-between">
                                    <span>
                                        <i class="fas fa-wallet mr-1"></i>
                                        Số dư hiện tại
                                    </span>
                                    <strong>{{ number_format(Auth::user()->balance) }}đ</strong>
                                </div>
                            </div>

                            @if($currentMembership)
                                <div class="alert alert-secondary">
                                    <i class="fas fa-crown mr-1"></i>
                                    Gói hiện tại:
                                    <strong>{{ $currentMembership->membershipPackage->membership->name }}</strong>
                                    (đến {{ \Carbon\Carbon::parse($currentMembership->end_date)->format('d/m/Y H:i') }})
                                </div>
                            @endif

                            @if($isBlockedByPriority)
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Bạn đang sử dụng gói
                                    <strong>{{ $currentMembership->membershipPackage->membership->name }}</strong>.
                                    Không thể mua gói thấp hơn hoặc cùng cấp trong thời gian gói hiện tại còn hiệu lực.
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                        Quay lại
                                    </a>
                                </div>
                            @elseif(Auth::user()->balance < $package->price)
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Số dư của bạn không đủ để đăng ký gói này.
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('user.wallet.index') }}" class="btn btn-warning">
                                        <i class="fas fa-wallet mr-1"></i>
                                        Nạp thêm tiền
                                    </a>

                                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                        Quay lại
                                    </a>
                                </div>
                            @else
                                <form action="{{ route('user.membership.purchase', ['id' => $package->id]) }}" method="POST">
                                    @csrf

                                    <div class="d-flex justify-content-between">
                                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                            Quay lại
                                        </a>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-check mr-1"></i>
                                            Xác nhận thanh toán
                                        </button>
                                    </div>
                                </form>
                            @endif
                        @endauth

                        @guest
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    Đăng nhập để tiếp tục
                                </a>
                            </div>
                        @endguest

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection