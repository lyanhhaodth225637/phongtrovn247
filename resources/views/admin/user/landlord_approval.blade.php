@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1 text-gray-800">
                    Danh sách yêu cầu xác thực chủ cho thuê
                </h1>

                <p class="mb-0 text-muted">
                    Người dùng đã xác thực email và đang chờ được cấp quyền chủ cho thuê.
                </p>
            </div>

            <span class="badge badge-warning px-3 py-2">
                {{ $users->count() }} yêu cầu
            </span>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    Danh sách chờ duyệt
                </h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="dataTable" width="100%">
                        <thead class="thead-dark">
                            <tr>
                                <th width="5%">#</th>
                                <th>Người dùng</th>
                                <th>Số điện thoại</th>
                                <th>Email đã xác thực</th>
                                <th>Ngày yêu cầu</th>
                                <th width="24%">Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="font-weight-bold text-dark">
                                                    {{ $user->name }}
                                                </div>

                                                <small class="text-muted">
                                                    ID: {{ $user->id }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="text-dark">
                                            {{ $user->phone }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="text-success font-weight-bold">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            {{ $user->email }}
                                        </div>
                                    </td>

                                    <td>
                                        {{ $user->updated_at->format('d/m/Y H:i') }}
                                    </td>

                                    <td>
                                        <div class="d-flex flex-wrap" style="gap: 6px;">
                                            <a href="{{ route('admin.user.show', ['id' => $user->id, 'slug' => $user->slug]) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye mr-1"></i> Chi tiết
                                            </a>

                                            <form action="{{ route('admin.approve_landlord', $user->id) }}"
                                                method="POST"
                                                style="display:inline;">
                                                @csrf

                                                <button type="submit"
                                                    class="btn btn-sm btn-success"
                                                    onclick="return confirm('Xác nhận cấp quyền chủ cho thuê cho {{ $user->name }}?')">
                                                    <i class="fas fa-check mr-1"></i> Duyệt
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        Hiện chưa có yêu cầu xác thực nào.
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
                order: [
                    [4, 'desc']
                ],
                language: {
                    search: "Tìm kiếm:",
                    lengthMenu: "Hiển thị _MENU_ dòng",
                    info: "Hiển thị _START_ - _END_ / _TOTAL_ yêu cầu",
                    zeroRecords: "Không tìm thấy dữ liệu",
                    infoEmpty: "Không có dữ liệu",
                    infoFiltered: "(lọc từ _MAX_ yêu cầu)",
                    paginate: {
                        previous: "Trước",
                        next: "Sau"
                    }
                }
            });
        });
    </script>
@endpush