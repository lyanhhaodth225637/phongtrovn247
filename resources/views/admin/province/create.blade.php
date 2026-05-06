@extends('layouts.admin.app')
<!-- @section('title', 'Con Cặc') -->

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">
            <i class="fa-solid fa-calendar-circle-plus"></i> Thêm Tỉnh/Thành Phố
        </h1>
        <p class="mb-4">
            Nhập thông tin tỉnh hoặc thành phố mới vào hệ thống.
        </p>

        <!-- Form -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form class="needs-validation" novalidate action="{{ route('admin.province.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="form-row">
                        <!-- Tên Tỉnh/Thành Phố -->
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Tên Tỉnh/Thành Phố</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                id="name" value="{{ old('name') }}" placeholder="Nhập tên tỉnh/thành phố" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Loại -->
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Loại</label>
                            <select class="form-control custom-select @error('type') is-invalid @enderror" name="type"
                                id="type" required>
                                <option selected disabled value="">-- Chọn loại --</option>
                                <option value="province" {{ old('type') == 'province' ? 'selected' : '' }}>Tỉnh</option>
                                <option value="city" {{ old('type') == 'city' ? 'selected' : '' }}>Thành Phố</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Nút Submit -->
                    <div class="form-row">
                        <div class="col-12">
                            <a href="{{ route('admin.province') }}" class="btn btn-secondary ml-2">
                                <i class="fa-solid fa-angles-left"></i> Quay lại
                            </a>

                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-plus"></i> Thêm
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection