<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;

use App\Http\Controllers\Admin\HomeController as AdminHome;
use App\Http\Controllers\Admin\ProvincesController as AdminProvince;
use App\Http\Controllers\Admin\WardController as AdminWard;
use App\Http\Controllers\Admin\LocationController as AdminLocation;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;
use App\Http\Controllers\Admin\AmenityController as AdminAmenity;
use App\Http\Controllers\Admin\PostController as AdminPost;
use App\Http\Controllers\Admin\PostModerationController as AdminPostModeration;
use App\Http\Controllers\Admin\MembershipController as AdminMembership;
use App\Http\Controllers\Admin\MembershipPackageController as AdminMembershipPackage;
use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLog;
use App\Http\Controllers\Admin\UserMembershipController as AdminUserMembership;
use App\Http\Controllers\Admin\SystemWalletNotificationController as AdminSystemWalletNotification;
use App\Http\Controllers\Admin\AdminNotificationController as AdminNotification;
use App\Http\Controllers\Admin\LandlordApprovalController as AdminLandlordApproval;
use App\Http\Controllers\Admin\BackupController as AdminBackup;
use App\Http\Controllers\Frontend\PostReportController as FrontendPostReport;
use App\Http\Controllers\Admin\PostReportController as AdminPostReport;

use App\Http\Controllers\User\PostController as UserPost;
use App\Http\Controllers\User\HomeController as UserHome;
use App\Http\Controllers\User\WalletController as UserWallet;
use App\Http\Controllers\User\NotificationController as UserNotification;
use App\Http\Controllers\User\UserMembershipController as UserMembership;
use App\Http\Controllers\User\SavedPostController as UserSavePost;

use App\Http\Controllers\Frontend\HomeController as FrontendHome;
use App\Http\Controllers\Frontend\MembershipController as FrontendMembership;
use App\Http\Controllers\Frontend\ContactController as FrontendContact;
use App\Http\Controllers\Frontend\NewController as FrontendNew;

use App\Http\Controllers\VerifyController;
use App\Http\Controllers\NotificationController;



use App\Http\Controllers\Api\LocationController;

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/admin', [App\Http\Controllers\HomeController::class, 'getAdmin'])->name('admin');

//nhóm user admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('home');

    //tỉnh thành phố
    Route::get('/tinh-thanh-pho', [AdminProvince::class, 'index'])->name('province');
    Route::get('/tinh-thanh-pho/them', [AdminProvince::class, 'create'])->name('province.create');
    Route::post('/tinh-thanh-pho/them', [AdminProvince::class, 'store'])->name('province.store');
    Route::get('/tinh-thanh-pho/sua/{id}-{slug}', [AdminProvince::class, 'edit'])->name('province.edit');
    Route::put('/tinh-thanh-pho/sua/{id}-{slug}', [AdminProvince::class, 'update'])->name('province.update');
    Route::delete('/tinh-thanh-pho/xoa/{id}', [AdminProvince::class, 'destroy'])->name('province.destroy');

    //tỉnh thành phố
    Route::get('/phuong-xa', [AdminWard::class, 'index'])->name('ward');
    Route::get('/dia-diem', [AdminLocation::class, 'index'])->name('location');

    //user
    Route::get('/nguoi-dung', [AdminUser::class, 'index'])->name('user');
    Route::get('/nguoi-dung/khoa', [AdminUser::class, 'indexLock'])->name('user.lock');
    //ví hệ thống
    Route::get('/vi-he-thong', [AdminUser::class, 'systemWallet'])->name('system-wallet');

    Route::get('/nguoi-dung/dang-ky', [AdminUser::class, 'create'])->name('user.create');
    Route::post('/nguoi-dung/dang-ky', [AdminUser::class, 'store'])->name('user.store');
    Route::get('/nguoi-dung/sua/{id}-{slug}', [AdminUser::class, 'edit'])->name('user.edit');
    Route::put('/nguoi-dung/sua/{id}-{slug}', [AdminUser::class, 'update'])->name('user.update');
    Route::get('/nguoi-dung/chi-tiet/{id}-{slug}', [AdminUser::class, 'show'])->name('user.show');

    //category
    Route::get('/danh-muc', [AdminCategory::class, 'index'])->name('category');
    Route::get('/danh-muc/them', [AdminCategory::class, 'create'])->name('category.create');
    Route::post('/danh-muc/them', [AdminCategory::class, 'store'])->name('category.store');
    Route::get('/danh-muc/sua/{id}-{slug}', [AdminCategory::class, 'edit'])->name('category.edit');
    Route::put('/danh-muc/sua/{id}-{slug}', [AdminCategory::class, 'update'])->name('category.update');
    Route::delete('/danh-muc/xoa/{id}-{slug}', [AdminCategory::class, 'destroy'])->name('category.destroy');

    //amenity
    Route::get('/tien-ich', [AdminAmenity::class, 'index'])->name('amenity');
    Route::get('/tien-ich/them', [AdminAmenity::class, 'create'])->name('amenity.create');
    Route::post('/tien-ich/them', [AdminAmenity::class, 'store'])->name('amenity.store');
    Route::get('/tien-ich/sua/{id}-{slug}', [AdminAmenity::class, 'edit'])->name('amenity.edit');
    Route::put('/tien-ich/sua/{id}-{slug}', [AdminAmenity::class, 'update'])->name('amenity.update');
    Route::delete('/tien-ich/xoa/{id}-{slug}', [AdminAmenity::class, 'destroy'])->name('amenity.destroy');

    //post
    Route::get('/bai-viet', [AdminPost::class, 'index'])->name('post');
    Route::get('/bai-viet/dang-tin', [AdminPost::class, 'create'])->name('post.create');
    Route::post('/bai-viet/dang-tin', [AdminPost::class, 'store'])->name('post.store');
    Route::get('/bai-viet/dang-tin/cho-duyet', [AdminPost::class, 'indexPending'])->name('post.pending');
    Route::get('/bai-viet/dang-tin/da-duyet', [AdminPost::class, 'indexApproved'])->name('post.approved');
    Route::get('/bai-viet/dang-tin/tu-choi', [AdminPost::class, 'indexRejected'])->name('post.rejected');
    Route::put('/bai-viet/an/{id}', [AdminPost::class, 'hide'])->name('post.hide');
    Route::put('/bai-viet/hien/{id}', [AdminPost::class, 'showPost'])->name('post.show-post');
    //(viết thêm sửa xóa bài)
    Route::get('/bai-viet/chi-tiet/{id}', [AdminPost::class, 'show'])->name('post.show');
    Route::put('/bai-viet/duyet/{id}-{slug}', [AdminPost::class, 'approved'])->name('post.admin.approved');
    Route::post('/bai-viet/tu-choi/{id}-{slug}', [AdminPostModeration::class, 'reject'])->name('post.reject');
    //import/exportExcel
    Route::post('/bai-viet/nhap-excel/', [AdminPost::class, 'importExcel'])->name('post.import');

    //membership
    Route::get('/dich-vu', [AdminMembership::class, 'index'])->name('membership');
    Route::get('/dich-vu/them', [AdminMembership::class, 'create'])->name('membership.create');
    Route::post('/dich-vu/them', [AdminMembership::class, 'store'])->name('membership.store');
    Route::get('/dich-vu/sua/{id}-{slug}', [AdminMembership::class, 'edit'])->name('membership.edit');
    Route::put('/dich-vu/sua/{id}-{slug}', [AdminMembership::class, 'update'])->name('membership.update');
    Route::get('/dich-vu/chi-tiet/{id}-{slug}', [AdminMembership::class, 'show'])->name('membership.show');
    Route::get('/dich-vu/demo', [AdminMembership::class, 'demo'])->name('membership.demo');
    Route::delete('/dich-vu/xoa/{id}', [AdminMembership::class, 'destroy'])->name('membership.destroy');

    //membership package
    Route::get('/goi-dich-vu-goi', [AdminMembershipPackage::class, 'create'])->name('membership_package.create');
    Route::post('/goi-dich-vu-goi', [AdminMembershipPackage::class, 'store'])->name('membership_package.store');
    Route::get('/goi-dich-vu-goi/sua/{id}', [AdminMembershipPackage::class, 'edit'])->name('membership_package.edit');
    Route::put('/goi-dich-vu-goi/cap-nhat/{id}', [AdminMembershipPackage::class, 'update'])->name('membership_package.update');

    //user membership
    Route::get('/goi-dich-vu-nguoi-dung', [AdminUserMembership::class, 'index'])->name('user_membership');

    //Duyệt Landlord
    Route::get('/nguoi-dung/duyet-landlord/', [AdminLandlordApproval::class, 'index'])
        ->name('approve_landlord.index');
    Route::get('/nguoi-dung/da-duyet-landlord/', [AdminLandlordApproval::class, 'indexApproved'])
        ->name('approve_landlord.index-approved');

    Route::post('/nguoi-dung/duyet-landlord/{id}', [AdminLandlordApproval::class, 'approveLandlord'])
        ->name('approve_landlord');

    Route::post('/nguoi-dung/go-landlord/{id}', [AdminLandlordApproval::class, 'revokeLandlord'])
        ->name('user.revoke_landlord');
    Route::put('/nguoi-dung/khoa/{id}', [AdminLandlordApproval::class, 'lock'])
        ->name('lock');

    Route::put('/nguoi-dung/mo-khoa/{id}', [AdminLandlordApproval::class, 'unlock'])
        ->name('unlock');


    //duyet nạp 
    Route::get('/duyet-nap', [AdminSystemWalletNotification::class, 'index'])->name('wallet_notifications.index');
    Route::get('/duyet-nap/{notification}', [AdminSystemWalletNotification::class, 'show'])->name('wallet_notifications.show');
    Route::post('/duyet-nap/{notification}/duyet', [AdminSystemWalletNotification::class, 'approve'])->name('wallet_notifications.approve');
    Route::post('/duyet-nap/{notification}/tu-choi', [AdminSystemWalletNotification::class, 'reject'])->name('wallet_notifications.reject');

    //notification
    Route::get('/thong-bao', [AdminNotification::class, 'index'])->name('notifications.index');
    Route::get('/thong-bao/{id}/doc', [AdminNotification::class, 'read'])->name('notifications.read');
    Route::post('/thong-bao/doc-tat-ca', [AdminNotification::class, 'readAll'])->name('notifications.read_all');


    //log hành vi
    Route::get('/nhat-ky-hoat-dong', [AdminActivityLog::class, 'index'])
        ->name('activity_log.index');

    //backup

    Route::get('/sao-luu', [AdminBackup::class, 'index'])
        ->name('backup.index');
    Route::post('/sao-luu/chay', [AdminBackup::class, 'run'])
        ->name('backup.run');
    Route::post('/sao-luu/don-dep', [AdminBackup::class, 'clean'])
        ->name('backup.clean');
    Route::get('/sao-luu/tai-xuong/{file}', [AdminBackup::class, 'download'])
        ->name('backup.download');


    //tố cáo
    Route::get('/to-cao-bai-viet', [AdminPostReport::class, 'index'])->name('post_reports.index');
    Route::get('/to-cao-bai-viet/{id}', [AdminPostReport::class, 'show'])->name('post_reports.show');
    Route::post('/to-cao-bai-viet/{id}/xac-nhan', [AdminPostReport::class, 'resolve'])->name('post_reports.resolve');
    Route::post('/to-cao-bai-viet/{id}/tu-choi', [AdminPostReport::class, 'reject'])->name('post_reports.reject');

    //api geojson
    Route::get('provinces', [LocationController::class, 'provinces']);
    Route::get('wards/{province}', [LocationController::class, 'wards']);


});


//nhóm user landlord 
Route::prefix('user')->middleware(['auth', 'check.user',])->name('user.')->group(function () {

    Route::get('provinces', [LocationController::class, 'provinces']);
    Route::get('wards/{province}', [LocationController::class, 'wards']);


    // post
    Route::get('/tin-dang', [UserPost::class, 'index'])->name('post.index');
    Route::get('/dang-tin', [UserPost::class, 'create'])->name('post.create');
    Route::post('/dang-tin', [UserPost::class, 'store'])->name('post.store');
    Route::get('/dang-tin/sua/{id}-{slug}', [UserPost::class, 'edit'])->name('post.edit');
    Route::put('/dang-tin/sua/{id}-{slug}', [UserPost::class, 'update'])->name('post.update');
    Route::post('/day-tin/{id}-{slug}', [UserPost::class, 'pushPost'])->name('post.push-post');
    Route::get('/dang-lai-tin/{id}-{slug}', [UserPost::class, 'repost'])->name('post.repost');
    Route::put('/dang-lai-tin/{id}-{slug}', [UserPost::class, 'repostStore'])->name('post.repost-store');
    Route::put('/an-tin/{id}', [UserPost::class, 'hidePost'])->name('post.hide');
    Route::put('/hien-tin/{id}', [UserPost::class, 'showPost'])->name('post.show-owner');
    // Profile
    // Route::get('/ho-so', [UserHome::class, 'index'])->name('profile.index');
    // Route::put('/ho-so/cap-nhat', [UserHome::class, 'updateProfile'])->name('profile.update');
    // Route::put('/ho-so/doi-mat-khau', [UserHome::class, 'updatePassword'])->name('profile.password');
    // Route::delete('/ho-so/xoa', [UserHome::class, 'destroy'])->name('profile.delete');

    //Giới thiệu bạn bè
    Route::get('/gioi-thieu', [UserHome::class, 'referredBy'])->name('referred.index');
    Route::get('/hang-thanh-vien', [UserHome::class, 'rank'])->name('rank.index');



    Route::get('/vi-tien', [UserWallet::class, 'index'])->name('wallet.index');
    // Route::get('/nap-tien', [UserWallet::class, 'createDeposit'])->name('wallet.deposit.create');
    Route::post('/nap-tien', [UserWallet::class, 'storeDeposit'])->name('wallet.deposit.store');

    Route::get('/ngan-hang-gia-lap/{transaction}', [UserWallet::class, 'fakeBank'])
        ->name('wallet.fake.bank');

    Route::post('/ngan-hang-gia-lap/{transaction}/xac-nhan', [UserWallet::class, 'confirmTransfer'])
        ->name('wallet.fake.confirm');

    Route::post('/ngan-hang-gia-lap/{transaction}/huy', [UserWallet::class, 'cancelDeposit'])
        ->name('wallet.fake.cancel');

    Route::get('/lich-su-nap-tien', [UserWallet::class, 'depositHistory'])->name('wallet.deposit-history');
    Route::get('/lich-su-thanh-toan', [UserWallet::class, 'paymentHistory'])->name('wallet.payment-history');


    //thtoong báo
    Route::get('/', [UserNotification::class, 'index'])->name('notifications.index');
    Route::get('/doc/{id}', [UserNotification::class, 'read'])->name('notifications.read');
    Route::post('/doc-tat-ca', [UserNotification::class, 'readAll'])->name('notifications.readAll');

    //xác nhận mua gói
    Route::get('/goi-dich-vu/xac-nhan/{id}', [UserMembership::class, 'confirm'])
        ->name('membership.confirm');
    Route::post('/goi-dich-vu/thanh-toan/{id}', [UserMembership::class, 'purchase'])
        ->name('membership.purchase');


});


Route::middleware('auth')->group(function () {
    Route::post('/luu-tin/{id}', [UserSavePost::class, 'store'])->name('saved-post.store');

    Route::get('/tin-da-luu', [UserSavePost::class, 'index'])->name('saved-post.index');
    Route::post('/bai-viet/to-cao/{id}', [FrontendPostReport::class, 'store'])->name('post.report');
});


Route::name('frontend.')->group(function () {

    Route::get('/', [FrontendHome::class, 'index'])->name('home');
    Route::get('/moi-nhat', [FrontendHome::class, 'new_post'])->name('new_post');
    Route::get('/danh-muc/{slug}', [FrontendHome::class, 'category_show'])->name('category.show');

    Route::get('/bai-viet/chi-tiet/{id}-{slug}', [FrontendHome::class, 'show'])->name('post.show');

    //
    Route::get('/bai-viet-de-xuat/xem-tat-ca', [FrontendHome::class, 'allPost'])
        ->defaults('type', 'suggest')
        ->name('all-post.suggest');
    Route::get('/bai-viet-noi-bat/xem-tat-ca', [FrontendHome::class, 'allPost'])
        ->defaults('type', 'featured')
        ->name('all-post.featured');
    Route::get('/bai-viet-thuong/xem-tat-ca', [FrontendHome::class, 'allPost'])
        ->defaults('type', 'normal')
        ->name('all-post.normal');

    Route::get('provinces', [LocationController::class, 'provinces']);
    Route::get('wards/{province}', [LocationController::class, 'wards']);
    // Route::get('/xac-thuc', [UserHome::class, 'authLandlord'])->name('auth_landlord');
    Route::get('/bang-gia-dich-vu', [FrontendMembership::class, 'index'])->name('membership.index');
    Route::get('/bang-gia-dich-vu/chi-tiet/{id}-{slug}', [FrontendMembership::class, 'show'])->name('membership.show');
    Route::get('/lien-he', [FrontendContact::class, 'index'])->name('contact.index');
    Route::get('/tin-tuc', [FrontendNew::class, 'index'])->name('new.index');
    //
    Route::get('/ho-so', [UserHome::class, 'index'])->name('profile.index');
    Route::put('/ho-so/cap-nhat', [UserHome::class, 'updateProfile'])->name('profile.update');
    Route::put('/ho-so/doi-mat-khau', [UserHome::class, 'updatePassword'])->name('profile.password');
    Route::delete('/ho-so/xoa', [UserHome::class, 'destroy'])->name('profile.delete');

});

Route::name('api.')->group(function () {
    Route::get('provinces', [LocationController::class, 'provinces']);
    Route::get('wards/{province}', [LocationController::class, 'wards']);
});


Route::name('verify.')->group(function () {

    Route::get('/xac-thuc', [VerifyController::class, 'create'])
        ->name('auth_landlord');
    Route::post('/xac-thuc-email', [VerifyController::class, 'verify'])->name('email');
    Route::post('/gui-otp', [VerifyController::class, 'sendOtp'])->name('send.otp');


});

// Route::middleware('auth')->prefix('notifications')->name('notifications.')->group(function () {

// });