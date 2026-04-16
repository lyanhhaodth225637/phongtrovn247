@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-flag fa-sm text-danger mr-2"></i> Quản lý tố cáo bài viết
            </h1>
            <span class="text-muted small">
                Tổng: <strong>{{ $reports->total() }}</strong> tố cáo
            </span>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        {{-- Filter Card --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-filter mr-1"></i> Bộ lọc
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" class="form-inline">
                    <label class="mr-2 font-weight-bold text-gray-700">Trạng thái:</label>
                    <select name="status" class="form-control form-control-sm mr-3">
                        <option value="">-- Tất cả --</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Đã xử lý</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Từ chối tố cáo
                        </option>
                    </select>
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-search fa-sm mr-1"></i> Lọc
                    </button>
                    @if(request('status'))
                        <a href="{{ route('admin.post_reports.index') }}" class="btn btn-secondary btn-sm ml-2">
                            <i class="fas fa-times fa-sm mr-1"></i> Xoá lọc
                        </a>
                    @endif
                </form>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list mr-1"></i> Danh sách tố cáo
                </h6>
                {{-- Summary badges --}}
                <div class="d-flex gap-2" style="gap:8px">
                    <span class="badge badge-pill badge-warning px-3 py-2">
                        Chờ xử lý: {{ $reports->where('status', 'pending')->count() }}
                    </span>
                    <span class="badge badge-pill badge-success px-3 py-2">
                        Đã xử lý: {{ $reports->where('status', 'resolved')->count() }}
                    </span>
                    <span class="badge badge-pill badge-secondary px-3 py-2">
                        Từ chối: {{ $reports->where('status', 'rejected')->count() }}
                    </span>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0" style="font-size:.875rem">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center" style="width:50px">#</th>
                                <th>Bài viết</th>
                                <th>Người tố cáo</th>
                                <th>Lý do</th>
                                <th class="text-center" style="width:120px">Trạng thái</th>
                                <th class="text-center" style="width:130px">Ngày gửi</th>
                                <th class="text-center" style="width:80px">Chi tiết</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $i => $report)
                                <tr>
                                    <td class="text-center text-muted">
                                        {{ $reports->firstItem() + $i }}
                                    </td>

                                    <td>
                                        <div class="font-weight-bold text-gray-800">
                                            {{ Str::limit($report->post?->title, 55) }}
                                        </div>
                                        <div class="small text-muted">
                                            <i class="fas fa-user fa-xs mr-1"></i>
                                            {{ $report->post?->user?->name ?? '---' }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            
                                            </div>
                                            <span>{{ $report->reporter?->name ?? '---' }}</span>
                                        </div>
                                    </td>

                                    <td>
                                        @php
                                            $reasonMap = [
                                                'spam' => ['label' => 'Tin rác', 'class' => 'badge-secondary'],
                                                'scam' => ['label' => 'Lừa đảo', 'class' => 'badge-danger'],
                                                'false_info' => ['label' => 'Thông tin sai', 'class' => 'badge-warning text-dark'],
                                                'duplicate' => ['label' => 'Tin trùng lặp', 'class' => 'badge-info'],
                                                'inappropriate' => ['label' => 'Nội dung không phù hợp', 'class' => 'badge-dark'],
                                                'wrong_price' => ['label' => 'Giá không đúng', 'class' => 'badge-primary'],
                                                'other' => ['label' => 'Khác', 'class' => 'badge-light border'],
                                            ];
                                            $r = $reasonMap[$report->reason_type] ?? ['label' => $report->reason_type, 'class' => 'badge-secondary'];
                                        @endphp
                                        <span class="badge {{ $r['class'] }} px-2 py-1">{{ $r['label'] }}</span>
                                    </td>

                                    <td class="text-center">
                                        @if($report->status === 'pending')
                                            <span class="badge badge-warning text-dark px-2 py-1">
                                                <i class="fas fa-clock fa-xs mr-1"></i> Chờ xử lý
                                            </span>
                                        @elseif($report->status === 'resolved')
                                            <span class="badge badge-success px-2 py-1">
                                                <i class="fas fa-check fa-xs mr-1"></i> Đã xử lý
                                            </span>
                                        @else
                                            <span class="badge badge-secondary px-2 py-1">
                                                <i class="fas fa-ban fa-xs mr-1"></i> Từ chối
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-center text-muted small">
                                        {{ $report->created_at?->format('d/m/Y') }}<br>
                                        <span style="font-size:.75rem">{{ $report->created_at?->format('H:i') }}</span>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.post_reports.show', $report->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Chưa có tố cáo nào.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($reports->hasPages())
                    <div class="px-4 py-3 border-top">
                        {{ $reports->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection