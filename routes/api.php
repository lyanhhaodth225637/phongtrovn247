<?php
use App\Http\Controllers\Api\LocationController;

Route::get('/provinces', [LocationController::class, 'provinces']);
Route::get('/wards/{province}', [LocationController::class, 'wards']);  