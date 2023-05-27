<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PenjualanLakuCashController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});
// Route::get('/', function () {
//     return view('welcome');
// });


Auth::routes();

// URL : .com/admin/
// admin1
Route::group(
    [
        'controller' => AdminController::class,
        'prefix' => 'admin',
        'middleware' => ['auth', 'level:1']
    ],
    function() {
        Route::get('/dashboard', 'index');
    }
);

// URL : .com/admin/
// admin2
Route::group(
    [
        'controller' => AdminController::class,
        'prefix' => 'admin',
        'middleware' => ['auth', 'level:2']
    ],
    function() {
        Route::get('/dashboard', 'admin2Page');
        Route::get('/request_sales', 'reqSalesPage');
        Route::get('/request_sales/{id}', 'detailReqSales');
        Route::post('/request_sales/{id_user}/ubah_stok/{id_produk}', 'ubahRequestStok');
        Route::post('/request_sales/{id_user}/konfirmasi', 'konfirmasiRequest');
        // Route::post('/konfirmasi', 'konfirmasiReq');
    }
);


// URL : .com/user/
Route::group(
    [
        'controller' => SalesController::class,
        'prefix' => 'user',
        'middleware' => ['auth', 'level:0']
    ],
    function() {
        Route::get('/dashboard', 'index');
        Route::get('/absensi', 'absensiPage');
        Route::post('/absensi', 'postAbsensi');
        Route::post('/absensi_keluar', 'absensiKeluar');
        Route::get('/stok_jalan', 'stokJalanPage');
        Route::post('/request_barang', 'requestBarangStokJalan');
        Route::post('/terima_barang', 'terimaBarang');
        Route::get('/penjualan_laku_cash', 'pageJualLakuCash');
        Route::post('/penjualan_laku_cash', 'postJualLakuCash');
    }
);

// Route::middleware(['auth', 'level:1'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'index']);
// });

// Route::middleware(['auth', 'level:2'])->group(function () {
//     Route::get('/dashboard', [SalesController::class, 'index']);
//     Route::get('/absensi', [AbsensiController::class, 'index']);
// });

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
