@extends('layouts.admin.app')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/admin/membership.css') }}">

    <div class="container-fluid ms-page">

        {{-- Header --}}
        <div class="ms-header">
            <div class="ms-header-left">
                <div class="ms-color-dot" style="background-color: {{ $membership->color ?? '#4e73df' }};"></div>
                <div>
                    <h1 class="ms-title">{{ $membership->name }}</h1>
                    <div class="ms-slug">Slug: <code>{{ $membership->slug }}</code></div>
                </div>
            </div>
            <a href="{{ route('admin.membership') }}" class="ms-back-btn">
                <i class="fa-solid fa-angles-left"></i> Quay lại
            </a>
        </div>

        <div class="row g-4">

            {{-- Info card --}}
            <div class="col-xl-4 col-lg-5">
                <div class="ms-info-card">
                    <div class="ms-info-card-header"
                        style="background: linear-gradient(135deg, {{ $membership->color ?? '#4e73df' }}, {{ $membership->color ?? '#4e73df' }}cc);">
                        <i class="fas fa-layer-group" style="color:rgba(255,255,255,.8); font-size:.9rem;"></i>
                        <h6>Thông tin gói thành viên</h6>
                    </div>
                    <div class="ms-info-card-body">
                        <div class="ms-info-row">
                            <span class="ms-info-label">Tên gói</span>
                            <span class="ms-info-value"><strong>{{ $membership->name }}</strong></span>
                        </div>
                        <div class="ms-info-row">
                            <span class="ms-info-label">Slug</span>
                            <span class="ms-info-value"><code
                                    style="background:#f1f3f7;padding:2px 7px;border-radius:5px;font-size:.8rem;">{{ $membership->slug }}</code></span>
                        </div>
                        <div class="ms-info-row">
                            <span class="ms-info-label">Ưu tiên</span>
                            <span class="ms-info-value">
                                <span class="ms-priority-pill">
                                    <i class="fas fa-sort-amount-up" style="font-size:.7rem;"></i>
                                    {{ $membership->priority }}
                                </span>
                            </span>
                        </div>
                        <div class="ms-info-row">
                            <span class="ms-info-label">Màu</span>
                            <span class="ms-info-value">
                                @if($membership->color)
                                    <span class="ms-color-badge" style="background-color: {{ $membership->color }};">
                                        <span class="ms-color-badge-dot"></span>
                                        {{ $membership->color }}
                                    </span>
                                @else
                                    <span style="color:#bcc2cc;">—</span>
                                @endif
                            </span>
                        </div>
                        <div class="ms-info-row">
                            <span class="ms-info-label">Ngày tạo</span>
                            <span class="ms-info-value">{{ $membership->created_at->format('d/m/Y') }}
                                <span
                                    style="color:#9ba5b4;font-size:.8rem;">{{ $membership->created_at->format('H:i') }}</span>
                            </span>
                        </div>
                        <div class="ms-info-row">
                            <span class="ms-info-label">Cập nhật</span>
                            <span class="ms-info-value">{{ $membership->updated_at->format('d/m/Y') }}
                                <span
                                    style="color:#9ba5b4;font-size:.8rem;">{{ $membership->updated_at->format('H:i') }}</span>
                            </span>
                        </div>

                        @if($membership->description)
                            <div class="ms-description-block">
                                <strong>Mô tả</strong>
                                {{ $membership->description }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Packages table --}}
            <div class="col-xl-8 col-lg-7">
                <div class="ms-pkg-card">
                    <div class="ms-pkg-card-header">
                        <h6>
                            <i class="fas fa-cubes" style="color:#4361ee;font-size:.88rem;"></i>
                            Danh sách gói dịch vụ
                            <span class="ms-count-badge">{{ $membership->membershipPackages->count() }}</span>
                        </h6>
                        <a href="{{ route('admin.membership_package.create', ['membership_id' => $membership->id]) }}"
                            class="ms-add-btn">
                            <i class="fas fa-plus" style="font-size:.75rem;"></i> Thêm gói
                        </a>
                    </div>

                    @if($membership->membershipPackages->isEmpty())
                        <div class="ms-empty">
                            <i class="fas fa-box-open"></i>
                            <p>Chưa có gói dịch vụ nào.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="ms-table">
                                <thead>
                                    <tr>
                                        <th style="width:40px;">#</th>
                                        <th>Thời hạn</th>
                                        <th>Giá</th>
                                        <th>Trạng thái</th>
                                        <th>Mô tả</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($membership->membershipPackages->sortBy('duration_days') as $package)
                                        <tr>
                                            <td><span class="ms-num">{{ $loop->iteration }}</span></td>
                                            <td>
                                                <span class="ms-days-val">{{ number_format($package->duration_days) }}</span>
                                                <span class="ms-days-unit">ngày</span>
                                            </td>
                                            <td>
                                                <span class="ms-price">{{ number_format($package->price, 0, ',', '.') }}₫</span>
                                            </td>
                                            <td>
                                                @if($package->is_active)
                                                    <span class="ms-status-on">Kích hoạt</span>
                                                @else
                                                    <span class="ms-status-off">Tạm dừng</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($package->description)
                                                    <span class="ms-desc-text"
                                                        title="{{ $package->description }}">{{ $package->description }}</span>
                                                @else
                                                    <span style="color:#d0d5de;">—</span>
                                                @endif
                                            </td>
                                            <td><a href="{{ route('admin.membership_package.edit', ['id' => $package->id]) }}"
                                                    class="btn btn-sm btn-outline-warning fw-bold" title="Sửa">
                                                    <i class="fa fa-edit"></i> Sửa
                                                </a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

@endsection