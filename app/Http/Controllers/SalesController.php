<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\CarryProduk;
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
        return view('pages.karyawan.stokjalan', compact('barang'));
    }

    public function ambilBarangStokJalan(Request $request) {
        // dd($request->all());

        for($i = 0; $i < 10; $i++) {
            if($this->cekBarangDibawa($request->id_produk[$i], Carbon::now()->format('Y-m-d')) == 0) {
                // dd($request->all());
                if($request->produk[$i] != '0') {
                    $this->insertBarang($request->id_produk[$i], (int)$request->produk[$i]);
                    $stokSaatIni = app('App\Http\Controllers\GudangKecilController')->getStok($request->id_produk[$i]);
                    app('App\Http\Controllers\GudangKecilController')->update($request->id_produk[$i], $stokSaatIni - (int)$request->produk[$i]);
                }
            } else {
                if($request->produk[$i] != '0') {
                    $this->updateBarang($request->id_produk[$i], (int)$request->produk[$i] + $this->getStokUser()[$i]->stok_dibawa);
                    $stokSaatIni = app('App\Http\Controllers\GudangKecilController')->getStok($request->id_produk[$i]);
                    app('App\Http\Controllers\GudangKecilController')->update($request->id_produk[$i], $stokSaatIni - (int)$request->produk[$i]);
                }
            }
        }

        return redirect('/user/stok_jalan');
    }

    public function insertBarang($id_produk, $jumlahBarang) {
        CarryProduk::create(
            [
                'id_user' => auth()->user()->id,
                'id_produk' => $id_produk,
                'tanggal_carry' => Carbon::now()->format('Y-m-d'),
                'stok_dibawa'=> $jumlahBarang
            ]
        );
    }

    public function updateBarang($id_produk, $jumlahBarang) {
        $id_user = auth()->user()->id;
        DB::update("UPDATE carry_produk SET stok_dibawa = $jumlahBarang 
                    WHERE id_produk = '$id_produk' AND id_user = '$id_user';");
    }

    public function cekBarangDibawa($id_produk, $tanggal) {
        $id_user = auth()->user()->id;
        $barang = DB::select("SELECT * FROM `carry_produk` 
        WHERE id_user = '$id_user' 
        AND id_produk = '$id_produk'
        AND tanggal_carry = '$tanggal';");

        return sizeof($barang);
    }

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
