<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin1Controller;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SPOController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GudangBesarController;
use App\Http\Controllers\GudangKecilController;
use App\Http\Controllers\PenjualanLakuCashController;
use App\Http\Controllers\PimpinanAreaController;
use App\Http\Controllers\HeadAccountController;
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

Route::group(
    [
        'controller' => HeadAccountController::class,
        'prefix' => 'headAcc',
        'middleware' => ['auth', 'level:7']
    ],
    function() {
        Route::get('/dashboard', 'headAccount');

        // REQUEST GUDANG KECIL
        Route::get('/request_gudang_besar', 'reqGudangBesar');
        Route::get('/request_gudang_besar/{id}', 'detailReqGudangBesar');
        Route::post('/request_gudang_besar/{id_user}/konfirmasi', 'konfirmasiRequest');

        // HISTORY REQUEST GUDANG BESAR
        Route::get('/history_request_barang_gBesar', 'historyRequestBarangGBesar');
        Route::get('/history_request_barang_gBesar/{keterangan}/{nama_admin}/{tanggal}', 'detailHistoryRequestStorGBesar');

    }
);

Route::group(
    [
        'controller' => PimpinanAreaController::class,
        'prefix' => 'pimArea',
        'middleware' => ['auth', 'level:6']
    ],
    function() {
        Route::get('/dashboard', 'pimpinanArea');
        Route::get('/daftar_req_gudang_kecil', 'reqGudangKecil');
        Route::get('/daftar_req_gudang_kecil/{id}', 'detailReqGudangKecil');

        Route::post('/daftar_req_gudang_kecil/{id_user}/ubah_stok/{id_produk}', 'ubahReqGudangKecil');
        Route::post('/daftar_req_gudang_kecil/{id_user}/konfirmasi', 'konfirmasiRequest');

        // HISTORY REQUEST GUDANG KECIL
        Route::get('/history_request_barang_gKecil', 'historyRequestBarangGKecil');
        Route::get('/history_request_barang_gKecil/{keterangan}/{nama_admin}/{tanggal}', 'detailHistoryRequestStorGKecil');

        Route::get('/tampil_absensi', 'tampilAbsensi');
        Route::get('/stok_gudang_besar', 'tampilGudangBesar');
        Route::get('/stok_gudang_kecil', 'tampilGudangKecil');

    }
);

Route::group(
    [
        'controller' => GudangBesarController::class,
        'prefix' => 'gBesar',
        'middleware' => ['auth', 'level:5']
    ],
    function() {
        Route::get('/dashboard', 'gudangBesar');

        Route::get('/stok_barang', 'getStokBarang');
        Route::post('/tambah_stok', 'tambahStok');
        Route::post('/tambah_sample', 'tambahSample');

        // REQUEST GUDANG KECIL
        Route::get('/request_gKecil', 'reqGudangKecil');
        Route::get('/request_gKecil/{id}', 'detailReqGudangKecil');
        Route::post('/request_gKecil/{id_user}/konfirmasi', 'konfirmasiRequest');

        // REQUEST KE HEAD ACCOUNT
        Route::post('/request_gKecil/{id_user}/request_head_acc', 'reqHeadAcc');

        // HISTORY REQUEST GUDANG KECIL
        Route::get('/history_request_barang_gKecil', 'historyRequestBarangGKecil');
        Route::get('/history_request_barang_gKecil/{keterangan}/{nama_admin}/{tanggal}', 'detailHistoryRequestStorGKecil');

    }
);

Route::group(
    [
        'controller' => GudangKecilController::class,
        'prefix' => 'gKecil',
        'middleware' => ['auth', 'level:4']
    ],
    function() {
        Route::get('/dashboard', 'gudangKecil');

        Route::get('/stok_barang', 'getStokBarang');
        Route::post('/request_stok', 'requestStokGKecil');
    }
);
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


        // GUDANG KECIL
        Route::get('/stok_barang_gKecil', 'stokGudangKecil');
        Route::post('/request_stok', 'requestStokGKecil');
        Route::post('/terima_barang', 'terimaBarang');
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

// URL : .com/spo/
Route::group(
    [
        'controller' => SPOController::class,
        'prefix' => 'spo',
        'middleware' => ['auth', 'level:8']
    ],
    function() {
        // Dashboard
        Route::get('/dashboard', 'index');

        // Absensi
        Route::get('/absensi', 'pageAbsensiSPO');
        Route::post('/absensi', 'postAbsensi');

        // Stok Jalan
        Route::get('/stok_jalan', 'stokJalanPage');
        Route::post('/request_barang', 'requestBarangStokJalan');

    }
);

// Route::middleware(['auth', 'level:1'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'index']);
// });

// Route::middleware(['auth', 'level:2'])->group(function () {
//     Route::get('/dashboard', [SalesController::class, 'index']);
//     Route::get('/absensi', [AbsensiController::class, 'index']);
// });
// Route::middleware(['auth', 'level:5'])->group(function () {
//     Route::get('/gBesar/dashboard', [GudangBesarController::class, 'gudangBesar']);
// });
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
