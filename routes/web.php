<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\FieldPhotoController;
use App\Http\Controllers\SystemConfigController;
use App\Http\Controllers\BlockedSlotController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [AdminController::class, 'index'])->name('admin.home');
Route::resource('admins', AdminController::class);
Route::resource('fields', FieldController::class);
Route::resource('field-photos', FieldPhotoController::class);
Route::resource('system-configs', SystemConfigController::class);
Route::resource('blocked-slots', BlockedSlotController::class);
