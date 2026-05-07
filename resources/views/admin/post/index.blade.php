@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh Sách Bài Viết</h1>
        <p class="mb-4">
            Quản lý toàn bộ bài viết trong hệ thống, bao gồm trạng thái duyệt, hiển thị và thao tác quản trị.
        </p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between flex-wrap gap-2">
                    <div class="d-flex gap-2">
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
                                <th style="width: 5%">STT</th>
                                <th>Tiêu Đề</th>
                                <th>Người Đăng</th>
                                <th>Danh Mục</th>
                                <th>Trạng Thái</th>
                                <th>Hiển Thị</th>
                                <th>Duyệt</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($posts->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Không có bài viết nào
                                    </td>
                                </tr>
                            @endif

                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td style="max-width: 250px;">
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
                                                style="color: #16a34a; background: #dcfce7; padding: 4px 12px; border-radius: 999px; font-size: 13px; font-weight: 600;">
                                                Đã duyệt
                                            </span>
                                        @elseif($post->status == 'pending')
                                            <span
                                                style="color: #d97706; background: #fef3c7; padding: 4px 12px; border-radius: 999px; font-size: 13px; font-weight: 600;">
                                                Đang chờ duyệt
                                            </span>
                                        @else
                                            <span
                                                style="color: #dc2626; background: #fee2e2; padding: 4px 12px; border-radius: 999px; font-size: 13px; font-weight: 600;">
                                                Từ chối
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($post->is_visible_admin)
                                            <form action="{{ route('admin.post.hide', $post->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit" class="btn btn-sm btn-outline-success font-weight-bold"
                                                    onclick="return confirm('Bạn có chắc muốn ẩn bài viết này?')">
                                                    <i class="fa fa-eye"></i> Đã hiển thị
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.post.show-post', $post->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit" class="btn btn-sm btn-outline-secondary font-weight-bold"
                                                    onclick="return confirm('Bạn có muốn hiển thị lại bài viết này?')">
                                                    <i class="fa fa-eye-slash"></i> Đã ẩn
                                                </button>
                                            </form>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.post.show', ['id' => $post->id]) }}"
                                            class="btn btn-sm btn-outline-primary font-weight-bold" title="Duyệt bài">
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
                    zeroRecords: "Không tìm thấy dữ liệu",
                    infoEmpty: "Không có dữ liệu",
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