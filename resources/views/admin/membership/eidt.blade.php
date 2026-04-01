@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">
            <i class="fa-solid fa-calendar-circle-plus"></i> Cập nhật gói dịch vụ
        </h1>
        <p class="mb-4">Điền đầy đủ thông tin bên dưới để tạo gói dịch vụ mới.</p>

        <!-- Card -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form class="needs-validation" novalidate action="{{ route('admin.membership.update',['id'=>$membership->id, 'slug' => $membership->slug]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Tên gói -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Tên gói <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ $membership->name }}"
                                placeholder="VD: Free, Basic, Pro..." required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Ưu tiên -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Ưu tiên</label>
                            <input type="number" name="priority"
                                class="form-control @error('priority') is-invalid @enderror"
                                value="{{ $membership->priority }}"  min="0">
                            <small class="form-text text-muted">Số càng lớn thì hiển thị càng ưu tiên.</small>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Màu tiêu đề -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Màu tiêu đề</label>
                            <div class="input-group">
                                <input type="color" name="color" id="colorPicker"
                                    class="form-control form-control-color @error('color') is-invalid @enderror"
                                    value="{{ old('color', '#4e73df') }}" title="Chọn màu" style="max-width: 60px;">
                                <input type="text" id="colorText" class="form-control @error('color') is-invalid @enderror"
                                    value="{{ $membership->color }}" placeholder="#4e73df" maxlength="7">
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">Mã màu HEX, VD: #4e73df</small>
                        </div>
                    </div>

                    <!-- Mô tả -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                rows="4" placeholder="Nhập mô tả cho gói dịch vụ...">{{ $membership->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <a href="{{ route('admin.membership') }}" class="btn btn-secondary">
                                <i class="fa-solid fa-angles-left"></i> Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Cập nhật
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>

        // Đồng bộ color picker <-> text input
        const colorPicker = document.getElementById('colorPicker');
        const colorText = document.getElementById('colorText');

        colorPicker.addEventListener('input', function () {
            colorText.value = this.value;
        });

        colorText.addEventListener('input', function () {
            if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                colorPicker.value = this.value;
            }
        });
    </script>
@endsection