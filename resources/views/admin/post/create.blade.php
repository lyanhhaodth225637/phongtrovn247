@extends('layouts.admin.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/post-create.css') }}">
<div class="container">

    {{-- ── Page Heading ──────────────────────────────────────── --}}
    <div class="page-heading">
        <div>
            <h1><i class="fas fa-edit" style="color:var(--primary);margin-right:.5rem"></i>Đăng Tin Mới</h1>
            <p>Điền đầy đủ thông tin để tin đăng được duyệt nhanh hơn</p>
        </div>
        <a href="#" class="btn btn-outline-primary"><i class="fas fa-eye"></i> Xem hướng dẫn</a>
    </div>

    {{-- ── Sentinel (cho IntersectionObserver) ──────────────── --}}
    <div id="stepsSentinel" style="height:1px;margin-top:-1px;pointer-events:none"></div>

    {{-- ── Steps Bar — STICKY ────────────────────────────────── --}}
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

    <form action="" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        {{-- ── Card 1: Loại chuyên mục ─────────────────────── --}}
        <div class="card" id="section-1">
            <div class="card-header">
                <i class="fas fa-tag"></i>
                <h6>Loại Danh Mục</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="category">
                        Loại Danh mục <span class="required">*</span>
                    </label>

                    <select
                        id="category"
                        name="category"
                        class="form-control @error('category') is-invalid @enderror"
                        style="max-width:400px"
                        required>

                        <option value="">-- Chọn danh mục --</option>

                        @foreach ($categories as $category)
                            <option 
                                value="{{ $category->id }}"
                                {{ old('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

       {{-- ── Card 2: Khu vực ──────────────────────────────── --}}
        <div class="card" id="section-2">
            <div class="card-header">
                <i class="fas fa-map-marker-alt"></i>
                <h6>Khu Vực</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label" for="province">
                                Tỉnh/Thành phố <span class="required">*</span>
                            </label>
                            {{-- Input hiển thị + datalist gợi ý --}}
                            <input
                                type="text"
                                id="province"
                                class="form-control @error('province') is-invalid @enderror"
                                placeholder="-- Tìm hoặc chọn tỉnh/thành --"
                                autocomplete="off"
                                list="province-list"
                                value="{{ old('province_name') }}"
                                required
                            >
                            <datalist id="province-list">
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->name }}" data-id="{{ $province->id }}">
                                @endforeach
                            </datalist>
                            {{-- Hidden input lưu id thật --}}
                            <input type="hidden" name="province" id="province_id_input"
                                value="{{ old('province') }}">
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
        
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label" for="ward_input">Phường/Xã</label>
                            <input
                                type="text"
                                id="ward"
                                class="form-control @error('ward') is-invalid @enderror"
                                placeholder="-- Tìm hoặc chọn phường/xã --"
                                autocomplete="off"
                                list="ward-list"
                                value="{{ old('ward_name') }}"
                                disabled
                            >
                            <datalist id="ward-list"></datalist>
                            {{-- Hidden input lưu code thật --}}
                            <input type="hidden" name="ward" id="ward_code_input"
                                value="{{ old('ward') }}">
                            @error('ward')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
        
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Số nhà/tên đường</label>
                            <input type="text" name="house_number" id="houseNumber"
                                class="form-control" value="{{ old('house_number') }}"
                                placeholder="VD: 123 Nguyễn Huệ" maxlength="100">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Địa chỉ</label>
                            <div class="form-control-static" id="fullAddressDisplay">
                                {{ old('full_address', '-- Chọn tỉnh/thành và phường/xã --') }}
                            </div>
                            <input type="hidden" name="address" id="fullAddressInput"
                                value="{{ old('address') }}">
                        </div>
                    </div>
                </div>
                {{-- Map --}}
                <div style="margin-top:.5rem">
                    <label class="form-label">
                        <i class="fas fa-map" style="color:var(--primary);margin-right:.4rem"></i>Bản đồ
                        <span style="font-weight:400;color:var(--secondary);font-size:.75rem">
                            — Click vào bản đồ để ghim vị trí
                        </span>
                    </label>
                    <div class="map-placeholder">
                        <div id="map" style="height: 380px; border-radius: 8px;"></div>
                    </div>
                    <input type="" name="latitude"  id="latitude"  value="{{ old('latitude') }}">
                    <input type="" name="longitude" id="longitude" value="{{ old('longitude') }}">
                </div>
            </div>
        </div>
        {{-- ── Card 3: Thông tin mô tả ──────────────────────── --}}
        <div class="card" id="section-3">
            <div class="card-header">
                <i class="fas fa-info-circle"></i>
                <h6>Thông Tin Mô Tả</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="title">
                        Tiêu đề <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        class="form-control @error('title') is-invalid @enderror"
                        placeholder="Nhập tiêu đề bài đăng..."
                        value="{{ old('title') }}"
                        required
                        minlength="30"
                        maxlength="100"
                    >
                    <div class="char-hint">
                        Tối thiểu 30 ký tự, tối đa 100 ký tự
                        &nbsp;—&nbsp;<span id="titleCount">0</span>/100
                    </div>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                {{-- CKEditor 5 --}}
                <div class="form-group">
                    <label class="form-label" for="description">
                        Nội dung mô tả <span class="required">*</span>
                    </label>
                    <!-- CKEditor sẽ thay thế div này -->
                    <div id="description-editor"
                         class="@error('description') border border-danger @enderror"
                         style="min-height: 400px; border: 1px solid #ced4da; border-radius: 4px; background: #fff;">
                        {!! old('description') !!}
                    </div>
                    <!-- Hidden input để gửi dữ liệu thật sự khi submit -->
                    <input type="hidden" 
                           name="description" 
                           id="description-hidden" 
                           value="{{ old('description') }}">
                    <div class="char-hint">
                        Tối thiểu 50 ký tự, tối đa 5000 ký tự
                        &nbsp;—&nbsp;<span id="descCount">0</span>/5000
                    </div>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label" for="price">
                                Giá cho thuê <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <input
                                    type="number"
                                    id="price"
                                    name="price"
                                    class="form-control @error('price') is-invalid @enderror"
                                    placeholder="VD: 2000000"
                                    value="{{ old('price') }}"
                                    required
                                    min="0"
                                    max="999999999"
                                >
                                <div class="input-group-append">
                                    <select name="price_unit">
                                        <option value="month" {{ old('price_unit','month') == 'month' ? 'selected' : '' }}>đ/tháng</option>
                                        <option value="day"   {{ old('price_unit') == 'day'   ? 'selected' : '' }}>đ/ngày</option>
                                    </select>
                                </div>
                            </div>
                            <div class="char-hint">Ví dụ: 1 triệu → nhập 1000000</div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label" for="area">
                                Diện tích <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <input
                                    type="number"
                                    id="area"
                                    name="area"
                                    class="form-control @error('area') is-invalid @enderror"
                                    placeholder="VD: 25"
                                    value="{{ old('area') }}"
                                    required
                                    min="1"
                                    max="10000"
                                >
                                <div class="input-group-append">
                                    <span class="input-group-text">m²</span>
                                 </div>
                            </div>
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- ── Card 4: Tiện ích nổi bật ─────────────────────── --}}
        <div class="card" id="section-4">
            <div class="card-header">
                <i class="fas fa-star"></i>
                <h6>Tiện Ích Nổi Bật</h6>
            </div>
            <div class="card-body">
                <div class="features-grid">
                    @foreach ($amenities as $amenity)
                        <label class="feature-check">
                            <input
                                type="checkbox"
                                name="amenities[]"
                                value="{{ $amenity->id }}"
                                {{ in_array($amenity->id, $postAmenities ?? []) ? 'checked' : '' }}
                            >
                            <span>{{ $amenity->name }}</span>
                        </label>
                    @endforeach

                </div>
            </div>
        </div>
        {{-- ── Card 5: Hình ảnh ────────────────────────────── --}}
        <div class="card" id="section-5">
            <div class="card-header">
                <i class="fas fa-images"></i>
                <h6>Hình Ảnh</h6>
            </div>
            <div class="card-body">
                <div class="upload-zone" id="uploadZone">
                    <i class="fas fa-camera"></i>
                    <p>
                        <button type="button" class="btn-link"
                            onclick="document.getElementById('imgInput').click()">
                            Tải ảnh từ thiết bị
                        </button>
                    </p>
                    <p style="font-size:.75rem;color:var(--secondary)">Hoặc kéo thả ảnh vào đây</p>
                    <input
                        type="file"
                        id="imgInput"
                        name="images[]"
                        multiple
                        accept="image/jpeg,image/png,image/webp"
                        style="display:none"
                    >
                </div>
                {{-- Preview grid --}}
                <div class="img-preview-grid" id="previewGrid"></div>

                @error('images')
                    <div class="invalid-feedback" style="display:block">{{ $message }}</div>
                @enderror
                @error('images.*')
                    <div class="invalid-feedback" style="display:block">{{ $message }}</div>
                @enderror

                <ul class="upload-hints">
                    <li>Tải lên tối đa 20 ảnh trong một bài đăng</li>
                    <li>Dung lượng ảnh tối đa 10MB/ảnh</li>
                    <li>Hình ảnh phải liên quan đến phòng trọ, nhà cho thuê</li>
                    <li>Không chèn văn bản, số điện thoại lên ảnh</li>
                </ul>
            </div>
        </div>

        {{-- ── Card 6: Thông tin liên hệ ───────────────────── --}}
        <div class="card" id="section-6">
            <div class="card-header">
                <i class="fas fa-address-card"></i>
                <h6>Thông Tin Liên Hệ</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label" for="contact_name">Họ tên</label>
                            <input
                                type="text"
                                id="contact_name"
                                name="name"
                                class="form-control @error('contact_name') is-invalid @enderror"
                                value="{{ old('contact_name', auth()->user()->name ?? '') }}"
                                required
                                maxlength="100"
                            >
                            @error('contact_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label" for="contact_phone">Số điện thoại</label>
                            <input
                                type="tel"
                                id="contact_phone"
                                name="phone"
                                class="form-control @error('contact_phone') is-invalid @enderror"
                                value="{{ old('contact_phone', auth()->user()->phone ?? '') }}"
                                required
                                pattern="[0-9]{9,11}"
                                maxlength="11"
                            >
                            @error('contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Action Bar ───────────────────────────────────── --}}
        <div class="action-bar">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
            <button type="submit" class="btn-next">
                Đăng tin <i class="fas fa-arrow-right"></i>
            </button>
        </div>

    </form>
</div>
@endsection

@push('scripts')

<!-- CKEditor 5 Classic -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="{{ asset('js/admin/post-create-ckeditor.js') }}"></script>
<script>document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault(); // chặn submit thật

    const formData = new FormData(this);
    const obj = {};
    formData.forEach((value, key) => {
        if (obj[key]) {
            // Nếu key trùng (vd: features[]) thì gộp thành mảng
            if (!Array.isArray(obj[key])) obj[key] = [obj[key]];
            obj[key].push(value);
        } else {
            obj[key] = value;
        }
    });

    console.table(obj);
    console.log('FormData đầy đủ:', obj);
});</script>
@endpush