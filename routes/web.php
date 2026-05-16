<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentSettingController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [ProductController::class, 'index'])->name('admin');
    Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/admin/payment-settings', [PaymentSettingController::class, 'update'])->name('payment-settings.update');
});

Route::get('/', [\App\Http\Controllers\CashierController::class, 'index'])->name('pos');
Route::post('/nota', [\App\Http\Controllers\CashierController::class, 'nota'])->name('nota');
