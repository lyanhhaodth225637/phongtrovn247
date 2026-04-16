@extends('layouts.admin.app')

@section('content')
    <style>
        .avatar-wrapper {
            position: relative;
            width: 110px;
            height: 110px;
            margin: 0 auto 1rem;
        }

        .avatar-wrapper img {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #4e73df;
            box-shadow: 0 4px 12px rgba(78, 115, 223, .25);
        }

        .avatar-btn {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #4e73df;
            border: 2px solid #fff;
            color: #fff;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .2s;
        }

        .avatar-btn:hover {
            background: #2e59d9;
        }

        .section-label {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: #b7b9cc;
            margin-bottom: .75rem;
        }

        .status-dot {
            font-size: .65rem;
            margin-right: 3px;
        }

        .card-profile {
            border-right: 1px solid #e3e6f0;
        }

        @media(max-width:991px) {
            .card-profile {
                border-right: none;
                border-bottom: 1px solid #e3e6f0;
            }
        }
    </style>

    <form id="createForm" action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="card shadow">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-plus mr-2"></i>Thêm người dùng
                </h6>
                <small class="text-muted">Tạo tài khoản mới</small>
            </div>

            <div class="card-body p-0">
                <div class="row no-gutters">
                    <!-- LEFT -->
                    <div class="col-lg-3 p-4 text-center card-profile">
                        <p class="section-label">
                            <i class="fas fa-image mr-1"></i>Ảnh đại diện
                        </p>

                        <div class="avatar-wrapper">
                            <img id="avatarPreview"
                                src="{{ asset('storage/default/avt_default.png') }}"
                                alt="Avatar">

                            <label class="avatar-btn mb-0" for="avatarInput" title="Chọn ảnh">
                                <i class="fas fa-camera"></i>
                            </label>

                            <input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none">
                        </div>

                        <h6 class="font-weight-bold text-gray-800 mb-0" id="liveNameDisplay">
                            {{ old('name', 'Tên người dùng') }}
                        </h6>

                        <p class="text-muted small mb-2" id="livePhoneDisplay">
                            {{ old('phone', 'Số điện thoại') }}
                        </p>

                        <div class="mb-2">
                            <span id="liveRoleBadge" class="badge badge-secondary"
                                style="font-size:.8rem;padding:.4em .9em;border-radius:20px;">
                                <i class="fas fa-user mr-1"></i>
                                @switch(old('role'))
                                    @case('admin')
                                        Quản trị
                                    @break

                                    @case('landlord')
                                        Chủ cho thuê
                                    @break

                                    @case('user')
                                        Người dùng
                                    @break

                                    @default
                                        Chưa chọn vai trò
                                @endswitch
                            </span>
                        </div>

                        <div class="mb-3">
                            <span id="liveBadge"
                                class="badge {{ old('status', 'active') == 'active' ? 'badge-success' : (old('status') == 'locked' ? 'badge-warning' : 'badge-danger') }}"
                                style="font-size:.8rem;padding:.4em .9em;border-radius:20px;">
                                @if(old('status', 'active') == 'active')
                                    <i class="fas fa-circle status-dot"></i> Hoạt động
                                @elseif(old('status') == 'locked')
                                    <i class="fas fa-lock mr-1"></i> Đã khóa
                                @else
                                    <i class="fas fa-ban mr-1"></i> Đã cấm
                                @endif
                            </span>
                        </div>

                        <hr>

                        <div class="text-left small text-muted">
                            <div class="mb-1">
                                <i class="fas fa-info-circle mr-1 text-info"></i>
                                Sau khi thêm, tài khoản sẽ được tạo mới trong hệ thống.
                            </div>
                            <div>
                                <i class="fas fa-user-shield mr-1 text-primary"></i>
                                Vai trò sẽ được gán theo lựa chọn bên phải.
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div class="col-lg-9 p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Có lỗi xảy ra:</strong>
                                <ul class="mb-0 mt-2 pl-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <p class="section-label">
                            <i class="fas fa-user mr-1"></i>Thông tin cơ bản
                        </p>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name">Họ và Tên <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        id="name"
                                        name="name"
                                        value="{{ old('name') }}"
                                        required>
                                </div>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="phone">Số Điện Thoại <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="tel"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        id="phone"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        pattern="[0-9]{10,11}"
                                        required>
                                </div>
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        id="email"
                                        name="email"
                                        value=""
                                        required>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="status">Trạng Thái <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                                    </div>
                                    <select class="form-control @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status"
                                        required>
                                        <option value="active" @selected(old('status', 'active') == 'active')>
                                            Hoạt động
                                        </option>
                                        <option value="locked" @selected(old('status') == 'locked')>
                                            Khóa (tạm thời)
                                        </option>
                                        <option value="banned" @selected(old('status') == 'banned')>
                                            Cấm (vĩnh viễn)
                                        </option>
                                    </select>
                                </div>
                                @error('status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <p class="section-label">
                            <i class="fas fa-user-tag mr-1"></i>Vai trò
                        </p>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="role">Chọn vai trò <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-users-cog"></i></span>
                                    </div>
                                    <select class="form-control @error('role') is-invalid @enderror"
                                        id="role"
                                        name="role"
                                        required>
                                        <option value="">-- Chọn vai trò --</option>
                                        <option value="admin" @selected(old('role') == 'admin')>Quản trị</option>
                                        <option value="landlord" @selected(old('role') == 'landlord')>Chủ cho thuê</option>
                                        <option value="user" @selected(old('role') == 'user')>Người dùng</option>
                                    </select>
                                </div>
                                @error('role')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <p class="section-label">
                            <i class="fas fa-lock mr-1"></i>Mật khẩu
                        </p>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="password">Mật Khẩu <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        id="password"
                                        name="password"
                                        placeholder="Nhập mật khẩu"
                                        minlength="6"
                                        required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary toggle-pw" type="button"
                                            data-target="password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror

                                <div class="mt-1" id="strengthWrap" style="display:none;">
                                    <div class="progress" style="height:5px;">
                                        <div id="strengthBar" class="progress-bar" style="width:0%"></div>
                                    </div>
                                    <small id="strengthText" class="text-muted"></small>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="password_confirmation">Xác Nhận Mật Khẩu <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password"
                                        class="form-control"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        placeholder="Nhập lại mật khẩu"
                                        required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary toggle-pw" type="button"
                                            data-target="password_confirmation">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end align-items-center flex-wrap">
                            <div>
                                <a href="{{ route('admin.user') }}" class="btn btn-secondary mr-2">
                                    <i class="fas fa-times mr-1"></i>Hủy
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i>Thêm người dùng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        // Avatar preview
        document.getElementById('avatarInput').addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = e => document.getElementById('avatarPreview').src = e.target.result;
            reader.readAsDataURL(file);
        });

        // Live name + phone
        document.getElementById('name').addEventListener('input', function () {
            document.getElementById('liveNameDisplay').textContent = this.value || 'Tên người dùng';
        });

        document.getElementById('phone').addEventListener('input', function () {
            document.getElementById('livePhoneDisplay').textContent = this.value || 'Số điện thoại';
        });

        // Status badge
        const statusMap = {
            active: { cls: 'badge-success', icon: 'fa-circle', label: 'Hoạt động' },
            locked: { cls: 'badge-warning', icon: 'fa-lock', label: 'Đã khóa' },
            banned: { cls: 'badge-danger', icon: 'fa-ban', label: 'Đã cấm' },
        };

        document.getElementById('status').addEventListener('change', function () {
            const s = statusMap[this.value];
            const b = document.getElementById('liveBadge');

            b.className = `badge ${s.cls}`;
            b.style.cssText = 'font-size:.8rem;padding:.4em .9em;border-radius:20px;';
            b.innerHTML = `<i class="fas ${s.icon} status-dot"></i>${s.label}`;
        });

        // Role badge
        const roleMap = {
            admin: { cls: 'badge-primary', icon: 'fa-user-shield', label: 'Quản trị' },
            landlord: { cls: 'badge-warning', icon: 'fa-home', label: 'Chủ cho thuê' },
            user: { cls: 'badge-secondary', icon: 'fa-user', label: 'Người dùng' },
        };

        document.getElementById('role').addEventListener('change', function () {
            const r = roleMap[this.value];
            const b = document.getElementById('liveRoleBadge');

            if (!r) {
                b.className = 'badge badge-secondary';
                b.style.cssText = 'font-size:.8rem;padding:.4em .9em;border-radius:20px;';
                b.innerHTML = '<i class="fas fa-user mr-1"></i>Chưa chọn vai trò';
                return;
            }

            b.className = `badge ${r.cls}`;
            b.style.cssText = 'font-size:.8rem;padding:.4em .9em;border-radius:20px;';
            b.innerHTML = `<i class="fas ${r.icon} mr-1"></i>${r.label}`;
        });

        // Toggle password
        document.querySelectorAll('.toggle-pw').forEach(button => {
            button.addEventListener('click', function () {
                const target = document.getElementById(this.dataset.target);
                const icon = this.querySelector('i');

                if (target.type === 'password') {
                    target.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    target.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

       
    </script>
@endpush