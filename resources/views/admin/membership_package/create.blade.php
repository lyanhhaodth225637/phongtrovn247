@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">
            <i class="fa-solid fa-calendar-circle-plus"></i> Thêm gói dịch vụ
        </h1>
        <p class="mb-4">Điền đầy đủ thông tin bên dưới để tạo gói dịch vụ mới.</p>

        <!-- Card -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form class="needs-validation" novalidate action="{{ route('admin.membership_package.store') }}" method="POST">
                    @csrf

                    <!-- Gói thành viên -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Gói thành viên <span class="text-danger">*</span></label>
                            <select
                                name="membership_id"
                                class="form-control @error('membership_id') is-invalid @enderror"
                                required>
                                <option value="">-- Chọn gói thành viên --</option>
                                @foreach ($memberships as $membership)
                                    <option
                                        value="{{ $membership->id }}"
                                        {{ old('membership_id') == $membership->id ? 'selected' : '' }}
                                    >
                                        {{ $membership->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('membership_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Số ngày -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Số ngày <span class="text-danger">*</span></label>
                            <input
                                type="number"
                                name="duration_days"
                                class="form-control @error('duration_days') is-invalid @enderror"
                                value="{{ old('duration_days') }}"
                                placeholder="VD: 30, 90, 365..."
                                min="1"
                                required
                            >
                            <small class="form-text text-muted">Thời hạn sử dụng gói tính theo ngày.</small>
                            @error('duration_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Giá -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Giá <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input
                                    type="number"
                                    name="price"
                                    class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price') }}"
                                    placeholder="VD: 99000"
                                    min="0"
                                    step="0.01"
                                    required
                                >
                                <span class="input-group-text">₫</span>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Trạng thái -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Trạng thái</label>
                            <div class="form-check form-switch mt-1">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="is_active"
                                    id="is_active"
                                    value="1"
                                    {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="is_active">Kích hoạt</label>
                            </div>
                            @error('is_active')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Mô tả -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea
                                name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                rows="4"
                                placeholder="Nhập mô tả cho gói dịch vụ..."
                            >{{ old('description') }}</textarea>
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
                                <i class="fas fa-plus"></i> Thêm
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection