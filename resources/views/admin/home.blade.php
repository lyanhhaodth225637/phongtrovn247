

@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h1 class="h3 mb-1 text-gray-800">Tổng quan hệ thống</h1>
            <p class="mb-0 text-muted">Thống kê người dùng, bài viết, doanh thu và giao dịch</p>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tổng người dùng
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalUsers) }}
                            </div>
                            <div class="small text-muted mt-1">
                                Mới hôm nay: {{ number_format($newUsersToday) }}
                            </div>
                        </div>
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Chủ cho thuê
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalLandlords) }}
                            </div>
                            <div class="small text-muted mt-1">
                                User thường: {{ number_format($totalNormalUsers) }}
                            </div>
                        </div>
                        <i class="fas fa-home fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tổng bài viết
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalPosts) }}
                            </div>
                            <div class="small text-muted mt-1">
                                Mới tháng này: {{ number_format($postsThisMonth) }}
                            </div>
                        </div>
                        <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Giao dịch
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalTransactions) }}
                            </div>
                            <div class="small text-muted mt-1">
                                Thành công: {{ number_format($successTransactions) }}
                            </div>
                        </div>
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                            Doanh thu hôm nay
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($revenueToday, 0, ',', '.') }}đ
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-2">
                            Doanh thu tuần này
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($revenueThisWeek, 0, ',', '.') }}đ
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-12 mb-4">
                <div class="card border-left-dark shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-2">
                            Doanh thu tháng này
                        </div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($revenueThisMonth, 0, ',', '.') }}đ
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thống kê tài khoản</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between">
                            <span>Quản trị viên</span>
                            <strong>{{ number_format($totalAdmins) }}</strong>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <span>Người dùng thường</span>
                            <strong>{{ number_format($totalNormalUsers) }}</strong>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <span>Chủ cho thuê</span>
                            <strong>{{ number_format($totalLandlords) }}</strong>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <span>Tài khoản bị khóa</span>
                            <strong>{{ number_format($lockedUsers) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Tài khoản bị cấm</span>
                            <strong>{{ number_format($bannedUsers) }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thống kê bài viết</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between">
                            <span>Đã duyệt</span>
                            <strong>{{ number_format($approvedPosts) }}</strong>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <span>Chờ duyệt</span>
                            <strong>{{ number_format($pendingPosts) }}</strong>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <span>Từ chối</span>
                            <strong>{{ number_format($rejectedPosts) }}</strong>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <span>Ẩn bởi admin</span>
                            <strong>{{ number_format($hiddenPostsByAdmin) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Ẩn bởi chủ tin</span>
                            <strong>{{ number_format($hiddenPostsByOwner) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Gói thành viên</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between">
                            <span>Người dùng đã đăng ký gói</span>
                            <strong>{{ number_format($usersRegisteredMembership) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Gói đang hoạt động</span>
                            <strong>{{ number_format($activeUserMemberships) }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thống kê giao dịch</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-between">
                            <span>Thành công</span>
                            <strong>{{ number_format($successTransactions) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Thất bại</span>
                            <strong>{{ number_format($failedTransactions) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

