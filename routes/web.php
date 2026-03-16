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
    Route::get('/dang-tin', [AdminPost::class, 'index'])->name('post');


});

//nhóm user admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {

    Route::get('/', [AdminHome::class, 'index'])->name('home');

});

//nhóm user landlord 
Route::prefix('landlord')->middleware(['auth', 'role:lanlord'])->name('landlord.')->group(function () {

    Route::get('/', [AdminHome::class, 'index'])->name('home');
});

Route::name('frontend.')->group(function () {

    Route::get('/', [FrontendHome::class, 'index'])->name('home');

    Route::get('/provinces', [LocationController::class, 'provinces']);
    Route::get('/wards/{province}', [LocationController::class, 'wards']);

});