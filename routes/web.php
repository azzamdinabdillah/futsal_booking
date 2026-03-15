<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\SystemConfigController;
use App\Http\Controllers\Admin\FieldController;
use App\Http\Controllers\Admin\BookingController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin Auth
Route::get('/admin/login', [AuthController::class, 'create'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'store'])->name('admin.login.store');
Route::post('/admin/logout', [AuthController::class, 'destroy'])->name('admin.logout');

Route::middleware('auth:admin')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/system-config', [SystemConfigController::class, 'index'])->name('admin.system-config.index');
    Route::post('/system-config/{id}', [SystemConfigController::class, 'update'])->name('admin.system-config.update');

    // Field Management
    Route::get('/fields', [FieldController::class, 'index'])->name('admin.fields.index');
    Route::get('/fields/create', [FieldController::class, 'create'])->name('admin.fields.create');
    Route::post('/fields', [FieldController::class, 'store'])->name('admin.fields.store');
    Route::get('/fields/{field}/edit', [FieldController::class, 'edit'])->name('admin.fields.edit');
    Route::put('/fields/{field}', [FieldController::class, 'update'])->name('admin.fields.update');
    Route::delete('/fields/{field}', [FieldController::class, 'destroy'])->name('admin.fields.destroy');

    // Booking Management
    Route::get('/bookings', [BookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('admin.bookings.show');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('admin.bookings.update-status');
});
