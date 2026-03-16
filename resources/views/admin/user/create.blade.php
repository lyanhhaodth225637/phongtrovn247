@extends('layouts.admin.app')
@section('content')
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image">

                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Đăng ký tài khoản</h1>
                            </div>
                            <form class="user" id="registerForm" novalidate>
                                <!-- Họ và Tên -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control form-control-user" id="fullName"
                                            placeholder="Họ và Tên" required>
                                        <div class="invalid-feedback">Vui lòng nhập họ và tên.</div>
                                    </div>
                                </div>

                                <!-- Số điện thoại -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="tel" class="form-control form-control-user" id="phone"
                                            placeholder="Số Điện Thoại" pattern="[0-9]{10,11}" required>
                                        <div class="invalid-feedback">Vui lòng nhập số điện thoại hợp lệ (10-11 số).</div>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control form-control-user" id="email"
                                            placeholder="Địa Chỉ Email" required>
                                        <div class="invalid-feedback">Vui lòng nhập email hợp lệ.</div>
                                    </div>
                                </div>

                                <!-- Mật khẩu & Xác nhận mật khẩu -->
                                <div class="form-group">

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        </div>
                                        <input type="password" class="form-control form-control-user" id="password"
                                            placeholder="Mật Khẩu" minlength="6" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary toggle-pw" type="button"
                                                data-target="password">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="invalid-feedback">Mật khẩu phải có ít nhất 6 ký tự.</div>
                                    </div>


                                </div>

                                <!-- Thông báo lỗi chung -->
                                <div id="alertBox" class="alert d-none" role="alert"></div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    <i class="fas fa-user-plus mr-2"></i>Đăng Ký Tài Khoản
                                </button>

                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection