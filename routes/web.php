<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CamilanControll;
use App\Http\Controllers\Admin\DashboardControll;
use App\Http\Controllers\Admin\KategoriControll;
use App\Http\Controllers\Admin\KategoriPesananControll;
use App\Http\Controllers\Admin\MakananControll;
use App\Http\Controllers\Admin\MinumanControll;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RiwayatController;


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth','role:admin'])->name('admin.')->group(function (){
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/',[DashboardControll::class, 'index']);
    Route::get('/dashboard',[DashboardControll::class, 'index'])->name('dashboard');
    Route::get('/pesanan',[PesananController::class, 'index'])->name('pesanan');
    Route::get('/riwayat',[RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/get-saldo-perbulan',[RiwayatController::class, 'getPendapatanPerbulan']);
    Route::resource('produk', ProductController::class);
    Route::prefix('produks')->group(function () {
        Route::resource('kategori', KategoriControll::class);
    });
    Route::prefix('pesanan')->name('pesanan.')->group(function () {
        Route::resource('kategori', KategoriPesananControll::class);
    });
    Route::get('/admin/orders/new', [DashboardControll::class, 'getNewOrders'])->name('orders.new');
    Route::post('/admin/orders/confirm/{id}', [DashboardControll::class, 'confirm'])->name('confirm.order');
    Route::post('/admin/orders/update/{id}', [DashboardControll::class, 'updateStatus'])->name('updateStatus.order');
});