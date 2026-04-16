@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Sao lưu và khôi phục</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-3 d-flex gap-2">
            <form action="{{ route('admin.backup.run') }}" method="POST">
                @csrf
                <button class="btn btn-primary">
                    <i class="fas fa-database"></i> Tạo backup
                </button>
            </form>

            <form action="{{ route('admin.backup.clean') }}" method="POST">
                @csrf
                <button class="btn btn-danger">
                    <i class="fas fa-trash"></i> Dọn backup cũ
                </button>
            </form>
        </div>

        <div class="card shadow">
            <div class="card-header">
                Danh sách file backup
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Tên file</th>
                            <th>Kích thước</th>
                            <th>Ngày tạo</th>
                            <th width="120">Tải về</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($files as $file)
                            <tr>
                                <td>{{ $file->getFilename() }}</td>
                                <td>{{ number_format($file->getSize() / 1024 / 1024, 2) }} MB</td>
                                <td>{{ date('d/m/Y H:i', $file->getCTime()) }}</td>
                                <td>
                                    <a href="{{ route('admin.backup.download', $file->getFilename()) }}"
                                        class="btn btn-success btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Chưa có file backup nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection