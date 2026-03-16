@extends('layouts.admin.app')
@section("content")
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"> Danh mục - loại hình cho thuê</h1>
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
                        <a href="{{ route('admin.category.create') }}" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Thêm</span>
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
                                <th>Danh mục</th>
                                <th>Slug</th>
                                <th>Hình ảnh</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($categories->isEmpty())
                                <tr>
                                    <th colspan="4" class="text-center">Không có dữ liệu</th>
                                </tr>
                            @endif
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->slug   }}</td>
                                    <td>
                                        <img src="{{ asset('storage/'.$category->image) }}" alt="Hình ảnh">
                                    <td>
                                        <a href="{{ route('admin.category.edit', ['id' => $category->id, 'slug' => $category->slug]) }}"
                                            class="btn btn-sm btn-outline-warning fw-bold" title="Sửa">
                                            <i class="fa fa-edit"></i> Sửa
                                        </a>
                                        <form
                                            action="{{ route('admin.category.destroy', ['id' => $category->id, 'slug' => $category->slug]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger fw-bold"
                                                onclick="return confirm('Bạn có muốn xóa') ">
                                                Xóa
                                            </button>
                                        </form>
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