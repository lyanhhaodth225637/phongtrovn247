@extends('layouts.admin.app')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh Sách bài viết</h1>
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
                        <a href="{{ route('admin.post.create') }}" class="btn btn-primary btn-icon-split">
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
                                <th>Tiêu đề</th>
                                <th>Người đăng</th>
                                <th>Danh mục</th>
                                <th>Trạng thái</th>
                                <th>Hiển thị</th>
                                <th>Duyệt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($posts->isEmpty())
                                <tr>
                                    <td colspan="8">Không có bài viết nào</td>
                                </tr>
                            @endif
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="max-width: 250px;">
                                        <a href="{{ route('admin.post.show', ['id' => $post->id]) }}" title="{{ $post->title }}"
                                            class="d-inline-block text-truncate" style="max-width: 100%;">
                                            {{ $post->title }}
                                        </a>
                                    </td>
                                    <td>{{ $post->user->name }}</td>
                                    <td>{{ $post->category->name }}</td>
                                    <td>
                                        @if($post->status == 'approved')
                                            <span
                                                style="color: #16a34a; background: #dcfce7; padding: 2px 10px; border-radius: 99px; font-size: 13px; font-weight: 500;">Đã
                                                duyệt</span>
                                        @elseif($post->status == 'pending')
                                            <span
                                                style="color: #d97706; background: #fef3c7; padding: 2px 10px; border-radius: 99px; font-size: 13px; font-weight: 500;">Đang
                                                chờ duyệt</span>
                                        @else
                                            <span
                                                style="color: #dc2626; background: #fee2e2; padding: 2px 10px; border-radius: 99px; font-size: 13px; font-weight: 500;">Từ
                                                chối</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($post->is_visible_admin == 1)
                                            <a href="{{ route('admin.post.show', ['id' => $post->id]) }}"
                                                class="btn btn-sm btn-outline-success fw-bold" title="Đang hiện">
                                                <i class="fa fa-eye"></i> Đã hiện
                                            </a>
                                        @else
                                            <a href="{{ route('admin.post.show', ['id' => $post->id]) }}"
                                                class="btn btn-sm btn-outline-secondary fw-bold" title="Đang ẩn">
                                                <i class="fa fa-eye-slash"></i> Đã ẩn
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.post.show', ['id' => $post->id]) }}"
                                            class="btn btn-sm btn-outline-success fw-bold" title="Duyệt bài">
                                            <i class="fa fa-check-circle"></i> Duyệt bài
                                        </a>
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