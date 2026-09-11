<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureKasir;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::post('/action-login', [LoginController::class, 'actionLogin'])->name('action-login');

// Route khusus Kasir (Standalone Page POS)
Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index')->middleware(EnsureKasir::class);

Route::prefix('admin')->group(function () {
    Route::get('/', [LoginController::class, 'login']);
    Route::get('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/kasir', function () {
        return redirect()->route('kasir.index');
    });

    Route::middleware([EnsureAdmin::class])->group(function () {
        Route::resource('dashboard', DashboardController::class);
        Route::resource('user', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('products', ProductController::class);
    });
});
