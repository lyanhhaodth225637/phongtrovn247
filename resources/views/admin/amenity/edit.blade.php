@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800"><i class="fa-solid fa-calendar-circle-plus"></i> Cập nhật tiện ích
        </h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank"
                href="https://datatables.net">official DataTables documentation</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form class="needs-validation" novalidate
                    action="{{ route('admin.amenity.update', ['id' => $amenity->id, 'slug' => $amenity->slug]) }}"
                    method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Tên danh mục</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ $amenity->name }}" placeholder="Phòng trọ, nhà nguyên căn..." required>

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
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Lưu thay
                                đổi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection