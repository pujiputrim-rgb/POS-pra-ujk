<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/action-login', [LoginController::class, 'actionLogin'])->name('action-login');

Route::prefix('admin')->group(function () {
    Route::get('/', [LoginController::class, 'login']);
    Route::get('/login', [LoginController::class, 'login']);
    Route::resource('dashboard', DashboardController::class);
    Route::resource('user', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
