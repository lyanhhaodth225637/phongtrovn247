@extends('layouts.admin.app')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Phường / Xã</h1>
        <p class="mb-4">
            Danh sách toàn bộ phường, xã trong hệ thống.
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
                        <a href="" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Thêm Phường / Xã</span>
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
                                <th>Tỉnh / Thành phố</th>
                                <th>Phường / Xã</th>
                                <th>Code</th>
                                <th>Slug</th>
                                <th style="width: 220px">Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($wards as $ward)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $ward->province->name ?? '---' }}</td>
                                    <td class="font-weight-bold">{{ $ward->name }}</td>
                                    <td>
                                        <span class="badge badge-info px-3 py-2">
                                            {{ $ward->code }}
                                        </span>
                                    </td>
                                    <td>
                                        <code>{{ $ward->slug }}</code>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <a href=""
                                                class="btn btn-sm btn-outline-warning font-weight-bold mr-1" title="Sửa">
                                                <i class="fa fa-edit"></i> Sửa
                                            </a>

                                            <form action="" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-outline-danger font-weight-bold"
                                                    onclick="return confirm('Bạn có muốn xóa {{ $ward->name }}?')">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        Không có phường / xã nào
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
                    zeroRecords: "Không tìm thấy phường / xã phù hợp",
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