<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\MarginPenjualanController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\DashboardTransaksiController;
use App\Http\Controllers\LaporanBarangController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cek-koneksi', function () {
    try {
        DB::connection()->getPdo();
        return "Koneksi ke database berhasil: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "Koneksi gagal: " . $e->getMessage();
    }
});

// data master
Route::resource('role', RoleController::class);
Route::resource('user', UserController::class);
Route::resource('satuan', SatuanController::class);
Route::resource('vendor', VendorController::class);
Route::resource('barang', BarangController::class);
Route::resource('margin', MarginPenjualanController::class);

// transaksi
Route::get('/dashboard-transaksi', [DashboardTransaksiController::class, 'index'])
     ->name('dashboard.transaksi');

Route::get('/laporan-barang', [LaporanBarangController::class, 'index'])
     ->name('laporan.barang');

Route::get('/pengadaan', [PengadaanController::class, 'index'])->name('pengadaan.index');
Route::get('/pengadaan/create', [PengadaanController::class, 'create'])->name('pengadaan.create');
Route::post('/pengadaan/store', [PengadaanController::class, 'store'])->name('pengadaan.store');

Route::get('/penerimaan', [PenerimaanController::class, 'index'])->name('penerimaan.index');
Route::get('/penerimaan/create', [PenerimaanController::class, 'create'])->name('penerimaan.create');
Route::post('/penerimaan/store', [PenerimaanController::class, 'store'])->name('penerimaan.store');

Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
Route::post('/penjualan/store', [PenjualanController::class, 'store'])->name('penjualan.store');