<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Logo --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-house"></i>
        </div>
        <div class="sidebar-brand-text mx-2">{{ config('app.name') }}</div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- Tổng quan --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tổng quan</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    {{-- ================= KIỂM DUYỆT ================= --}}
    <div class="sidebar-heading">
        Kiểm duyệt
    </div>

    {{-- Bài đăng --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseModerationPosts">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Bài đăng</span>
        </a>

        <div id="collapseModerationPosts" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Kiểm duyệt bài viết</h6>

                <a class="collapse-item" href="{{ route('admin.post') }}">
                    Tất cả bài đăng
                </a>

                <a class="collapse-item" href="{{ route('admin.post.pending') }}">
                    Chờ duyệt
                </a>

                <a class="collapse-item" href="{{ route('admin.post.approved') }}">
                    Đã duyệt
                </a>

                <a class="collapse-item" href="{{ route('admin.post.rejected') }}">
                    Bị từ chối
                </a>
            </div>
        </div>
    </li>

    {{-- Chủ cho thuê --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLandlord">
            <i class="fas fa-fw fa-user-check"></i>
            <span>Chủ cho thuê</span>
        </a>

        <div id="collapseLandlord" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Kiểm duyệt landlord</h6>

                <a class="collapse-item" href="{{ route('admin.approve_landlord.index') }}">
                    Danh sách yêu cầu
                </a>

                <a class="collapse-item" href="{{ route('admin.approve_landlord.index-approved') }}">
                    Đã phê duyệt
                </a>


            </div>
        </div>
    </li>

    {{-- Bình luận / tố cáo --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseComment">
            <i class="fas fa-fw fa-flag"></i>
            <span>Bình luận & tố cáo</span>
        </a>

        <div id="collapseComment" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Nội dung người dùng</h6>

                <a class="collapse-item" href="#">
                    Bình luận
                </a>

                <a class="collapse-item" href="{{ route('admin.post_reports.index') }}">
                    Tố cáo vi phạm
                </a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    {{-- ================= QUẢN LÝ ================= --}}
    <div class="sidebar-heading">
        Quản lý
    </div>

    {{-- Người dùng --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers">
            <i class="fas fa-fw fa-users"></i>
            <span>Người dùng</span>
        </a>

        <div id="collapseUsers" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Quản lý tài khoản</h6>

                <a class="collapse-item" href="{{ route('admin.user') }}">
                    Tất cả người dùng
                </a>



                <a class="collapse-item" href="{{ route('admin.user.lock') }}">
                    Tài khoản bị khóa
                </a>
            </div>
        </div>
    </li>

    {{-- Địa điểm --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLocation">
            <i class="fas fa-fw fa-map-marker-alt"></i>
            <span>Địa điểm</span>
        </a>

        <div id="collapseLocation" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Dữ liệu vị trí</h6>

                <a class="collapse-item" href="{{ route('admin.province') }}">
                    Tỉnh / Thành phố
                </a>

                <a class="collapse-item" href="{{ route('admin.ward') }}">
                    Xã / Phường
                </a>

                <a class="collapse-item" href="{{ route('admin.location') }}">
                    Địa điểm nổi bật
                </a>
            </div>
        </div>
    </li>

    {{-- Danh mục --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory">
            <i class="fas fa-fw fa-th-list"></i>
            <span>Danh mục</span>
        </a>

        <div id="collapseCategory" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Danh mục hệ thống</h6>

                <a class="collapse-item" href="{{ route('admin.category') }}">
                    Danh mục
                </a>

                <a class="collapse-item" href="{{ route('admin.amenity') }}">
                    Tiện ích
                </a>
            </div>
        </div>
    </li>

    {{-- Gói dịch vụ --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMembership">
            <i class="fas fa-fw fa-crown"></i>
            <span>Gói thành viên</span>
        </a>

        <div id="collapseMembership" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Quản lý membership</h6>
                <a class="collapse-item" href="{{ route('admin.user_membership') }}">
                    Danh sách đăng ký gói
                </a>

                <a class="collapse-item" href="{{ route('admin.membership') }}">
                    Danh sách gói
                </a>

                <a class="collapse-item" href="{{ route('admin.membership_package.create') }}">
                    Thêm gói
                </a>

                <a class="collapse-item" href="{{ route('admin.membership.demo') }}">
                    Demo hiển thị
                </a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    {{-- ================= TÀI CHÍNH ================= --}}
    <div class="sidebar-heading">
        Tài chính
    </div>

    {{-- Duyệt nạp --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseWallet">
            <i class="fas fa-fw fa-wallet"></i>
            <span>Duyệt nạp tiền</span>
        </a>

        <div id="collapseWallet" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Quản lý giao dịch</h6>

                <a class="collapse-item" href="{{ route('admin.wallet_notifications.index') }}">
                    Yêu cầu nạp tiền
                </a>
                <a class="collapse-item" href="{{ route('admin.system-wallet') }}">
                    Ví hệ thống
                </a>
            </div>
        </div>
    </li>

    {{-- Báo cáo --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Báo cáo & thống kê</span>
        </a>

        <div id="collapseReport" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Thống kê hệ thống</h6>

                <a class="collapse-item" href="#">
                    Doanh thu
                </a>

                <a class="collapse-item" href="#">
                    Bài đăng
                </a>

                <a class="collapse-item" href="#">
                    Người dùng
                </a>

                <a class="collapse-item" href="#">
                    Gói dịch vụ
                </a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    {{-- ================= HỆ THỐNG ================= --}}
    <div class="sidebar-heading">
        Hệ thống
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSystem">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Cấu hình hệ thống</span>
        </a>

        <div id="collapseSystem" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Quản trị hệ thống</h6>

                <a class="collapse-item" href="#">
                    Vai trò & quyền
                </a>

                <a class="collapse-item" href="{{ route('admin.activity_log.index') }}">
                    Nhật ký hoạt động
                </a>

                <a class="collapse-item" href="{{ route('admin.notifications.index') }}">
                    Thông báo hệ thống
                </a>

                <a class="collapse-item" href="{{ route('admin.backup.index') }}">
                    Sao lưu và khôi phục
                </a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    {{-- Thu gọn sidebar --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>