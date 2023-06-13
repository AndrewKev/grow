<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin1Controller;
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
        'controller' => Admin1Controller::class,
        'prefix' => 'admin',
        'middleware' => ['auth', 'level:1']
    ],
    function() {
        Route::get('/dashboard', 'admin1Page');

        // REQUEST STOR KEUANGAN
        Route::get('/request_stor_uang', 'reqSalesStorUang');
        Route::get('/request_stor_uang/{id}', 'detailReqSalesStorUang');
        Route::post('/request_stor_uang/{id_user}/konfirmasi', 'konfirmasiRequestStorUang');
        Route::get('/tampil_absensi', 'tampilAbsensi');

        // HISTORY REQUEST SALES
        Route::get('/history_request_stor_penjualan', 'historyRequestStorUang');
        Route::get('/history_request_stor_penjualan/{keterangan}/{nama_sales}', 'detailHistoryRequestStorUang');

    }
);

// URL : .com/admin/
// admin2
Route::group(
    [
        'controller' => AdminController::class,
        'prefix' => 'admin2',
        'middleware' => ['auth', 'level:2']
    ],
    function() {
        Route::get('/dashboard', 'admin2Page');
        Route::get('/request_sales', 'reqSalesPage');
        Route::get('/request_sales/{id}', 'detailReqSales');
        Route::post('/request_sales/{id_user}/ubah_stok/{id_produk}', 'ubahRequestStok');
        Route::post('/request_sales/{id_user}/konfirmasi', 'konfirmasiRequest');
        // Route::post('/konfirmasi', 'konfirmasiReq');

        // REQUEST STOR BARANG
        Route::get('/request_stor_barang', 'reqSalesStorBarang');
        Route::get('/request_stor_barang/{id}', 'detailReqSalesStorBarang');
        Route::post('/request_stor_barang/{id_user}/konfirmasi', 'konfirmasiRequestStorBarang');

        // HISTORY REQUEST SALES
        Route::get('/history_request_sales', 'historyRequestSales');
        Route::get('/history_request_sales/{keterangan}/{nama_sales}', 'detailHistoryRequestSales');

        Route::get('/history_request_stor_barang', 'historyRequestStorBarang');
        Route::get('/history_request_stor_barang/{keterangan}/{nama_sales}', 'detailHistoryRequestStorBarang');
        // testing aja
        Route::get('/test', 'test');
        
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
        Route::get('/penjualan_laku_cash/{id_toko}', 'detailJualLakuCash');

        // dropdown penjualan laku cash
        Route::get('/get_routing/{id_routing}', 'tokoDropdown');

        // Stor Produk ke admin 2
        Route::get('/stor_produk', 'tampilStorProduk');
        Route::post('/request_stor_barang', 'requestStorBarang');
        // Route::post('/input_stor_produk', 'inputStorProduk');
        
        // Stor Keuangan ke admin 1 
        Route::post('/request_stor_uang', 'requestStorUang');

        // Selesai stor produk
        Route::post('/insert_produk', 'insertStorProduk');
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
