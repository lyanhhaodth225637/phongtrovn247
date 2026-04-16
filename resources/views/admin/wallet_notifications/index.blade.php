@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        {{-- Page Heading --}}
        <h1 class="h3 mb-2 text-gray-800">Thông Báo Nạp Tiền Chờ Duyệt</h1>
        <p class="mb-4">
            Danh sách các thông báo chuyển khoản từ người dùng, phân loại theo trạng thái khớp lệnh.
        </p>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                    Chưa khớp
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $counts['unmatched'] ?? 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-question-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Đã khớp
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $counts['matched'] ?? 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-link fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Đã duyệt
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $counts['approved'] ?? 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Từ chối
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $counts['rejected'] ?? 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Table --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 8px;">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Danh sách thông báo
                    </h6>

                    <div class="d-flex flex-wrap" style="gap: 6px;">
                        <button class="btn btn-secondary btn-sm filter-btn active" data-status="all">
                            Tất cả
                        </button>

                        <button class="btn btn-outline-secondary btn-sm filter-btn" data-status="unmatched">
                            <i class="fas fa-question-circle mr-1"></i>Chưa khớp
                        </button>

                        <button class="btn btn-outline-info btn-sm filter-btn" data-status="matched">
                            <i class="fas fa-link mr-1"></i>Đã khớp
                        </button>

                        <button class="btn btn-outline-success btn-sm filter-btn" data-status="approved">
                            <i class="fas fa-check mr-1"></i>Đã duyệt
                        </button>

                        <button class="btn btn-outline-danger btn-sm filter-btn" data-status="rejected">
                            <i class="fas fa-times mr-1"></i>Từ chối
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="notifyTable">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width: 5%">ID</th>
                                <th>Người dùng</th>
                                <th>Số tiền</th>
                                <th>Nội dung chuyển khoản</th>
                                <th>Trạng thái</th>
                                <th>Thời gian báo</th>
                                <th style="width: 10%" class="text-center">Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($notifications as $item)
                                <tr data-status="{{ $item->match_status }}">
                                    <td>
                                        <strong>#{{ $item->id }}</strong>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center" style="gap: 8px;">
                                            <span>
                                                {{ $item->walletTransaction?->user?->name ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <strong>
                                            {{ number_format($item->amount, 0, ',', '.') }} đ
                                        </strong>
                                    </td>

                                    <td>
                                        <code style="font-size: .8rem; color: #4e73df;">
                                                    {{ $item->transfer_content }}
                                                </code>
                                    </td>

                                    <td>
                                        @if($item->match_status === 'unmatched')
                                            <span class="badge badge-secondary">Chưa khớp</span>
                                        @elseif($item->match_status === 'matched')
                                            <span class="badge badge-info">Đã khớp</span>
                                        @elseif($item->match_status === 'approved')
                                            <span class="badge badge-success">Đã duyệt</span>
                                        @elseif($item->match_status === 'rejected')
                                            <span class="badge badge-danger">Từ chối</span>
                                        @else
                                            <span class="badge badge-secondary">
                                                {{ $item->match_status }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-muted" style="font-size: .82rem; white-space: nowrap;">
                                        {{ optional($item->created_at)->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.wallet_notifications.show', $item->id) }}"
                                            class="btn btn-sm btn-outline-primary fw-bold">
                                            <i class="fa fa-eye"></i> Xem
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-3x d-block mb-2 text-gray-300"></i>
                                        Chưa có thông báo nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($notifications->hasPages())
                <div class="card-footer d-flex align-items-center justify-content-between flex-wrap" style="gap: 10px;">
                    <small class="text-muted">
                        Hiển thị {{ $notifications->firstItem() }}–{{ $notifications->lastItem() }}
                        / {{ $notifications->total() }} kết quả
                    </small>

                    {{ $notifications->links() }}
                </div>
            @endif
        </div>

    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#notifyTable').DataTable({
                    pageLength: 10,
                    order: [
                        [0, 'desc']
                    ],
                    columnDefs: [{
                        orderable: false,
                        targets: 6
                    }],
                    language: {
                        search: "Tìm kiếm:",
                        lengthMenu: "Hiển thị _MENU_ dòng",
                        info: "Trang _PAGE_ / _PAGES_",
                        paginate: {
                            previous: "Trước",
                            next: "Sau"
                        }
                    }
                });
            });

            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.filter-btn').forEach(b => {
                        b.classList.remove('active');
                        b.className = b.className
                            .replace('btn-info', 'btn-outline-info')
                            .replace('btn-success', 'btn-outline-success')
                            .replace('btn-danger', 'btn-outline-danger')
                            .replace('btn-secondary', 'btn-outline-secondary');
                    });

                    this.classList.add('active');
                    this.className = this.className.replace('btn-outline-', 'btn-');

                    const status = this.dataset.status;

                    document.querySelectorAll('#notifyTable tbody tr[data-status]').forEach(row => {
                        row.style.display =
                            (status === 'all' || row.dataset.status === status) ? '' : 'none';
                    });
                });
            });
        </script>
    @endpush
@endsection