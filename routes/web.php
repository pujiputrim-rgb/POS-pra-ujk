<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/action-login', [LoginController::class, 'actionLogin'])->name('action-login');

Route::prefix('admin')->group(function () {
    Route::get('/', [LoginController::class, 'login']);
    Route::get('/login', [LoginController::class, 'login']);
    Route::resource('dashboard', DashboardController::class);
});
