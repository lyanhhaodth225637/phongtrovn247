@extends('layouts.user.app')

@push('styles')
    <style>
        /* POST CREATE
           Inline styles, dùng chung var() từ home.css
           Không còn phụ thuộc post-create.css
        */

        /* Container */
        .pc-wrap {
            padding: 1.5rem 0 4rem;
            max-width: 900px;
            margin: 0 auto;
        }

        /* Page Heading */
        .page-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: .75rem;
        }

        .page-heading h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text);
            margin: 0 0 .2rem;
        }

        .page-heading p {
            font-size: .8rem;
            color: var(--muted);
            margin: 0;
        }

        /* Steps Container - Sticky */
        .steps-container {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            padding: 1rem 1.5rem;
            margin-bottom: 1.25rem;
            position: sticky;
            top: 68px;
            z-index: 999;
            transition: box-shadow .2s, border-color .2s;
        }

        .steps-container.is-stuck {
            box-shadow: 0 .3rem 1.5rem rgba(0, 0, 0, .13);
            border-bottom-color: var(--primary);
        }

        .steps {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            position: relative;
        }

        .steps::before {
            content: '';
            position: absolute;
            top: 17px;
            left: calc(18px + 2.5%);
            right: calc(18px + 2.5%);
            height: 2px;
            background: var(--border);
            z-index: 0;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .4rem;
            flex: 1;
            position: relative;
            z-index: 999;
            text-decoration: none;
            cursor: pointer;
        }

        .step-circle {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--surface);
            border: 2px solid var(--border);
            color: var(--muted);
            font-weight: 700;
            font-size: .8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .22s;
        }

        .step-label {
            font-size: .7rem;
            font-weight: 600;
            color: var(--muted);
            text-align: center;
            white-space: nowrap;
        }

        .step.done .step-circle {
            background: #16a34a;
            border-color: #16a34a;
            color: #fff;
        }

        .step.done .step-label {
            color: #16a34a;
        }

        .step.active .step-circle {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, .18);
        }

        .step.active .step-label {
            color: var(--primary);
            font-weight: 700;
        }

        /* Card */
        .pc-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.25rem;
            overflow: hidden;
            transition: box-shadow .2s;
        }

        .pc-card:hover {
            box-shadow: var(--shadow-hover);
        }

        .pc-card-header {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .85rem 1.25rem;
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 1.5px solid var(--border);
        }

        .pc-card-header i {
            color: var(--primary);
            font-size: .95rem;
            width: 18px;
            text-align: center;
        }

        .pc-card-header h6 {
            font-size: .875rem;
            font-weight: 700;
            color: var(--text);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .pc-card-body {
            padding: 1.25rem;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: .8rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: .4rem;
        }

        .required {
            color: #e74a3b;
            margin-left: .15rem;
        }

        .char-hint {
            font-size: .72rem;
            color: var(--muted);
            margin-top: .3rem;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: .45rem .85rem;
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: .85rem;
            color: var(--text);
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            transition: border-color .15s, box-shadow .15s;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, .12);
        }

        .form-control.is-invalid {
            border-color: #e74a3b;
        }

        .invalid-feedback {
            color: #e74a3b;
            font-size: .75rem;
            margin-top: .25rem;
            display: block;
        }

        select.form-control {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right .7rem center;
            background-size: 14px;
            padding-right: 2.2rem;
            cursor: pointer;
        }

        .form-control-static {
            display: block;
            padding: .45rem .85rem;
            font-size: .82rem;
            color: var(--muted);
            background: #f8fafc;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            min-height: 34px;
        }

        /* Input Group */
        .input-group {
            display: flex;
            align-items: stretch;
        }

        .input-group .form-control {
            border-radius: var(--radius-sm) 0 0 var(--radius-sm);
            flex: 1;
        }

        .input-group-append {
            display: flex;
        }

        .input-group-append select,
        .input-group-append span,
        .input-group-append div {
            padding: .45rem .75rem;
            background: #f1f5f9;
            border: 1.5px solid var(--border);
            border-left: 0;
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
            font-size: .82rem;
            color: var(--muted);
            font-family: 'Be Vietnam Pro', sans-serif;
            white-space: nowrap;
            display: flex;
            align-items: center;
        }

        .input-group-append select {
            cursor: pointer;
            appearance: none;
            padding-right: 1.5rem;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%2394a3b8' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right .4rem center;
            background-size: 12px;
        }

        /* Grid */
        .pc-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -.6rem;
        }

        .pc-col-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 .6rem;
        }

        @media (max-width: 600px) {
            .pc-col-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }

        /* Map */
        .map-placeholder {
            border: 2px dashed var(--border);
            border-radius: var(--radius);
            background: #f8fafc;
            padding: .5rem;
        }

        #map {
            height: 380px;
            width: 100%;
            border-radius: 6px;
        }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
            gap: .6rem;
        }

        .feature-check {
            display: flex;
            align-items: center;
            gap: .5rem;
            padding: .5rem .75rem;
            background: #f8fafc;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: border-color .15s, background .15s;
            user-select: none;
        }

        .feature-check:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .feature-check input[type="checkbox"] {
            width: 15px;
            height: 15px;
            accent-color: var(--primary);
            cursor: pointer;
            flex-shrink: 0;
            margin: 0;
        }

        .feature-check span {
            font-size: .8rem;
            font-weight: 600;
            color: var(--text);
            cursor: pointer;
            line-height: 1.3;
        }

        .feature-check:has(input:checked) {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .feature-check:has(input:checked) span {
            color: var(--primary);
        }

        /* Upload Zone */
        .upload-zone {
            border: 2px dashed var(--border);
            border-radius: var(--radius);
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            gap: .5rem;
            text-align: center;
            cursor: pointer;
            transition: border-color .2s, background .2s;
        }

        .upload-zone:hover,
        .upload-zone.dragging {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .upload-zone i {
            font-size: 2.2rem;
            color: var(--primary);
            opacity: .6;
        }

        .upload-zone p {
            margin: 0;
            font-size: .82rem;
            color: var(--muted);
        }

        .btn-link {
            background: none;
            border: none;
            color: var(--primary);
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: .82rem;
            font-weight: 700;
            cursor: pointer;
            padding: 0;
            text-decoration: underline;
        }

        .img-preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 8px;
            margin-top: 12px;
        }

        .img-preview-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: var(--radius-sm);
            overflow: hidden;
            border: 1.5px solid var(--border);
        }

        .img-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .img-preview-item .remove-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            border: none;
            background: rgba(0, 0, 0, .55);
            color: #fff;
            font-size: 13px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .15s;
        }

        .img-preview-item .remove-btn:hover {
            background: #e74a3b;
        }

        .upload-hints {
            list-style: none;
            padding: 0;
            margin: .75rem 0 0;
            display: flex;
            flex-direction: column;
            gap: .3rem;
        }

        .upload-hints li {
            font-size: .78rem;
            color: var(--muted);
            padding-left: 1rem;
            position: relative;
        }

        .upload-hints li::before {
            content: '•';
            position: absolute;
            left: 0;
            color: var(--primary);
        }

        /* Buttons */
        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .6rem 2rem;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: .9rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(13, 110, 253, .3);
            transition: background .18s, transform .15s, box-shadow .18s;
            text-decoration: none;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(13, 110, 253, .4);
            color: #fff;
        }

        .btn-outline-primary {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .45rem 1rem;
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: .82rem;
            font-weight: 700;
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--primary);
            color: var(--primary);
            background: transparent;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: #fff;
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-hover);
            padding: 1rem 1.25rem;
            position: sticky;
            bottom: 1rem;
            z-index: 400;
            margin-bottom: 2rem;
        }
    </style>
@endpush

@section('content')
    <div class="pc-wrap">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="page-heading">
            <div>
                <h1><i class="bi bi-pencil-square" style="color:var(--primary);margin-right:.5rem"></i>Đăng Tin Mới</h1>
                <p>Điền đầy đủ thông tin để tin đăng được duyệt nhanh hơn</p>
            </div>
            <a href="#" class="btn-outline-primary"><i class="bi bi-eye"></i> Xem hướng dẫn</a>
        </div>

        <div class="steps-container" id="stepsContainer">
            <div class="steps">
                <a href="#section-1" class="step">
                    <div class="step-circle">1</div>
                    <div class="step-label">Danh mục</div>
                </a>
                <a href="#section-2" class="step">
                    <div class="step-circle">2</div>
                    <div class="step-label">Khu vực</div>
                </a>
                <a href="#section-3" class="step">
                    <div class="step-circle">3</div>
                    <div class="step-label">Mô tả</div>
                </a>
                <a href="#section-4" class="step">
                    <div class="step-circle">4</div>
                    <div class="step-label">Tiện ích</div>
                </a>
                <a href="#section-5" class="step">
                    <div class="step-circle">5</div>
                    <div class="step-label">Hình ảnh</div>
                </a>
                <a href="#section-6" class="step">
                    <div class="step-circle">6</div>
                    <div class="step-label">Liên hệ</div>
                </a>
            </div>
        </div>

        <form id="postCreateForm" action="{{ route('user.post.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <div class="pc-card" id="section-1">
                <div class="pc-card-header">
                    <i class="bi bi-tag-fill"></i>
                    <h6>Loại Danh Mục</h6>
                </div>
                <div class="pc-card-body">
                    <div class="form-group">
                        <label class="form-label" for="category_id">Loại danh mục <span class="required">*</span></label>
                        <select id="category_id" name="category_id"
                            class="form-control @error('category_id') is-invalid @enderror"
                            style="max-width:400px" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pc-card" id="section-2">
                <div class="pc-card-header">
                    <i class="bi bi-geo-alt-fill"></i>
                    <h6>Khu Vực</h6>
                </div>
                <div class="pc-card-body">
                    <div class="pc-row">
                        <div class="pc-col-6">
                            <div class="form-group">
                                <label class="form-label" for="province">Tỉnh/Thành phố <span class="required">*</span></label>
                                <input type="text" id="province"
                                    class="form-control @error('province') is-invalid @enderror"
                                    placeholder="-- Tìm hoặc chọn tỉnh/thành --"
                                    autocomplete="off"
                                    list="province-list"
                                    value="{{ old('province_name') }}"
                                    required>
                                <datalist id="province-list">
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->name }}" data-id="{{ $province->id }}"></option>
                                    @endforeach
                                </datalist>
                                <input type="hidden" name="province" id="province_id_input" value="{{ old('province') }}">
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="pc-col-6">
                            <div class="form-group">
                                <label class="form-label" for="ward">Phường/Xã</label>
                                <input type="text" id="ward"
                                    class="form-control @error('ward_id') is-invalid @enderror"
                                    placeholder="-- Tìm hoặc chọn phường/xã --"
                                    autocomplete="off"
                                    list="ward-list"
                                    value="{{ old('ward_name') }}"
                                    disabled>
                                <datalist id="ward-list"></datalist>
                                <input type="hidden" name="ward_id" id="ward_code_input" value="{{ old('ward_id') }}">
                                @error('ward_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="pc-col-6">
                            <div class="form-group">
                                <label class="form-label">Số nhà / tên đường</label>
                                <input type="text" name="house_number" id="houseNumber" class="form-control"
                                    value="{{ old('house_number') }}"
                                    placeholder="VD: 123 Nguyễn Huệ"
                                    maxlength="100">
                            </div>
                        </div>

                        <div class="pc-col-6">
                            <div class="form-group">
                                <label class="form-label">Địa chỉ đầy đủ</label>
                                <div class="form-control-static" id="fullAddressDisplay">
                                    {{ old('address', '-- Chọn tỉnh/thành và phường/xã --') }}
                                </div>
                                <input type="hidden" name="address" id="fullAddressInput" value="{{ old('address') }}">
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:.75rem">
                        <label class="form-label">
                            <i class="bi bi-map" style="color:var(--primary);margin-right:.4rem"></i>Bản đồ
                            <span style="font-weight:400;color:var(--muted);font-size:.75rem">— Click để ghim vị trí chính xác</span>
                        </label>
                        <div class="map-placeholder">
                            <div id="map"></div>
                        </div>
                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                    </div>
                </div>
            </div>

            <div class="pc-card" id="section-3">
                <div class="pc-card-header">
                    <i class="bi bi-info-circle-fill"></i>
                    <h6>Thông Tin Mô Tả</h6>
                </div>
                <div class="pc-card-body">
                    <div class="form-group">
                        <label class="form-label" for="title">Tiêu đề <span class="required">*</span></label>
                        <input type="text" id="title" name="title"
                            class="form-control @error('title') is-invalid @enderror"
                            placeholder="Nhập tiêu đề bài đăng..."
                            value="{{ old('title') }}"
                            required minlength="30" maxlength="100">
                        <div class="char-hint">
                            Tối thiểu 30 ký tự, tối đa 100 ký tự — <span id="titleCount">{{ strlen(old('title', '')) }}</span>/100
                        </div>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nội dung mô tả <span class="required">*</span></label>
                        <div id="description-editor" class="@error('description') border border-danger @enderror"
                            style="min-height:400px;border:1.5px solid var(--border);border-radius:var(--radius-sm);background:var(--surface);">
                            {!! old('description') !!}
                        </div>
                        <input type="hidden" name="description" id="description-hidden" value="{{ old('description') }}">
                        <div class="char-hint">
                            Tối thiểu 50 ký tự, tối đa 5000 ký tự — <span id="descCount">0</span>/5000
                        </div>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="pc-row">
                        <div class="pc-col-6">
                            <div class="form-group">
                                <label class="form-label" for="price">Giá cho thuê <span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="number" id="price" name="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        placeholder="VD: 2000000"
                                        value="{{ old('price') }}"
                                        required min="0" max="999999999">
                                    <div class="input-group-append">
                                        <select name="price_unit">
                                            <option value="month" {{ old('price_unit', 'month') == 'month' ? 'selected' : '' }}>đ/tháng</option>
                                            <option value="day" {{ old('price_unit') == 'day' ? 'selected' : '' }}>đ/ngày</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="char-hint">Ví dụ: 1 triệu → nhập 1000000</div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="pc-col-6">
                            <div class="form-group">
                                <label class="form-label" for="area">Diện tích <span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="number" id="area" name="area"
                                        class="form-control @error('area') is-invalid @enderror"
                                        placeholder="VD: 25"
                                        value="{{ old('area') }}"
                                        required min="1" max="10000">
                                    <div class="input-group-append"><span>m²</span></div>
                                </div>
                                @error('area')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pc-card" id="section-4">
                <div class="pc-card-header">
                    <i class="bi bi-stars"></i>
                    <h6>Tiện Ích Nổi Bật</h6>
                </div>
                <div class="pc-card-body">
                    <div class="features-grid">
                        @foreach ($amenities as $amenity)
                            <label class="feature-check">
                                <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                                    {{ in_array($amenity->id, old('amenities', [])) ? 'checked' : '' }}>
                                <span>{{ $amenity->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="pc-card" id="section-5">
                <div class="pc-card-header">
                    <i class="bi bi-images"></i>
                    <h6>Hình Ảnh</h6>
                </div>
                <div class="pc-card-body">
                    <div class="upload-zone" id="uploadZone">
                        <i class="bi bi-camera"></i>
                        <p>
                            <button type="button" class="btn-link" onclick="document.getElementById('imgInput').click()">
                                Tải ảnh từ thiết bị
                            </button>
                        </p>
                        <p style="font-size:.75rem;color:var(--muted)">Hoặc kéo thả ảnh vào đây</p>
                        <input type="file" id="imgInput" name="images[]" multiple accept="image/jpeg,image/png,image/webp" style="display:none">
                    </div>

                    <div class="img-preview-grid" id="previewGrid"></div>

                    @error('images')
                        <div class="invalid-feedback" style="display:block">{{ $message }}</div>
                    @enderror
                    @error('images.*')
                        <div class="invalid-feedback" style="display:block">{{ $message }}</div>
                    @enderror

                    <ul class="upload-hints">
                        <li>Tải lên tối đa 10 ảnh trong một bài đăng</li>
                        <li>Dung lượng ảnh tối đa 10MB/ảnh</li>
                        <li>Hình ảnh phải liên quan đến phòng trọ, nhà cho thuê</li>
                        <li>Không chèn văn bản, số điện thoại lên ảnh</li>
                    </ul>
                </div>
            </div>

            <div class="pc-card" id="section-6">
                <div class="pc-card-header">
                    <i class="bi bi-person-vcard-fill"></i>
                    <h6>Thông Tin Liên Hệ</h6>
                </div>
                <div class="pc-card-body">
                    <div class="pc-row">
                        <div class="pc-col-6">
                            <div class="form-group">
                                <label class="form-label" for="contact_name">Họ tên</label>
                                <input type="text" id="contact_name" name="contact_name"
                                    class="form-control @error('contact_name') is-invalid @enderror"
                                    value="{{ old('contact_name', auth()->user()->name ?? '') }}"
                                    required maxlength="100">
                                @error('contact_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="pc-col-6">
                            <div class="form-group">
                                <label class="form-label" for="contact_phone">Số điện thoại</label>
                                <input type="tel" id="contact_phone" name="contact_phone"
                                    class="form-control @error('contact_phone') is-invalid @enderror"
                                    value="{{ old('contact_phone', auth()->user()->phone ?? '') }}"
                                    required pattern="[0-9]{9,11}" maxlength="11">
                                @error('contact_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-bar">
                <a href="{{ route('user.post.index') }}" class="btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Hủy
                </a>
                <button type="submit" class="btn-submit">
                    <i class="bi bi-send-fill"></i> Đăng tin ngay
                </button>
            </div>
        </form>
    </div>
@endsection

@push('lib-scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
@endpush

@push('scripts')
    <script src="{{ asset('js/admin/post-create-ckeditor.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('postCreateForm');

            if (!form) return;

            form.addEventListener('submit', function (e) {
                let hasError = false;

                const category = document.getElementById('category_id');
                const province = document.getElementById('province');
                const provinceId = document.getElementById('province_id_input');
                const ward = document.getElementById('ward');
                const wardId = document.getElementById('ward_code_input');
                const title = document.getElementById('title');
                const price = document.getElementById('price');
                const area = document.getElementById('area');
                const contactName = document.getElementById('contact_name');
                const contactPhone = document.getElementById('contact_phone');
                const descriptionHidden = document.getElementById('description-hidden');
                const editor = document.getElementById('description-editor');

                const resetInvalid = (el) => {
                    if (el) el.classList.remove('is-invalid');
                };

                const setInvalid = (el) => {
                    if (el) {
                        el.classList.add('is-invalid');
                        hasError = true;
                    }
                };

                [
                    category, province, ward, title, price, area, contactName, contactPhone
                ].forEach(resetInvalid);

                if (editor) {
                    editor.classList.remove('border-danger');
                }

                if (!category?.value) setInvalid(category);
                if (!provinceId?.value || !province?.value.trim()) setInvalid(province);
                if (!wardId?.value || !ward?.value.trim()) setInvalid(ward);
                if (!title?.value.trim() || title.value.trim().length < 30) setInvalid(title);
                if (!price?.value || Number(price.value) < 0) setInvalid(price);
                if (!area?.value || Number(area.value) < 1) setInvalid(area);
                if (!contactName?.value.trim()) setInvalid(contactName);
                if (!contactPhone?.value.trim()) setInvalid(contactPhone);

                const descText = (descriptionHidden?.value || '').replace(/<[^>]*>/g, '').trim();
                if (!descText || descText.length < 50) {
                    if (editor) editor.classList.add('border-danger');
                    hasError = true;
                }

                if (hasError) {
                    e.preventDefault();
                }
            });

            const titleInput = document.getElementById('title');
            const titleCount = document.getElementById('titleCount');

            if (titleInput && titleCount) {
                const updateTitleCount = () => {
                    titleCount.textContent = titleInput.value.length;
                };
                updateTitleCount();
                titleInput.addEventListener('input', updateTitleCount);
            }

            const descHidden = document.getElementById('description-hidden');
            const descCount = document.getElementById('descCount');

            if (descHidden && descCount) {
                const updateDescCount = () => {
                    const text = descHidden.value.replace(/<[^>]*>/g, '').trim();
                    descCount.textContent = text.length;
                };
                updateDescCount();
                descHidden.addEventListener('input', updateDescCount);
            }
        });
    </script>
@endpush