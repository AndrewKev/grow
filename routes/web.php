<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


// URL : .com/user/
Route::group(
    [
        'controller' => SalesController::class,
        'prefix' => 'user',
        'middleware' => ['auth', 'level:2']
    ],
    function() {
        Route::get('/dashboard', 'index');
        Route::get('/absensi', 'absensiPage');
        Route::post('/absensi', 'postAbsensi');
        Route::post('/absensi_keluar', 'absensiKeluar');
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
