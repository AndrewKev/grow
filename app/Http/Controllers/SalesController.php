<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Absensi;
use App\Models\CarryProduk;
use App\Models\RequestBarang;
use App\Models\Penjualan;
use App\Models\Keterangan;
use App\Models\Toko;
use App\Http\Controllers\PenjualanLakuCashController;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

// use App\Http\Controllers\AdminController;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $classSebelah = app('App\Http\Controllers\GudangKecilController');
        // dd($classSebelah->getStok('B12'));
        return view('pages.karyawan.dashboard');
    }

    /**
     * Halaman Absensi
     */
    public function absensiPage() {
        // dd(auth()->user()->id);
        // dd(Absensi::where('id_user', auth()->user()->id)->get());
        // $listAbsenUser = DB::select('select * from absensi where id_user = '.auth()->user()->id);
        $username = auth()->user()->username;
        $listAbsenUser = DB::select("SELECT u.nama, u.no_telp, a.waktu_masuk, a.waktu_keluar, a.keterangan, a.latitude, a.longitude
                                     FROM absensi as a
                                     JOIN users as u ON a.id_user = u.id
                                     WHERE u.username = '$username'
                                     ORDER BY a.waktu_masuk DESC");
        // dd(sizeof($listAbsenUser));
        return view('pages.karyawan.absensi', compact('listAbsenUser'));
    }

    public function postAbsensi(Request $request) {
        dd($request -> all());
        Absensi::create(
            [
                'id_user' => auth()->user()->id,
                'keterangan' => $request->keterangan,
                'waktu_masuk' => Carbon::now(),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]
        );

        return redirect('/user/absensi');
    }

    public function absensiKeluar() {
        $timeNow = Carbon::now();
        $lastIdAbsen = $this->getLastAbsen();
        $target = DB::update("UPDATE `absensi` 
                              SET `waktu_keluar` = '$timeNow' 
                              WHERE `absensi`.`id_absensi` = $lastIdAbsen;");
        
        return redirect('/user/absensi');
    }

    public function getLastAbsen() {
        $username = auth()->user()->username;
        $listAbsen = DB::select("SELECT a.id_absensi, a.id_user, a.waktu_keluar
                                 FROM absensi as a
                                 JOIN users as u ON a.id_user = u.id
                                 WHERE u.username = '$username'");
        
        $last = $listAbsen[sizeof($listAbsen)-1];                   
        return $last->id_absensi;
    }


    /**
     * Halaman Stok Jalan
     */
    public function stokJalanPage() {
        $barang = $this->getStokUser();
        $req = $this->isRequest(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $konfirmasi = $this->isKonfirmasi(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $barangKonfirmasi = $this->getBarangKonfirmasi();
        $isCarry = $this->isCarry();

        // dd($barangKonfirmasi);
        return view('pages.karyawan.stokjalan', compact('barang', 'req', 'konfirmasi', 'barangKonfirmasi', 'isCarry'));
    }

    public function requestBarangStokJalan(Request $request) {
        // dd($request->all());

        for($i = 0; $i < 10; $i++) {
            if($request->produk[$i] != '0') {
                RequestBarang::create(
                    [
                        'id_user' => auth()->user()->id,
                        'id_produk' => $request->id_produk[$i],
                        'jumlah' => (int) $request->produk[$i],
                        'tanggal_request' => Carbon::now()->format('Y-m-d'),
                        'konfirmasi' => 0
                    ]
                );
            }
        }

        return redirect('/user/stok_jalan');
    }

    public function getBarangKonfirmasi() {
        $user = auth()->user()->id;
        $barangKonfirmasi = DB::select("SELECT p.id_produk, p.nama_produk, r.jumlah FROM request_sales r
                    JOIN products p ON r.id_produk = p.id_produk
                    WHERE id_user = $user
                    AND konfirmasi =  1");

        return $barangKonfirmasi;
    }

    public function terimaBarang(Request $request) {
        $user = auth()->user()->id;
        if($request->has('setuju')) {
            // dd($request->all());
            for($i = 0; $i < sizeof($request->id_produk); $i++) {
                CarryProduk::create(
                    [
                        'id_user' => auth()->user()->id,
                        'id_produk' => $request->id_produk[$i],
                        'tanggal_carry' => Carbon::now()->format('Y-m-d'),
                        'stok_dibawa' => (int) $request->jumlah[$i],
                    ]
                );
            }
        }
        DB::delete("DELETE FROM request_sales WHERE id_user = $user");

        return redirect('/user/stok_jalan');
    }

    public function isRequest($id_user, $tanggal) { // cek apakah user sudah melakukan request ke admin
        $cek = DB::select("SELECT * FROM `request_sales` 
                           WHERE id_user = '$id_user' 
                           AND tanggal_request = '$tanggal';");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    public function isKonfirmasi($id_user, $tanggal) {
        $cek = DB::select("SELECT * FROM `request_sales` 
                           WHERE id_user = '$id_user' 
                           AND tanggal_request = '$tanggal'
                           AND konfirmasi = 1;");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    public function isCarry() { // cek apakah sales sudah bawa barang
        if(sizeof($this->getStokUser()) > 0) {
            return true;
        }
        return false;
    }


    /**
     * Penjualan Laku Cash
     */
    public function pageJualLakuCash() {
        return app('App\Http\Controllers\PenjualanLakuCashController')->index();
        // dd($classSebelah->getStok('B12'));
        // dd("tess");
    }

    public function postJualLakuCash(Request $request) {
        return app('App\Http\Controllers\PenjualanLakuCashController')->store($request);
        // return redirect('/user/stok_jalan');
        // return redirect()->back('App\Http\Controllers\PenjualanLakuCashController')->index();

    }

    // public function insertBarang($id_produk, $jumlahBarang) {
    //     CarryProduk::create(
    //         [
    //             'id_user' => auth()->user()->id,
    //             'id_produk' => $id_produk,
    //             'tanggal_carry' => Carbon::now()->format('Y-m-d'),
    //             'stok_dibawa'=> $jumlahBarang
    //         ]
    //     );
    // }

    // public function updateBarang($id_produk, $jumlahBarang) {
    //     $id_user = auth()->user()->id;
    //     DB::update("UPDATE carry_produk SET stok_dibawa = $jumlahBarang 
    //                 WHERE id_produk = '$id_produk' AND id_user = '$id_user';");
    // }

    // public function cekBarangDibawa($id_produk, $tanggal) {
    //     $id_user = auth()->user()->id;
    //     $barang = DB::select("SELECT * FROM `carry_produk` 
    //     WHERE id_user = '$id_user' 
    //     AND id_produk = '$id_produk'
    //     AND tanggal_carry = '$tanggal';");

    //     return sizeof($barang);
    // }

    public function getStokUser() {
        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');
        $barang = DB::select("SELECT users.nama, c.*, products.nama_produk
        FROM carry_produk AS c
        JOIN products ON products.id_produk = c.id_produk
        JOIN users ON c.id_user = users.id
        WHERE c.id_user = '$id_user' AND c.tanggal_carry = '$tanggal';");

        return $barang;
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
