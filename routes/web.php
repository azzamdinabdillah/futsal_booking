<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\SystemConfigController;
use App\Http\Controllers\Admin\FieldController;

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
});
