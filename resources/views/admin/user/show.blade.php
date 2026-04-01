@extends('layouts.admin.app')

@section('title', 'Chi tiết người dùng')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-circle mr-2 text-primary"></i>Chi tiết người dùng
    </h1>
    <div>
        <a href="{{ route('admin.user') }}" class="btn btn-sm btn-secondary shadow-sm mr-2">
            <i class="fas fa-arrow-left fa-sm mr-1"></i> Quay lại
        </a>
        <a href="{{ route('admin.user.edit', ['id'=>$user->id,'slug'=>$user->slug]) }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-edit fa-sm mr-1"></i> Chỉnh sửa
        </a>
    </div>
</div>

<!-- Row 1: Thông tin cơ bản + Thống kê -->
<div class="row">

    <!-- Thông tin người dùng -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-id-card mr-1"></i> Thông tin cá nhân
                </h6>
                @if($user->status === 'active')
                    <span class="badge badge-success px-3 py-1">
                        <i class="fas fa-check-circle mr-1"></i>Hoạt động
                    </span>
                @elseif($user->status === 'locked')
                    <span class="badge badge-warning px-3 py-1">
                        <i class="fas fa-lock mr-1"></i>Bị khóa
                    </span>
                @else
                    <span class="badge badge-danger px-3 py-1">
                        <i class="fas fa-ban mr-1"></i>Bị cấm
                    </span>
                @endif
            </div>
            <div class="card-body text-center">
                <!-- Avatar -->
                <div class="mb-3">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}"
                             alt="{{ $user->name }}"
                             class="rounded-circle border border-primary"
                             style="width: 110px; height: 110px; object-fit: cover; border-width: 3px !important;">
                    @else
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center"
                             style="width: 110px; height: 110px;">
                            <span class="text-white font-weight-bold" style="font-size: 2.5rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </span>
                        </div>
                    @endif
                </div>

                <h5 class="font-weight-bold text-gray-800 mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-0"><i class="fas fa-at mr-1"></i>{{ $user->slug }}</p>

                <hr>

                <!-- Thông tin chi tiết -->
                <div class="text-left">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-primary mr-3" style="width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-envelope text-white" style="font-size:.85rem;"></i>
                        </div>
                        <div>
                            <div class="text-xs text-muted font-weight-bold text-uppercase">Email</div>
                            <div class="text-sm text-gray-800">{{ $user->email }}</div>
                        </div>
                        <div class="ml-auto">
                            @if($user->email_verified_at)
                                <span class="badge badge-success" title="Đã xác thực {{ $user->email_verified_at->format('d/m/Y') }}">
                                    <i class="fas fa-check"></i>
                                </span>
                            @else
                                <span class="badge badge-secondary"><i class="fas fa-times"></i></span>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-success mr-3" style="width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-phone text-white" style="font-size:.85rem;"></i>
                        </div>
                        <div>
                            <div class="text-xs text-muted font-weight-bold text-uppercase">Số điện thoại</div>
                            <div class="text-sm text-gray-800">{{ $user->phone }}</div>
                        </div>
                        <div class="ml-auto">
                            @if($user->phone_verified_at)
                                <span class="badge badge-success" title="Đã xác thực {{ $user->phone_verified_at->format('d/m/Y') }}">
                                    <i class="fas fa-check"></i>
                                </span>
                            @else
                                <span class="badge badge-secondary"><i class="fas fa-times"></i></span>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-info mr-3" style="width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-calendar-alt text-white" style="font-size:.85rem;"></i>
                        </div>
                        <div>
                            <div class="text-xs text-muted font-weight-bold text-uppercase">Ngày tham gia</div>
                            <div class="text-sm text-gray-800">{{ $user->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-1">
                        <div class="icon-circle bg-warning mr-3" style="width:38px;height:38px;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-sync-alt text-white" style="font-size:.85rem;"></i>
                        </div>
                        <div>
                            <div class="text-xs text-muted font-weight-bold text-uppercase">Cập nhật lần cuối</div>
                            <div class="text-sm text-gray-800">{{ $user->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Hành động nhanh -->
                <div class="d-flex justify-content-around">
                    @if($user->status !== 'active')
                        <form method="POST" action="">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-unlock mr-1"></i> Mở khóa
                            </button>
                        </form>
                    @else
                        <form method="POST" action="">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-warning">
                                <i class="fas fa-lock mr-1"></i> Khóa
                            </button>
                        </form>
                    @endif
                    <form method="POST" action=""
                          onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash mr-1"></i> Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê nhanh -->
    <div class="col-xl-8 col-lg-7">

        <!-- Stat Cards -->
        <div class="row">
            <div class="col-sm-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng bài đăng</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $user->posts->count() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Bài đã duyệt</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    {{ $user->posts->where('status', 'approved')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Chờ duyệt</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    {{ $user->posts->where('status', 'pending')->count() }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Lượt xem</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">
                                    {{ number_format($user->posts->sum('view_count')) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-eye fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gói thành viên đang dùng -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-box-open mr-1"></i> Gói thành viên đang đăng ký
                </h6>
                <a href="{{ route('admin.user_membership') }}?user={{ $user->id }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-list mr-1"></i> Xem tất cả
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($user->userMemberships->where('status', 'active') as $um)
                <div class="d-flex align-items-center px-4 py-3 border-bottom">
                    <div class="mr-3">
                        <div class="icon-circle d-flex align-items-center justify-content-center"
                             style="width:46px;height:46px;border-radius:50%;background-color:{{ $um->membershipPackage->membership->color ?? '#4e73df' }}20;">
                            <i class="fas fa-crown" style="color:{{ $um->membershipPackage->membership->color ?? '#4e73df' }};font-size:1.2rem;"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="font-weight-bold text-gray-800">
                            {{ $um->membershipPackage->name ?? 'N/A' }}
                        </div>
                        <div class="text-xs text-muted">
                            {{ $um->membershipPackage->membership->name ?? '' }}
                            &bull; {{ \Carbon\Carbon::parse($um->start_date)->format('d/m/Y') }}
                            → {{ \Carbon\Carbon::parse($um->end_date)->format('d/m/Y') }}
                        </div>
                    </div>
                    <div class="ml-3 text-right">
                        <!-- Progress hết hạn -->
                        @php
                            $total = \Carbon\Carbon::parse($um->start_date)->diffInDays(\Carbon\Carbon::parse($um->end_date));
                            $used  = \Carbon\Carbon::parse($um->start_date)->diffInDays(now());
                            $pct   = $total > 0 ? min(100, round($used / $total * 100)) : 100;
                            $color = $pct >= 80 ? 'danger' : ($pct >= 50 ? 'warning' : 'success');
                            $daysLeft = max(0, \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($um->end_date), false));
                        @endphp
                        <div class="text-xs text-muted mb-1">Còn {{ $daysLeft }} ngày</div>
                        <div class="progress" style="width:100px;height:6px;">
                            <div class="progress-bar bg-{{ $color }}" style="width:{{ $pct }}%"></div>
                        </div>
                    </div>
                    <div class="ml-3">
                        <span class="badge badge-success px-2 py-1">
                            <i class="fas fa-circle mr-1" style="font-size:.5rem;"></i>Đang dùng
                        </span>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-box-open fa-2x mb-2 d-block text-gray-300"></i>
                    Người dùng chưa đăng ký gói nào
                </div>
                @endforelse

                <!-- Lịch sử gói đã hết hạn -->
                @if($user->userMemberships->where('status', '!=', 'active')->count() > 0)
                <div class="px-4 py-2 bg-light border-top">
                    <small class="text-muted font-weight-bold text-uppercase">
                        <i class="fas fa-history mr-1"></i>Lịch sử ({{ $user->userMemberships->where('status', '!=', 'active')->count() }} gói)
                    </small>
                </div>
                @foreach($user->userMemberships->where('status', '!=', 'active')->take(3) as $um)
                <div class="d-flex align-items-center px-4 py-2 border-bottom bg-light">
                    <div class="flex-grow-1">
                        <span class="text-gray-700 small">{{ $um->membershipPackage->name ?? 'N/A' }}</span>
                        <span class="text-muted small ml-2">
                            {{ \Carbon\Carbon::parse($um->start_date)->format('d/m/Y') }}
                            → {{ \Carbon\Carbon::parse($um->end_date)->format('d/m/Y') }}
                        </span>
                    </div>
                    <span class="badge badge-{{ $um->status === 'expired' ? 'secondary' : 'danger' }}">
                        {{ $um->status === 'expired' ? 'Hết hạn' : 'Đã hủy' }}
                    </span>
                </div>
                @endforeach
                @endif
            </div>
        </div>

    </div><!-- /.col-xl-8 -->
</div><!-- /.row -->

<!-- Row 2: Danh sách bài viết -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-newspaper mr-1"></i> Bài đăng của người dùng
                    <span class="badge badge-primary ml-2">{{ $user->posts->count() }}</span>
                </h6>
                <div class="d-flex align-items-center">
                    <!-- Filter nhanh -->
                    <div class="btn-group btn-group-sm mr-2" role="group">
                        <button type="button" class="btn btn-outline-secondary filter-btn active" data-filter="all">Tất cả</button>
                        <button type="button" class="btn btn-outline-success filter-btn" data-filter="approved">Đã duyệt</button>
                        <button type="button" class="btn btn-outline-warning filter-btn" data-filter="pending">Chờ duyệt</button>
                        <button type="button" class="btn btn-outline-danger filter-btn" data-filter="rejected">Từ chối</button>
                    </div>
                    <a href="{{ route('admin.post.create') }}?user={{ $user->id }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus mr-1"></i> Thêm bài
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="postsTable">
                        <thead class="thead-light">
                            <tr>
                                <th style="width:50px" class="text-center">#</th>
                                <th>Tiêu đề</th>
                                <th>Danh mục</th>
                                <th>Giá</th>
                                <th>Khu vực</th>
                                <th>Gói tin</th>
                                <th class="text-center">Lượt xem</th>
                                <th class="text-center">Trạng thái</th>
                                <th>Hết hạn</th>
                                <th class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->posts as $index => $post)
                            <tr class="post-row" data-status="{{ $post->status }}">
                                <td class="text-center text-muted small align-middle">{{ $index + 1 }}</td>
                                <td class="align-middle">
                                    <div class="font-weight-bold text-gray-800" style="max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
                                         title="{{ $post->title }}">
                                        {{ $post->title }}
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $post->address }}
                                    </small>
                                </td>
                                <td class="align-middle">
                                    @if($post->category)
                                        <span class="badge badge-light border">
                                            <i class="fas fa-tag mr-1 text-primary"></i>{{ $post->category->name }}
                                        </span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td class="align-middle font-weight-bold text-success" style="white-space:nowrap;">
                                    {{ number_format($post->price, 0, ',', '.') }}đ
                                    <small class="text-muted font-weight-normal">/{{ $post->price_unit === 'month' ? 'tháng' : 'ngày' }}</small>
                                </td>
                                <td class="align-middle small text-muted">
                                    {{ $post->ward->name ?? '—' }}
                                </td>
                                <td class="align-middle">
                                    @if($post->membership)
                                        <span class="badge badge-pill px-2"
                                              style="background-color:{{ $post->membership->color ?? '#4e73df' }}20;color:{{ $post->membership->color ?? '#4e73df' }};border:1px solid {{ $post->membership->color ?? '#4e73df' }}40;">
                                            {{ $post->membership->name }}
                                        </span>
                                    @else
                                        <span class="text-muted small">Thường</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <span class="text-gray-700">
                                        <i class="fas fa-eye text-muted mr-1" style="font-size:.8rem;"></i>
                                        {{ number_format($post->view_count) }}
                                    </span>
                                </td>
                                <td class="text-center align-middle">
                                    @if($post->status === 'approved')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check mr-1"></i>Đã duyệt
                                        </span>
                                    @elseif($post->status === 'pending')
                                        <span class="badge badge-warning text-white">
                                            <i class="fas fa-clock mr-1"></i>Chờ duyệt
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            <i class="fas fa-times mr-1"></i>Từ chối
                                        </span>
                                    @endif

                                    @if(!$post->is_visible_owner || !$post->is_visible_admin)
                                        <br><span class="badge badge-secondary mt-1" style="font-size:.65rem;">
                                            <i class="fas fa-eye-slash mr-1"></i>Đã ẩn
                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle small" style="white-space:nowrap;">
                                    @if($post->expires_at)
                                        @php $expired = now()->gt($post->expires_at); @endphp
                                        <span class="{{ $expired ? 'text-danger' : 'text-muted' }}">
                                            <i class="fas fa-hourglass-{{ $expired ? 'end' : 'half' }} mr-1"></i>
                                            {{ \Carbon\Carbon::parse($post->expires_at)->format('d/m/Y') }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle" style="white-space:nowrap;">
                                    <a href="{{ route('admin.post.show', $post->id) }}"
                                       class="btn btn-sm btn-info btn-icon" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href=""
                                       class="btn btn-sm btn-warning btn-icon ml-1" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action=""
                                          class="d-inline ml-1"
                                          onsubmit="return confirm('Xóa bài đăng này?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-icon" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block text-gray-300"></i>
                                    Người dùng chưa có bài đăng nào
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($user->posts->count() > 0)
            <div class="card-footer text-muted small py-2">
                Hiển thị {{ $user->posts->count() }} bài đăng
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Filter bài viết theo trạng thái
    document.querySelectorAll('.filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            var filter = this.dataset.filter;
            document.querySelectorAll('.post-row').forEach(function(row) {
                if (filter === 'all' || row.dataset.status === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush