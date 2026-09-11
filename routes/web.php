<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureKasir;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'actionLogin'])->name('action-login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route khusus Kasir (Standalone Page POS)
Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index')->middleware(EnsureKasir::class);
Route::post('/kasir/store', [KasirController::class, 'store'])->name('kasir.store')->middleware(EnsureKasir::class);

// Route khusus Pimpinan
Route::prefix('pimpinan')->group(function () {
    Route::get('/dashboard', [PimpinanController::class, 'dashboard'])->name('pimpinan.dashboard');
    Route::get('/stok', [PimpinanController::class, 'stok'])->name('pimpinan.stok');
    Route::get('/laporan', [PimpinanController::class, 'laporan'])->name('pimpinan.laporan');
});

Route::prefix('admin')->group(function () {

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
