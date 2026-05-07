@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tiện ích</h1>
        <p class="mb-4">
            Danh sách các tiện ích hỗ trợ cho phòng trọ, căn hộ, nhà cho thuê.
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
                        <a href="{{ route('admin.amenity.create') }}" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Thêm tiện ích</span>
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
                                <th>Tiện ích</th>
                                <th>Slug</th>
                                <th style="width: 220px">Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($amenities as $amenity)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="font-weight-bold">
                                        {{ $amenity->name }}
                                    </td>

                                    <td>
                                        <code>{{ $amenity->slug }}</code>
                                    </td>

                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <a href="{{ route('admin.amenity.edit', ['id' => $amenity->id, 'slug' => $amenity->slug]) }}"
                                                class="btn btn-sm btn-outline-warning font-weight-bold mr-1" title="Sửa">
                                                <i class="fa fa-edit"></i> Sửa
                                            </a>

                                            <form
                                                action="{{ route('admin.amenity.destroy', ['id' => $amenity->id, 'slug' => $amenity->slug]) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-outline-danger font-weight-bold"
                                                    onclick="return confirm('Bạn có muốn xóa tiện ích {{ $amenity->name }}?')">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Không có dữ liệu
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
                    zeroRecords: "Không tìm thấy tiện ích phù hợp",
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