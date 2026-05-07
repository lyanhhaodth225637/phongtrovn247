@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">
            <i class="fa-solid fa-calendar-circle-plus"></i>
            Thêm danh mục - loại hình cho thuê
        </h1>

        <p class="mb-4">
            Nhập thông tin danh mục loại hình cho thuê mới vào hệ thống.
        </p>

        <!-- Form -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form class="needs-validation" novalidate action="{{ route('admin.category.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Tên danh mục</label>

                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="Phòng trọ, nhà nguyên căn..." required>

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="row mt-3">
                        <div class="col-12">

                            <a href="{{ route('admin.category') }}" class="btn btn-secondary">
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