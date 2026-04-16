@extends('layouts.admin.app')

@section('title', 'Nhật ký hoạt động')

@section('content')
    <div class="container-fluid">

        <h1 class="h3 mb-4 text-gray-800">Nhật ký hoạt động</h1>

        {{-- Bộ lọc --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-filter mr-1"></i> Bộ lọc
                </h6>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.activity_log.index') }}">
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="keyword" class="small font-weight-bold text-uppercase text-gray-600">Từ khóa</label>
                            <input type="text" name="keyword" id="keyword" class="form-control form-control-sm"
                                value="{{ request('keyword') }}" placeholder="Nhập mô tả, subject type, event...">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label for="log_name" class="small font-weight-bold text-uppercase text-gray-600">Nhóm
                                log</label>
                            <select name="log_name" id="log_name" class="form-control form-control-sm">
                                <option value="">-- Tất cả --</option>
                                @foreach ($logNames as $item)
                                    <option value="{{ $item }}" {{ request('log_name') == $item ? 'selected' : '' }}>
                                        {{ $item }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-sm mr-2">
                                <i class="fas fa-search fa-sm mr-1"></i> Lọc
                            </button>
                            <a href="{{ route('admin.activity_log.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-redo fa-sm mr-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Danh sách log --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list mr-1"></i> Danh sách nhật ký
                </h6>
                <span class="badge badge-info">Tổng: {{ $logs->total() }}</span>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th width="60">#</th>
                                <th width="160">Thời gian</th>
                                <th width="150">Người thực hiện</th>
                                <th width="110">Nhóm log</th>
                                <th width="110">Sự kiện</th>
                                <th>Mô tả</th>
                                <th width="170">Đối tượng</th>
                                <th width="180">Thuộc tính</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $key => $log)
                                <tr>
                                    <td>{{ $logs->firstItem() + $key }}</td>

                                    <td class="text-nowrap">
                                        <small>{{ $log->created_at?->format('d/m/Y H:i:s') }}</small>
                                    </td>

                                    <td>
                                        @if ($log->causer)
                                            <div class="font-weight-bold text-dark">{{ $log->causer->name ?? 'N/A' }}</div>
                                            <small class="text-muted">ID: {{ $log->causer->id }}</small>
                                        @else
                                            <span class="text-muted font-italic">Hệ thống</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($log->log_name)
                                            <span class="badge badge-primary">{{ $log->log_name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        @php
                                            $eventColor = match ($log->event) {
                                                'created' => 'success',
                                                'updated' => 'warning',
                                                'deleted' => 'danger',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        @if ($log->event)
                                            <span class="badge badge-{{ $eventColor }}">{{ $log->event }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td>{{ $log->description }}</td>

                                    <td>
                                        @if ($log->subject_type)
                                            <div class="font-weight-bold text-dark">{{ class_basename($log->subject_type) }}</div>
                                            <small class="text-muted">ID: {{ $log->subject_id }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        @php
                                            $props = $log->properties ? $log->properties->toArray() : [];
                                        @endphp

                                        @if (!empty($props))
                                            <button class="btn btn-sm btn-outline-info" type="button" data-toggle="collapse"
                                                data-target="#prop-{{ $log->id }}" aria-expanded="false">
                                                <i class="fas fa-code fa-sm"></i> Xem
                                            </button>
                                            <div class="collapse mt-2" id="prop-{{ $log->id }}">
                                                <pre class="small bg-light p-2 rounded mb-0"
                                                    style="white-space:pre-wrap;max-height:200px;overflow-y:auto">{{ json_encode($props, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Chưa có dữ liệu nhật ký hoạt động.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Hiển thị {{ $logs->firstItem() }}–{{ $logs->lastItem() }} / {{ $logs->total() }} bản ghi
                    </small>
                    {{ $logs->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection