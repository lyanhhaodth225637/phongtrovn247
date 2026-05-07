@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Quản lý gói đăng ký</h1>
        <p class="mb-4">
            Danh sách các gói thành viên mà người dùng đã đăng ký trong hệ thống.
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
                        <a href="#" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Đăng tin</span>
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
                                <th>Tên người dùng</th>
                                <th>Gói đăng ký</th>
                                <th>Thời hạn (ngày)</th>
                                <th>Bắt đầu</th>
                                <th>Kết thúc</th>
                                <th style="width: 120px">Trạng thái</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($userMemberships as $userMembership)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td style="max-width: 250px;">
                                        <a href="#" class="d-inline-block text-truncate" style="max-width: 100%;">
                                            {{ $userMembership->user->name }}
                                        </a>
                                    </td>

                                    <td>
                                        <span class="font-weight-bold">
                                            {{ $userMembership->membershipPackage->membership->name }}
                                        </span>
                                    </td>

                                    <td>{{ $userMembership->membershipPackage->duration_days }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($userMembership->start_date)->format('d/m/Y H:i') }}
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($userMembership->end_date)->format('d/m/Y H:i') }}
                                    </td>

                                    <td>
                                        @if($userMembership->status == 'active')
                                            <span class="badge badge-success px-3 py-2">
                                                Hoạt động
                                            </span>
                                        @elseif($userMembership->status == 'cancelled')
                                            <span class="badge badge-warning px-3 py-2">
                                                Đã hủy
                                            </span>
                                        @else
                                            <span class="badge badge-danger px-3 py-2">
                                                Hết hạn
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Không có gói đăng ký nào
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
                    zeroRecords: "Không tìm thấy gói đăng ký phù hợp",
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