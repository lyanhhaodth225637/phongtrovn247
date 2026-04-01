<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\HomeController as AdminHome;
use App\Http\Controllers\Frontend\HomeController as FrontendHome;
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

use App\Http\Controllers\Admin\SystemWalletNotificationController as AdminSystemWalletNotification;
use App\Http\Controllers\Admin\AdminNotificationController as AdminNotification;

use App\Http\Controllers\User\PostController as UserPost;
use App\Http\Controllers\User\HomeController as UserHome;
use App\Http\Controllers\User\WalletController as UserWallet;

use App\Http\Controllers\VerifyController;


use App\Http\Controllers\Admin\UserMembershipController as AdminUserMembership;

use App\Http\Controllers\Api\LocationController;

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/admin', [App\Http\Controllers\HomeController::class, 'getAdmin'])->name('admin');

//nhóm user admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {

    Route::get('/', [AdminHome::class, 'index'])->name('home');

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
    Route::get('/nguoi-dung/dang-ky', [AdminUser::class, 'create'])->name('user.create');
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
    //viết thêm sửa xóa bài
    Route::get('/bai-viet/chi-tiet/{id}', [AdminPost::class, 'show'])->name('post.show');
    Route::put('/bai-viet/duyet/{id}-{slug}', [AdminPost::class, 'approved'])->name('post.approved');
    Route::post('/bai-viet/tu-choi/{id}-{slug}', [AdminPostModeration::class, 'reject'])->name('post.reject');
    //import/exportExcel
    Route::post('/bai-viet/import-excel/', [AdminPost::class, 'importExcel'])->name('post.import');

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
    Route::get('/membership-package', [AdminMembershipPackage::class, 'create'])->name('membership_package.create');
    Route::post('/membership-package', [AdminMembershipPackage::class, 'store'])->name('membership_package.store');
    Route::get('/membership-package/edit/{id}', [AdminMembershipPackage::class, 'edit'])->name('membership_package.edit');
    Route::put('/membership-package/update/{id}', [AdminMembershipPackage::class, 'update'])->name('membership_package.update');

    //user membership
    Route::get('/user-membership', [AdminUserMembership::class, 'index'])->name('user_membership');

    //duyet nạp 
    Route::get('/wallet-notifications', [AdminSystemWalletNotification::class, 'index'])
        ->name('wallet_notifications.index');

    Route::get('/wallet-notifications/{notification}', [AdminSystemWalletNotification::class, 'show'])
        ->name('wallet_notifications.show');

    Route::post('/wallet-notifications/{notification}/approve', [AdminSystemWalletNotification::class, 'approve'])
        ->name('wallet_notifications.approve');

    Route::post('/wallet-notifications/{notification}/reject', [AdminSystemWalletNotification::class, 'reject'])
        ->name('wallet_notifications.reject');

    //notification
    Route::get('/notifications', [AdminNotification::class, 'index'])
        ->name('notifications.index');

    Route::get('/notifications/{id}/read', [AdminNotification::class, 'read'])
        ->name('notifications.read');

    Route::post('/notifications/read-all', [AdminNotification::class, 'readAll'])
        ->name('notifications.read_all');




    //api geojson
    Route::get('provinces', [LocationController::class, 'provinces']);
    Route::get('wards/{province}', [LocationController::class, 'wards']);


});


//nhóm user landlord 
Route::prefix('user')->middleware(['auth', 'check.user',])->name('user.')->group(function () {
    Route::get('/ho-so', [UserHome::class, 'index'])->name('profile');
    Route::get('/post', [UserPost::class, 'index'])->name('profile');
    Route::get('/ho-so/dang-tin', [UserHome::class, 'create'])->name('post.create');
    Route::post('/ho-so/dang-tin', [UserHome::class, 'store'])->name('post.store'); // ← thêm dòng này

    Route::get('provinces', [LocationController::class, 'provinces']);
    Route::get('wards/{province}', [LocationController::class, 'wards']);



    Route::get('/vi-tien', [UserWallet::class, 'index'])->name('wallet.index');

    // Route::get('/nap-tien', [UserWallet::class, 'createDeposit'])->name('wallet.deposit.create');
    Route::post('/nap-tien', [UserWallet::class, 'storeDeposit'])->name('wallet.deposit.store');

    Route::get('/ngan-hang-gia-lap/{transaction}', [UserWallet::class, 'fakeBank'])
        ->name('wallet.fake.bank');

    Route::post('/ngan-hang-gia-lap/{transaction}/confirm', [UserWallet::class, 'confirmTransfer'])
        ->name('wallet.fake.confirm');

    Route::post('/ngan-hang-gia-lap/{transaction}/cancel', [UserWallet::class, 'cancelDeposit'])
        ->name('wallet.fake.cancel');

    Route::get('/lich-su-nap-tien', [UserWallet::class, 'depositHistory'])->name('wallet.deposit-histor');

});


Route::name('frontend.')->group(function () {

    Route::get('/', [FrontendHome::class, 'index'])->name('home');
    Route::get('/moi-nhat', [FrontendHome::class, 'new_post'])->name('new_post');
    Route::get('/danh-muc/{slug}', [FrontendHome::class, 'category_show'])->name('category.show');

    Route::get('/bai-viet/chi-tiet/{id}-{slug}', [FrontendHome::class, 'show'])->name('post.show');


    Route::get('/provinces', [LocationController::class, 'provinces']);
    Route::get('/wards/{province}', [LocationController::class, 'wards']);

    Route::get('/xac-thuc', [UserHome::class, 'authLandlord'])->name('auth_landlord');


});

Route::name('api.')->group(function () {
    Route::get('/provinces', [LocationController::class, 'provinces']);
    Route::get('/wards/{province}', [LocationController::class, 'wards']);
});


Route::name('verify.')->group(function () {

    Route::get('/xac-thuc', [VerifyController::class, 'create'])
        ->name('auth_landlord');
    Route::post('/verify-email', [VerifyController::class, 'verify'])->name('email');
    Route::post('/send-otp', [VerifyController::class, 'sendOtp'])
        ->name('send.otp');


});



