@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Quản lý gói đăng ký</h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank"
                href="https://datatables.net">official DataTables documentation</a>.</p>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="#" class="btn btn-success btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Nhập Excel</span>
                        </a>
                        <a href="#" class="btn btn-warning btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Xuất Excel</span>
                        </a>
                    </div>
                    <div>
                        <a href="" class="btn btn-primary btn-icon-split">
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
                    <table class="table table-bordered table-hover" id="dataTable">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:5%">STT</th>
                                <th>Tên người dùng</th>
                                <th>Gói đăng ký</th>
                                <th>Thời hạn (ngày)</th>
                                <th>Bắt đầu</th>
                                <th>Kết thúc</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($userMemberships->isEmpty())
                                <tr>
                                    <td colspan="8">Không gói đk nào</td>
                                </tr>
                            @endif
                            @foreach ($userMemberships as $userMembership)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="max-width: 250px;">
                                        <a href="" title="" class="d-inline-block text-truncate" style="max-width: 100%;">
                                            {{ $userMembership->user->name }}
                                        </a>
                                    </td>
                                    <td>{{ $userMembership->membershipPackage->membership->name }}</td>
                                    <td>{{ $userMembership->membershipPackage->duration_days }}</td>
                                    <td>{{ $userMembership->start_date }}</td>
                                    <td>{{ $userMembership->end_date }}</td>
                                    <td>
                                        @if($userMembership->status == "active")
                                            Hoạt động
                                        @else
                                            Hết hạn
                                        @endif
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
                    paginate: {
                        previous: "Trước",
                        next: "Sau"
                    }
                }
            });

        });

    </script>

@endpush