@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Quản Lý Thông Tin Người Dùng</h1>
        <p class="mb-4">
            Danh sách toàn bộ người dùng trong hệ thống.
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
                        <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Đăng Ký Tài Khoản</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="dataTable">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:5%">STT</th>
                                <th>Tên</th>
                                <th>SĐT</th>
                                <th>Email</th>
                                <th>Vai Trò</th>
                                <th>Trạng Thái</th>
                                <th style="width:220px">Thao Tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($users->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Không có người dùng nào
                                    </td>
                                </tr>
                            @endif

                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <a href="{{ route('admin.user.show', ['id' => $user->id, 'slug' => $user->slug]) }}"
                                            title="Xem chi tiết {{ $user->name }}" class="font-weight-bold">
                                            {{ $user->name }}
                                        </a>
                                    </td>

                                    <td>{{ $user->phone ?? '---' }}</td>

                                    <td>{{ $user->email ?? '---' }}</td>

                                    <td>
                                        @if($user->hasRole('admin'))
                                            <span class="badge badge-danger px-3 py-2">Quản trị</span>
                                        @elseif($user->hasRole('landlord'))
                                            <span class="badge badge-primary px-3 py-2">Chủ cho thuê</span>
                                        @else
                                            <span class="badge badge-secondary px-3 py-2">Người dùng</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($user->status == 'active')
                                            <span
                                                style="color:#16a34a;background:#dcfce7;padding:4px 12px;border-radius:999px;font-size:13px;font-weight:600;">
                                                Hoạt động
                                            </span>
                                        @elseif($user->status == 'locked')
                                            <span
                                                style="color:#d97706;background:#fef3c7;padding:4px 12px;border-radius:999px;font-size:13px;font-weight:600;">
                                                Khóa tạm thời
                                            </span>
                                        @else
                                            <span
                                                style="color:#dc2626;background:#fee2e2;padding:4px 12px;border-radius:999px;font-size:13px;font-weight:600;">
                                                Cấm vĩnh viễn
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <a href="{{ route('admin.user.edit', ['id' => $user->id, 'slug' => $user->slug]) }}"
                                                class="btn btn-sm btn-outline-warning font-weight-bold mr-1">
                                                <i class="fa fa-edit"></i> Sửa
                                            </a>

                                            <a href="{{ route('admin.user.show', ['id' => $user->id, 'slug' => $user->slug]) }}"
                                                class="btn btn-sm btn-outline-primary font-weight-bold mr-1">
                                                <i class="fa fa-eye"></i> Chi tiết
                                            </a>

                                            <form action="" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-outline-danger font-weight-bold"
                                                    onclick="return confirm('Bạn có muốn xóa {{ $user->name }}?')">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
                    zeroRecords: "Không tìm thấy người dùng phù hợp",
                    infoFiltered: "(lọc từ _MAX_ người dùng)",
                    paginate: {
                        previous: "Trước",
                        next: "Sau"
                    }
                }
            });
        });
    </script>
@endpush