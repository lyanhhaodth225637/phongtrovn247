@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh sách gói dịch vụ</h1>
        <p class="mb-4">
            Quản lý các gói dịch vụ đăng tin trong hệ thống.
        </p>

        <!-- DataTable -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between flex-wrap gap-2">
                    <div class="d-flex">
                        <a href="#" class="btn btn-success btn-icon-split mr-2">
                            <span class="icon text-white-50">
                                <i class="fas fa-file-import"></i>
                            </span>
                            <span class="text">Nhập Excel</span>
                        </a>

                        <a href="#" class="btn btn-warning btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-file-export"></i>
                            </span>
                            <span class="text">Xuất Excel</span>
                        </a>
                    </div>

                    <div>
                        <a href="{{ route('admin.membership.create') }}" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Thêm gói dịch vụ</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="dataTable">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width: 5%">STT</th>
                                <th>Tên gói</th>
                                <th>Ưu tiên</th>
                                <th>Màu tiêu đề</th>
                                <th>Mô tả</th>
                                <th style="width: 220px">Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($memberships as $membership)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <a href="{{ route('admin.membership.show', ['id' => $membership->id, 'slug' => $membership->slug]) }}"
                                            class="font-weight-bold text-decoration-none"
                                            title="Xem chi tiết {{ $membership->name }}">
                                            {{ $membership->name }}
                                        </a>
                                    </td>

                                    <td>
                                        <span class="badge badge-info px-3 py-2">
                                            {{ $membership->priority }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span style="
                                                        width: 20px;
                                                        height: 20px;
                                                        border-radius: 50%;
                                                        background: {{ $membership->color }};
                                                        border: 1px solid #ddd;
                                                        display: inline-block;
                                                        margin-right: 8px;
                                                    "></span>

                                            <code>{{ $membership->color }}</code>
                                        </div>
                                    </td>

                                    <td style="max-width: 300px;">
                                        @if($membership->description)
                                            <span class="text-truncate d-inline-block" style="max-width: 100%;">
                                                {{ $membership->description }}
                                            </span>
                                        @else
                                            <span class="text-muted">Không có mô tả</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <a href="{{ route('admin.membership.edit', ['id' => $membership->id, 'slug' => $membership->slug]) }}"
                                                class="btn btn-sm btn-outline-warning font-weight-bold mr-1" title="Sửa">
                                                <i class="fa fa-edit"></i> Sửa
                                            </a>

                                            <form action="{{ route('admin.membership.destroy', ['id' => $membership->id]) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-outline-danger font-weight-bold"
                                                    onclick="return confirm('Bạn có muốn xóa gói {{ $membership->name }}?')">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Chưa có thông tin gói dịch vụ đăng tin
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                pageLength: 10,
                language: {
                    search: "Tìm kiếm:",
                    lengthMenu: "Hiển thị _MENU_ dòng",
                    info: "Trang _PAGE_ / _PAGES_",
                    infoEmpty: "Không có dữ liệu",
                    zeroRecords: "Không tìm thấy gói dịch vụ phù hợp",
                    infoFiltered: "(lọc từ _MAX_ dòng)",
                    paginate: {
                        previous: "Trước",
                        next: "Sau"
                    }
                }
            });
        });
    </script>
@endpush