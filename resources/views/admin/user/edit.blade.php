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

        .verify-badge {
            font-size: .72rem;
            padding: .3em .65em;
            border-radius: 20px;
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
    <form id="editForm" action="{{ route('admin.user.update',['id'=>$user->id,'slug'=>$user->slug]) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <div class="card shadow">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-id-card mr-2"></i>Thông tin người dùng
                </h6>
                <small class="text-muted">ID: <strong>#{{ $user->id }}</strong></small>
            </div>
            <div class="card-body p-0">
                <div class="row no-gutters">
                    <!-- LEFT -->
                    <div class="col-lg-3 p-4 text-center card-profile">
                        <p class="section-label"><i class="fas fa-image mr-1"></i>Ảnh đại diện</p>
                        <div class="avatar-wrapper">
                            <img id="avatarPreview"
                                src="{{ asset('storage/'.($user->avatar ?? 'default/avt_default.png')) }}" alt="Avatar">
                            <label class="avatar-btn mb-0" for="avatarInput" title="Đổi ảnh">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="avatarInput" name="avatar" accept="image/*" class="d-none">
                        </div>

                        <h6 class="font-weight-bold text-gray-800 mb-0" id="liveNameDisplay">{{ $user->name }}</h6>
                        <p class="text-muted small mb-2" id="liveEmailDisplay">{{ $user->phone }}</p>

                        <div class="mb-2">
                            <span id="liveRoleBadge" class="badge badge-primary"
                                style="font-size:.8rem;padding:.4em .9em;border-radius:20px;">
                                <i class="fas fa-user-shield mr-1"></i>
                                @if($user->hasRole('admin'))
                                    Quản trị
                                @elseif($user->hasRole('landlord'))
                                    Chủ cho thuê
                                @else
                                    Người dùng
                                @endif
                            </span>
                        </div>
                        <div class="mb-3">
                            <span id="liveBadge"
                                class="badge @if($user->status=='active') badge-success
                                @elseif($user->status=='locked') badge-warning
                                @else badge-danger
                                @endif"
                                style="font-size:.8rem;padding:.4em .9em;border-radius:20px;">

                                @if($user->status=='active')
                                    <i class="fas fa-circle status-dot"></i> Hoạt động
                                @elseif($user->status=='locked')
                                    <i class="fas fa-lock"></i> Đã khóa
                                @else
                                    <i class="fas fa-ban"></i> Đã cấm
                                @endif

                            </span>
                        </div>
                        <hr>
                        <p class="section-label"><i class="fas fa-clock mr-1"></i>Timestamps</p>
                        <div class="text-left small text-muted">
                            <div class="mb-1"><i class="fas fa-plus-circle mr-1 text-success"></i><strong>Tạo:</strong>
                                {{ $user->created_at->format('d/m/Y H:i') }}</div>
                            <div><i class="fas fa-edit mr-1 text-info"></i><strong>Cập nhật:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                    <!-- RIGHT -->
                    <div class="col-lg-9 p-4">
                        <p class="section-label"><i class="fas fa-user mr-1"></i>Thông tin cơ bản</p>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name">Họ và Tên <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-user"></i></span></div>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name',$user->name) }}"
                                        required>
                                    <div class="invalid-feedback">Vui lòng nhập họ và tên.</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="phone">Số Điện Thoại <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-phone"></i></span></div>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone }}"
                                        pattern="[0-9]{10,11}" required>
                                    <div class="invalid-feedback">SĐT hợp lệ gồm 10–11 chữ số.</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-envelope"></i></span></div>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}" required>
                                    <div class="invalid-feedback">Vui lòng nhập email hợp lệ.</div>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="status">Trạng Thái <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-toggle-on"></i></span></div>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>
                                            Hoạt động
                                        </option>

                                        <option value="locked" {{ $user->status == 'locked' ? 'selected' : '' }}>
                                            Khóa (tạm thời)
                                        </option>

                                        <option value="banned" {{ $user->status == 'banned' ? 'selected' : '' }}>
                                            Cấm (vĩnh viễn)
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- VAI TRÒ - chỉ là select -->
                        <p class="section-label"><i class="fas fa-user-tag mr-1"></i>Vai trò</p>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="role">Chọn vai trò <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-users-cog"></i></span></div>
                                   <select class="form-control" id="role" name="role" required>
                                        <option value="">-- Chọn vai trò --</option>
                                        <option value="admin"
                                            @selected(old('role', $user->getRoleNames()->first()) == 'admin')>
                                            Quản trị
                                        </option>
                                        @if(auth()->id() != $user->id)
                                            <option value="landlord"
                                                @selected(old('role', $user->getRoleNames()->first()) == 'landlord')>
                                                Chủ cho thuê
                                            </option>
                                            <option value="user"
                                                @selected(old('role', $user->getRoleNames()->first()) == 'user')>
                                                Người dùng
                                            </option>
                                        @endif

                                    </select>                     
                                    <div class="invalid-feedback">Vui lòng chọn vai trò.</div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <p class="section-label"><i class="fas fa-lock mr-1"></i>Đổi mật khẩu <small
                                class="text-muted font-weight-normal">(để trống nếu không đổi)</small></p>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="password">Mật Khẩu Mới</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-key"></i></span></div>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Nhập mật khẩu mới" minlength="6">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary toggle-pw" type="button"
                                            data-target="password"><i class="fas fa-eye"></i></button>
                                    </div>
                                    <div class="invalid-feedback">Mật khẩu phải có ít nhất 6 ký tự.</div>
                                </div>
                                <div class="mt-1" id="strengthWrap" style="display:none;">
                                    <div class="progress" style="height:5px;">
                                        <div id="strengthBar" class="progress-bar" style="width:0%"></div>
                                    </div>
                                    <small id="strengthText" class="text-muted"></small>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="password_confirmation">Xác Nhận Mật Khẩu</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-key"></i></span></div>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Nhập lại mật khẩu">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary toggle-pw" type="button"
                                            data-target="password_confirmation"><i class="fas fa-eye"></i></button>
                                    </div>
                                    <div class="invalid-feedback" id="confirmFeedback">Mật khẩu không khớp.</div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                data-target="#deleteModal">
                                <i class="fas fa-trash-alt mr-1"></i>Xóa người dùng
                            </button>
                            <div>
                                <a href="#" class="btn btn-secondary mr-2"><i class="fas fa-times mr-1"></i>Hủy</a>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Lưu thay
                                    đổi</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle mr-2"></i>Xác nhận xóa</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Bạn có chắc muốn xóa người dùng <strong id="deleteUserName">Nguyễn Văn A</strong>?
                    Hành động này <strong class="text-danger">không thể hoàn tác</strong>.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fas fa-times mr-1"></i>Hủy</button>
                    <button type="button" class="btn btn-danger"><i class="fas fa-trash-alt mr-1"></i>Xóa</button>
                </div>
            </div>
        </div>
    </div>
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
            admin: { cls: 'badge-primary', icon: 'fa-user-shield', label: 'Quản trị người dùng' },
            landlord: { cls: 'badge-warning', icon: 'fa-home', label: 'Chủ cho thuê' },
            user: { cls: 'badge-secondary', icon: 'fa-user', label: 'Người dùng' },
        };
        document.getElementById('role').addEventListener('change', function () {
            const r = roleMap[this.value];
            const b = document.getElementById('liveRoleBadge');
            if (!r) { b.className = 'badge badge-light'; b.innerHTML = '—'; return; }
            b.className = `badge ${r.cls}`;
            b.style.cssText = 'font-size:.8rem;padding:.4em .9em;border-radius:20px;';
            b.innerHTML = `<i class="fas ${r.icon} mr-1"></i>${r.label}`;
        });


    </script>
@endpush