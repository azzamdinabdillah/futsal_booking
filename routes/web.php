<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\SystemConfigController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/system-config', [SystemConfigController::class, 'index'])->name('admin.system-config.index');
Route::post('/admin/system-config/{id}', [SystemConfigController::class, 'update'])->name('admin.system-config.update');
