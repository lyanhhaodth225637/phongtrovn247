@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        {{-- Page Heading --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-flag fa-sm text-danger mr-2"></i>
                Chi tiết tố cáo <span class="text-danger">#{{ $report->id }}</span>
            </h1>
            <a href="{{ route('admin.post_reports.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm mr-1"></i> Quay lại
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        <div class="row">

            {{-- LEFT: Thông tin tố cáo --}}
            <div class="col-lg-8">

                {{-- Bài viết bị tố cáo --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-file-alt mr-1"></i> Bài viết bị tố cáo
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="font-weight-bold text-gray-800 mb-1" style="font-size:1rem">
                                    {{ $report->post?->title ?? '---' }}
                                </div>
                                <div class="small text-muted">
                                    <i class="fas fa-user fa-xs mr-1"></i>
                                    Người đăng: <strong>{{ $report->post?->user?->name ?? '---' }}</strong>
                                </div>
                            </div>
                            @if($report->post)
                                <a href="{{ route('admin.post.show', ['id' => $report->post->id, 'slug' => $report->post->slug]) }}"
                                    target="_blank" class="btn btn-sm btn-outline-primary ml-3 flex-shrink-0">
                                    <i class="fas fa-external-link-alt fa-xs mr-1"></i> Xem bài
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Chi tiết tố cáo --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle mr-1"></i> Thông tin tố cáo
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0" style="font-size:.875rem">
                            <tbody>
                                <tr>
                                    <th class="bg-light" style="width:180px">Người tố cáo</th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center mr-2"
                                                style="width:30px;height:30px;font-size:.75rem;flex-shrink:0">
                                                {{ strtoupper(substr($report->reporter?->name ?? '?', 0, 1)) }}
                                            </div>
                                            {{ $report->reporter?->name ?? '---' }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Lý do</th>
                                    <td>
                                        @php
                                            $reasonMap = [
                                                'spam' => ['label' => 'Tin rác', 'class' => 'badge-secondary'],
                                                'scam' => ['label' => 'Lừa đảo', 'class' => 'badge-danger'],
                                                'false_info' => ['label' => 'Thông tin sai sự thật', 'class' => 'badge-warning text-dark'],
                                                'duplicate' => ['label' => 'Tin trùng lặp', 'class' => 'badge-info'],
                                                'inappropriate' => ['label' => 'Nội dung không phù hợp', 'class' => 'badge-dark'],
                                                'wrong_price' => ['label' => 'Giá không đúng', 'class' => 'badge-primary'],
                                                'other' => ['label' => 'Khác', 'class' => 'badge-light border'],
                                            ];
                                            $r = $reasonMap[$report->reason_type] ?? ['label' => $report->reason_type, 'class' => 'badge-secondary'];
                                        @endphp
                                        <span class="badge {{ $r['class'] }} px-2 py-1">{{ $r['label'] }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Chi tiết</th>
                                    <td>
                                        @if($report->reason_detail)
                                            {{ $report->reason_detail }}
                                        @else
                                            <span class="text-muted">Không có</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Ngày gửi</th>
                                    <td>{{ $report->created_at?->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Trạng thái</th>
                                    <td>
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
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Kết quả xử lý (nếu đã xử lý) --}}
                @if($report->handled_by)
                    <div class="card shadow mb-4 border-left-success">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">
                                <i class="fas fa-check-circle mr-1"></i> Kết quả xử lý
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered mb-0" style="font-size:.875rem">
                                <tbody>
                                    <tr>
                                        <th class="bg-light" style="width:180px">Người xử lý</th>
                                        <td>{{ $report->handler?->name ?? '---' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Thời gian xử lý</th>
                                        <td>{{ $report->handled_at?->format('d/m/Y H:i') ?? '---' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Ghi chú admin</th>
                                        <td>{{ $report->admin_note ?: 'Không có' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>

            {{-- RIGHT: Hành động xử lý --}}
            <div class="col-lg-4">
                @if($report->status === 'pending')

                    {{-- Xác nhận hợp lệ --}}
                    <div class="card shadow mb-4 border-left-success">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">
                                <i class="fas fa-check-circle mr-1"></i> Xác nhận tố cáo hợp lệ
                            </h6>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted mb-3">
                                Bài viết sẽ bị ẩn và chủ bài viết sẽ nhận được thông báo.
                            </p>
                            <form action="{{ route('admin.post_reports.resolve', $report->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="font-weight-bold small text-gray-700">Ghi chú xử lý</label>
                                    <textarea name="admin_note" rows="3" class="form-control form-control-sm"
                                        placeholder="Nhập ghi chú..."></textarea>
                                </div>
                                <button class="btn btn-success btn-block">
                                    <i class="fas fa-check mr-1"></i> Xác nhận hợp lệ
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Từ chối --}}
                    <div class="card shadow mb-4 border-left-secondary">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-secondary">
                                <i class="fas fa-ban mr-1"></i> Từ chối tố cáo
                            </h6>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted mb-3">
                                Tố cáo sẽ bị đánh dấu không hợp lệ, bài viết vẫn được giữ nguyên.
                            </p>
                            <form action="{{ route('admin.post_reports.reject', $report->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label class="font-weight-bold small text-gray-700">Lý do từ chối</label>
                                    <textarea name="admin_note" rows="3" class="form-control form-control-sm"
                                        placeholder="Nhập lý do..."></textarea>
                                </div>
                                <button class="btn btn-secondary btn-block">
                                    <i class="fas fa-times mr-1"></i> Từ chối tố cáo
                                </button>
                            </form>
                        </div>
                    </div>

                @else
                    {{-- Đã xử lý xong --}}
                    <div class="card shadow mb-4">
                        <div class="card-body text-center py-5 text-muted">
                            <i class="fas fa-check-double fa-3x mb-3 d-block
                                    {{ $report->status === 'resolved' ? 'text-success' : 'text-secondary' }}"></i>
                            <div class="font-weight-bold">
                                {{ $report->status === 'resolved' ? 'Tố cáo đã được xử lý' : 'Tố cáo đã bị từ chối' }}
                            </div>
                            <div class="small mt-1">{{ $report->handled_at?->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection