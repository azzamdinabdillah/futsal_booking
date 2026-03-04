<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\FieldPhotoController;
use App\Http\Controllers\SystemConfigController;
use App\Http\Controllers\BlockedSlotController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::get('/admin', [AdminController::class, 'index'])->name('admin.home');
Route::resource('admins', AdminController::class);
Route::resource('fields', FieldController::class);
Route::resource('field-photos', FieldPhotoController::class);
Route::resource('system-configs', SystemConfigController::class);
Route::resource('blocked-slots', BlockedSlotController::class);
Route::resource('bookings', BookingController::class);
Route::resource('notifications', NotificationController::class);
Route::resource('reviews', ReviewController::class);
