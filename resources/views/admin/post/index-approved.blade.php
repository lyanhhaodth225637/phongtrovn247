@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <!-- Tiêu đề trang -->
        <h1 class="h3 mb-2 text-gray-800">Danh Sách Bài Viết Đã Duyệt</h1>
        <p class="mb-4">
            Danh sách các bài viết đã được quản trị viên duyệt và đang có trong hệ thống.
        </p>

        <!-- Danh sách -->
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
                        <a href="{{ route('admin.post.create') }}" class="btn btn-primary btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Đăng Tin</span>
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
                                <th>Tiêu Đề</th>
                                <th>Người Đăng</th>
                                <th>Danh Mục</th>
                                <th>Trạng Thái</th>
                                <th>Hiển Thị</th>
                                <th>Chi Tiết</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($postsApproved->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Không có bài viết nào
                                    </td>
                                </tr>
                            @endif

                            @foreach ($postsApproved as $post)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td style="max-width: 260px;">
                                        <a href="{{ route('admin.post.show', ['id' => $post->id]) }}" title="{{ $post->title }}"
                                            class="d-inline-block text-truncate font-weight-bold" style="max-width: 100%;">
                                            {{ $post->title }}
                                        </a>
                                    </td>

                                    <td>{{ $post->user->name ?? '---' }}</td>

                                    <td>{{ $post->category->name ?? '---' }}</td>

                                    <td>
                                        @if($post->status == 'approved')
                                            <span
                                                style="color:#16a34a;background:#dcfce7;padding:4px 12px;border-radius:999px;font-size:13px;font-weight:600;">
                                                Đã duyệt
                                            </span>
                                        @elseif($post->status == 'pending')
                                            <span
                                                style="color:#d97706;background:#fef3c7;padding:4px 12px;border-radius:999px;font-size:13px;font-weight:600;">
                                                Đang chờ duyệt
                                            </span>
                                        @else
                                            <span
                                                style="color:#dc2626;background:#fee2e2;padding:4px 12px;border-radius:999px;font-size:13px;font-weight:600;">
                                                Từ chối
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($post->is_visible_admin)
                                            <span class="btn btn-sm btn-outline-success font-weight-bold disabled">
                                                <i class="fa fa-eye"></i> Đã hiển thị
                                            </span>
                                        @else
                                            <span class="btn btn-sm btn-outline-secondary font-weight-bold disabled">
                                                <i class="fa fa-eye-slash"></i> Đã ẩn
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.post.show', ['id' => $post->id]) }}"
                                            class="btn btn-sm btn-outline-primary font-weight-bold">
                                            <i class="fa fa-search"></i> Xem chi tiết
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
                    infoEmpty: "Không có dữ liệu",
                    zeroRecords: "Không tìm thấy bài viết phù hợp",
                    infoFiltered: "(lọc từ _MAX_ bài viết)",
                    paginate: {
                        previous: "Trước",
                        next: "Sau"
                    }
                }
            });
        });
    </script>
@endpush