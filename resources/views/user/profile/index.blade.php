@extends('layouts.user.app')

@section('content')
    <style>
        /* PROFILE PAGE */
        .profile-wrap {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Avatar card */
        .profile-avatar-card {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .profile-avatar-top {
            background: linear-gradient(135deg, #0f1e4a 0%, #0d6efd 100%);
            padding: 28px 20px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
        }

        .profile-avatar-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .profile-avatar {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, .6);
            display: block;
        }

        .avatar-edit-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--gold);
            border: 2px solid #fff;
            color: #fff;
            font-size: .65rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: filter .15s;
        }

        .avatar-edit-btn:hover {
            filter: brightness(1.1);
        }

        .profile-avatar-info {
            flex: 1;
            min-width: 0;
        }

        .profile-user-name {
            font-family: 'Sora', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-user-phone {
            font-size: .75rem;
            color: rgba(255, 255, 255, .75);
            margin-bottom: 2px;
        }

        .profile-user-id {
            font-size: .68rem;
            color: rgba(255, 255, 255, .5);
        }

        .profile-status-row {
            display: flex;
            gap: 8px;
            padding: 12px 16px;
            flex-wrap: wrap;
            border-bottom: 1px solid var(--border);
        }

        .profile-stat-chip {
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 7px 12px;
            flex: 1;
            min-width: 90px;
        }

        .profile-stat-chip i {
            font-size: .9rem;
            color: var(--primary);
        }

        .profile-stat-label {
            font-size: .65rem;
            color: var(--muted);
            margin-bottom: 1px;
        }

        .profile-stat-value {
            font-size: .82rem;
            font-weight: 700;
            color: var(--text);
        }

        /* Section card */
        .profile-section {
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .profile-section-head {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 18px;
            border-bottom: 1.5px solid var(--border);
            background: #f8fafc;
        }

        .profile-section-head i {
            font-size: 1rem;
            color: var(--primary);
            width: 20px;
            flex-shrink: 0;
        }

        .profile-section-title {
            font-size: .85rem;
            font-weight: 700;
            color: var(--text);
            flex: 1;
        }

        .profile-section-body {
            padding: 18px;
        }

        /* Form fields */
        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-label-custom {
            display: block;
            font-size: .75rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .form-label-custom .required {
            color: #e02424;
            margin-left: 2px;
        }

        .form-control-custom {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: .86rem;
            color: var(--text);
            background: var(--surface);
            outline: none;
            transition: border-color .18s, box-shadow .18s;
        }

        .form-control-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, .1);
        }

        .form-control-custom::placeholder {
            color: #adb5bd;
        }

        .form-control-custom:disabled {
            background: #f8fafc;
            color: var(--muted);
            cursor: not-allowed;
        }

        .form-control-custom.is-invalid {
            border-color: #e02424;
        }

        .form-hint {
            font-size: .7rem;
            color: #94a3b8;
            margin-top: 4px;
        }

        /* Input with icon */
        .input-icon-wrap {
            position: relative;
        }

        .input-icon-wrap .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: .85rem;
            pointer-events: none;
        }

        .input-icon-wrap .form-control-custom {
            padding-left: 36px;
        }

        /* Verify badge */
        .verify-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 6px;
            flex-wrap: wrap;
        }

        .badge-verified {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: .67rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .badge-unverified {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: .67rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 20px;
            background: #fff7ed;
            color: #c2410c;
            border: 1px solid #fed7aa;
        }

        .btn-verify-link {
            font-size: .72rem;
            font-weight: 600;
            color: var(--primary);
            text-decoration: none;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .btn-verify-link:hover {
            text-decoration: underline;
        }

        /* Password fields */
        .pw-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: .9rem;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            z-index: 2;
        }

        .pw-toggle:hover {
            color: var(--text);
        }

        /* Danger zone */
        .danger-zone-card {
            background: var(--surface);
            border: 1.5px solid #fecaca;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .danger-zone-head {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            border-bottom: 1px solid #fecaca;
            background: #fff1f2;
        }

        .danger-zone-head i {
            font-size: .95rem;
            color: #e02424;
        }

        .danger-zone-head span {
            font-size: .85rem;
            font-weight: 700;
            color: #9f1239;
        }

        .danger-zone-body {
            padding: 16px 18px;
        }

        .danger-zone-desc {
            font-size: .8rem;
            color: #6b7280;
            line-height: 1.65;
            margin-bottom: 14px;
        }

        /* Submit / action buttons */
        .btn-save {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-family: 'Be Vietnam Pro', sans-serif;
            font-weight: 700;
            font-size: .85rem;
            padding: 10px 20px;
            cursor: pointer;
            transition: background .18s, transform .1s;
            white-space: nowrap;
        }

        .btn-save:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-save:disabled {
            opacity: .6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-outline-danger {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: transparent;
            color: #e02424;
            border: 1.5px solid #e02424;
            border-radius: var(--radius-sm);
            font-family: 'Be Vietnam Pro', sans-serif;
            font-weight: 700;
            font-size: .82rem;
            padding: 9px 16px;
            cursor: pointer;
            transition: background .15s, color .15s;
            white-space: nowrap;
            text-decoration: none;
        }

        .btn-outline-danger:hover {
            background: #fff1f2;
            color: #e02424;
        }

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
            margin-top: 16px;
            flex-wrap: wrap;
        }

        /* Account info row */
        .account-info-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .account-info-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
            gap: 12px;
        }

        .account-info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .account-info-label {
            font-size: .75rem;
            color: var(--muted);
            font-weight: 600;
            flex-shrink: 0;
            min-width: 120px;
        }

        .account-info-value {
            font-size: .85rem;
            color: var(--text);
            font-weight: 500;
            text-align: right;
            flex: 1;
        }

        #avatarInput {
            display: none;
        }

        .toast-success {
            position: fixed;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: #111;
            color: #fff;
            font-size: .82rem;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 99px;
            z-index: 9999;
            opacity: 0;
            transition: opacity .25s, transform .25s;
            white-space: nowrap;
            pointer-events: none;
        }

        .toast-success.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        @media (max-width: 576px) {
            .form-row-2 {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .profile-avatar {
                width: 60px;
                height: 60px;
            }

            .profile-user-name {
                font-size: .92rem;
            }

            .profile-section-body {
                padding: 14px;
            }

            .profile-section-head {
                padding: 11px 14px;
            }

            .account-info-label {
                min-width: 100px;
                font-size: .7rem;
            }

            .account-info-value {
                font-size: .8rem;
            }

            .form-actions {
                justify-content: stretch;
            }

            .form-actions .btn-save {
                flex: 1;
                justify-content: center;
            }
        }

        @media (max-width: 400px) {
            .profile-status-row {
                gap: 6px;
            }

            .profile-stat-chip {
                padding: 6px 10px;
            }

            .profile-stat-value {
                font-size: .75rem;
            }
        }
    </style>

    <div class="profile-wrap">

        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3"
                style="font-size:.84rem;border-radius:var(--radius-sm)">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3"
                style="font-size:.84rem;border-radius:var(--radius-sm)">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
            </div>
        @endif

        <div class="profile-avatar-card">
            <div class="profile-avatar-top">
                <div class="profile-avatar-wrap">
                    <img src="{{ asset('storage/' . (auth()->user()->avatar ?? 'default/avt_default.png')) }}"
                        class="profile-avatar" id="avatarPreview" alt="avatar">
                    <label for="avatarInput" class="avatar-edit-btn" title="Đổi ảnh đại diện">
                        <i class="bi bi-camera-fill"></i>
                    </label>
                    <input type="file" id="avatarInput" name="avatar" accept="image/*" onchange="previewAvatar(this)">
                </div>
                <div class="profile-avatar-info">
                    <div class="profile-user-name">{{ auth()->user()->name }}</div>
                    <div class="profile-user-phone">{{ auth()->user()->phone }}</div>
                    <div class="profile-user-id">Mã tài khoản: #{{ auth()->user()->id }}</div>
                </div>
            </div>

            <div class="profile-status-row">
                <div class="profile-stat-chip">
                    <i class="bi bi-wallet2"></i>
                    <div>
                        <div class="profile-stat-label">Số dư</div>
                        <div class="profile-stat-value">{{ number_format(auth()->user()->balance ?? 0, 0, ',', '.') }}đ
                        </div>
                    </div>
                </div>
                <div class="profile-stat-chip">
                    <i class="bi bi-shield-check"></i>
                    <div>
                        <div class="profile-stat-label">Trạng thái</div>
                        <div class="profile-stat-value"
                            style="color:{{ auth()->user()->status === 'active' ? '#15803d' : '#e02424' }}">
                            {{ match (auth()->user()->status) {
        'active' => 'Hoạt động',
        'locked' => 'Tạm khóa',
        'banned' => 'Bị cấm',
        default => auth()->user()->status,
    } }}
                        </div>
                    </div>
                </div>
                <div class="profile-stat-chip">
                    <i class="bi bi-clock-history"></i>
                    <div>
                        <div class="profile-stat-label">Tham gia</div>
                        <div class="profile-stat-value">{{ auth()->user()->created_at->format('m/Y') }}</div>
                    </div>
                </div>
                <div class="profile-stat-chip">
                    <i class="bi bi-check2-circle"></i>
                    <div>
                        <div class="profile-stat-label">Đã nạp tiền</div>
                        <div class="profile-stat-value">{{ auth()->user()->has_deposited ? 'Rồi' : 'Chưa' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('frontend.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
            @csrf
            @method('PUT')

            <input type="file" id="avatarInput" name="avatar" accept="image/jpeg,image/png,image/webp" style="display:none"
                onchange="previewAvatar(this)">

            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label-custom">Họ và tên <span class="required">*</span></label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="name"
                            class="form-control-custom {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            placeholder="Nhập họ và tên" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>
                    @error('name')<div class="form-hint" style="color:#e02424">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label-custom">Số điện thoại</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-telephone input-icon"></i>
                        <input type="text" class="form-control-custom" value="{{ auth()->user()->phone }}" disabled>
                    </div>
                    <div class="verify-row">
                        @if(auth()->user()->phone_verified_at)
                            <span class="badge-verified"><i class="bi bi-patch-check-fill"></i> Đã xác thực</span>
                        @else
                            <span class="badge-unverified"><i class="bi bi-exclamation-circle-fill"></i> Chưa xác thực</span>
                            <a href="#" class="btn-verify-link">Xác thực ngay</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label class="form-label-custom">Email</label>
                    <div class="input-icon-wrap">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email"
                            class="form-control-custom {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            placeholder="email@example.com" value="{{ old('email', auth()->user()->email) }}">
                    </div>
                    <div class="verify-row">
                        @if(auth()->user()->email_verified_at)
                            <span class="badge-verified"><i class="bi bi-patch-check-fill"></i> Đã xác thực</span>
                        @else
                            <span class="badge-unverified"><i class="bi bi-exclamation-circle-fill"></i> Chưa xác thực</span>
                            @if(auth()->user()->email)
                                <a href="#" class="btn-verify-link">Gửi lại email</a>
                            @endif
                        @endif
                    </div>
                    @error('email')<div class="form-hint" style="color:#e02424">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label-custom">Ảnh đại diện</label>
                    <div style="display:flex;align-items:center;gap:10px">
                        <img src="{{ asset('storage/' . (auth()->user()->avatar ?? 'default/avt_default.png')) }}"
                            style="width:38px;height:38px;border-radius:50%;object-fit:cover;border:1.5px solid var(--border);flex-shrink:0"
                            id="avatarPreview2" alt="">
                        <label for="avatarInput"
                            style="display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-size:.78rem;font-weight:600;color:var(--text2);cursor:pointer;transition:border-color .15s,color .15s;white-space:nowrap">
                            <i class="bi bi-upload"></i> Chọn ảnh
                        </label>
                    </div>
                    <div class="form-hint" id="avatarFileName">JPG, PNG, WEBP — tối đa 2MB</div>
                    @error('avatar')<div class="form-hint" style="color:#e02424">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save" id="saveProfileBtn">
                    <i class="bi bi-check-lg"></i> Lưu thay đổi
                </button>
            </div>
        </form>

        <div class="profile-section">
            <div class="profile-section-head">
                <i class="bi bi-lock-fill"></i>
                <span class="profile-section-title">Đổi mật khẩu</span>
            </div>
            <div class="profile-section-body">
                <form action="{{ route('frontend.profile.password') }}" method="POST" id="passwordForm">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="form-label-custom">Mật khẩu hiện tại <span class="required">*</span></label>
                        <div class="input-icon-wrap" style="position:relative">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" name="current_password" id="currentPw"
                                class="form-control-custom {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                                placeholder="Nhập mật khẩu hiện tại" style="padding-right:40px">
                            <button type="button" class="pw-toggle" onclick="togglePw('currentPw', this)">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        @error('current_password')<div class="form-hint" style="color:#e02424">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label class="form-label-custom">Mật khẩu mới <span class="required">*</span></label>
                            <div class="input-icon-wrap" style="position:relative">
                                <i class="bi bi-lock-fill input-icon"></i>
                                <input type="password" name="password" id="newPw"
                                    class="form-control-custom {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    placeholder="Tối thiểu 8 ký tự" style="padding-right:40px">
                                <button type="button" class="pw-toggle" onclick="togglePw('newPw', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')<div class="form-hint" style="color:#e02424">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label-custom">Xác nhận mật khẩu <span class="required">*</span></label>
                            <div class="input-icon-wrap" style="position:relative">
                                <i class="bi bi-lock-fill input-icon"></i>
                                <input type="password" name="password_confirmation" id="confirmPw"
                                    class="form-control-custom" placeholder="Nhập lại mật khẩu mới"
                                    style="padding-right:40px">
                                <button type="button" class="pw-toggle" onclick="togglePw('confirmPw', this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-hint" style="margin-bottom:4px">
                        <i class="bi bi-info-circle me-1"></i>
                        Mật khẩu tối thiểu 8 ký tự, nên kết hợp chữ hoa, chữ thường và số.
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-save">
                            <i class="bi bi-shield-lock"></i> Cập nhật mật khẩu
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="profile-section">
            <div class="profile-section-head">
                <i class="bi bi-info-circle-fill"></i>
                <span class="profile-section-title">Thông tin tài khoản</span>
            </div>
            <div class="profile-section-body">
                <div class="account-info-list">
                    <div class="account-info-row">
                        <span class="account-info-label">Mã tài khoản</span>
                        <span class="account-info-value"
                            style="font-family:monospace;font-size:.8rem">#{{ auth()->user()->id }}</span>
                    </div>
                    <div class="account-info-row">
                        <span class="account-info-label">Ngày tham gia</span>
                        <span class="account-info-value">{{ auth()->user()->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="account-info-row">
                        <span class="account-info-label">Số dư tài khoản</span>
                        <span class="account-info-value"
                            style="color:var(--primary);font-weight:700">{{ number_format(auth()->user()->balance ?? 0) }}đ</span>
                    </div>
                    <div class="account-info-row">
                        <span class="account-info-label">Trạng thái</span>
                        <span class="account-info-value">
                            @if(auth()->user()->status === 'active')
                                <span class="badge-verified"><i class="bi bi-check-circle-fill"></i> Đang hoạt động</span>
                            @elseif(auth()->user()->status === 'locked')
                                <span class="badge-unverified"><i class="bi bi-lock-fill"></i> Tạm khóa</span>
                            @else
                                <span
                                    style="display:inline-flex;align-items:center;gap:4px;font-size:.67rem;font-weight:700;padding:3px 9px;border-radius:20px;background:#fee2e2;color:#991b1b;border:1px solid #fca5a5"><i
                                        class="bi bi-x-circle-fill"></i> Bị cấm</span>
                            @endif
                        </span>
                    </div>
                    <div class="account-info-row">
                        <span class="account-info-label">Xác thực SĐT</span>
                        <span class="account-info-value">
                            @if(auth()->user()->phone_verified_at)
                                <span class="badge-verified"><i class="bi bi-patch-check-fill"></i>
                                    {{ auth()->user()->phone_verified_at->format('d/m/Y') }}</span>
                            @else
                                <span class="badge-unverified"><i class="bi bi-exclamation-circle-fill"></i> Chưa xác
                                    thực</span>
                            @endif
                        </span>
                    </div>
                    <div class="account-info-row">
                        <span class="account-info-label">Xác thực Email</span>
                        <span class="account-info-value">
                            @if(auth()->user()->email_verified_at)
                                <span class="badge-verified"><i class="bi bi-patch-check-fill"></i>
                                    {{ auth()->user()->email_verified_at->format('d/m/Y') }}</span>
                            @else
                                <span class="badge-unverified"><i class="bi bi-exclamation-circle-fill"></i> Chưa xác
                                    thực</span>
                            @endif
                        </span>
                    </div>
                    @if(auth()->user()->referred_by)
                        <div class="account-info-row">
                            <span class="account-info-label">Được giới thiệu bởi</span>
                            <span class="account-info-value">#{{ auth()->user()->referred_by }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="danger-zone-card">
            <div class="danger-zone-head">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>Vùng nguy hiểm</span>
            </div>
            <div class="danger-zone-body">
                <p class="danger-zone-desc">
                    Xóa tài khoản sẽ xóa vĩnh viễn toàn bộ dữ liệu của bạn bao gồm tin đăng, lịch sử giao dịch và số dư tài
                    khoản. Hành động này <strong>không thể hoàn tác</strong>.
                </p>
                <button type="button" class="btn-outline-danger" onclick="confirmDeleteAccount()">
                    <i class="bi bi-trash3-fill"></i> Xóa tài khoản
                </button>
            </div>
        </div>

    </div>

    <div class="toast-success" id="profileToast"></div>
@endsection

@push('scripts')
    <script>
        function previewAvatar(input) {
            if (!input.files || !input.files[0]) return;
            var file = input.files[0];
            if (file.size > 2 * 1024 * 1024) {
                alert('Ảnh không được vượt quá 2MB');
                input.value = '';
                return;
            }
            var reader = new FileReader();
            reader.onload = function (e) {
                var src = e.target.result;
                document.getElementById('avatarPreview').src = src;
                document.getElementById('avatarPreview2').src = src;
            };
            reader.readAsDataURL(file);

            var dt = new DataTransfer();
            dt.items.add(file);
            document.querySelector('form#profileForm input[name="avatar"]').files = dt.files;

            var fileNameEl = document.getElementById('avatarFileName');
            if (fileNameEl) {
                fileNameEl.textContent = file.name;
            }
        }

        function togglePw(inputId, btn) {
            var input = document.getElementById(inputId);
            var icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        function confirmDeleteAccount() {
            if (confirm('Bạn chắc chắn muốn xóa tài khoản? Hành động này không thể hoàn tác!')) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('frontend.profile.delete') }}';
                form.innerHTML = '@csrf @method("DELETE")';
                document.body.appendChild(form);
                form.submit();
            }
        }

        @if(session('success'))
            (function () {
                var t = document.getElementById('profileToast');
                t.textContent = '{{ session("success") }}';
                t.classList.add('show');
                setTimeout(function () { t.classList.remove('show'); }, 3000);
            })();
        @endif
    </script>
@endpush