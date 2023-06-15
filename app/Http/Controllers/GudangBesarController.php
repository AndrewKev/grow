<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\GudangBesar;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GudangBesarController extends Controller
{
    public function gudangBesar(){
        return view('pages.gBesar.dashboard');
    }

    public function getStokBarang(){
        $stokSample = $this->getStokSampleBarang();
        return view('pages.gBesar.stokBarangGBesar', compact('stokSample'));
    }

    public function getStokSampleBarang(){
        $stokSampleBarang = DB::select("SELECT * FROM gudang_besar");
        return $stokSampleBarang;
    }

    public function tambahStok(Request $request){
        // dd($request->all());
        $ambilStok = DB::select("SELECT * FROM `gudang_besar`");
        // dd($ambilStok);

        for ($i = 0; $i < sizeof($request->id_produk); $i++) {
            DB::update("UPDATE `gudang_besar` 
                        SET `stok` = `stok` + :stok,
                            `harga_stok` = :harga_stok
                        WHERE `id_produk` = :id_produk", [
                            'stok' => (int) $request->produk[$i],
                            'harga_stok' => (int) $request->produk[$i],
                            'id_produk' => $request->id_produk[$i]
                        ]);
        } 
        return redirect('/gBesar/stok_barang');
    }

    public function tambahSample(Request $request){
        // dd($request->all());

        for ($i = 0; $i < sizeof($request->id_produk); $i++) {
            DB::update("UPDATE `gudang_besar` 
                        SET `sample` = `sample` + :sample,
                            `harga_stok` = :harga_stok
                        WHERE `id_produk` = :id_produk", [
                            'sample' => (int) $request->produk[$i],
                            'harga_stok' => (int) $request->produk[$i],
                            'id_produk' => $request->id_produk[$i]
                        ]);
        } 
        return redirect('/gBesar/stok_barang');
    }

    // REQUEST GUDANG KECIL
    public function reqGudangKecil(){
        $daftarReq = $this->daftaReqGKecil();
        return view('pages.gBesar.requestBarangGKecil', compact('daftarReq'));
    }

    public function daftaReqGKecil() {
        $daftarReq = DB::select("SELECT u.id, u.nama, r.tanggal_po, r.nomor_po, r.deadline_kirim, r.catatan, MAX(r.created_at) AS created_at, r.konfirmasi
        FROM request_gudang_kecil AS r
        JOIN users AS u ON u.id = r.id_user
        WHERE r.konfirmasi2 = 0
        GROUP BY u.id, u.nama, r.tanggal_po, r.nomor_po, r.deadline_kirim, r.catatan, r.konfirmasi;");
        return $daftarReq;
    }

    public function detailReqGudangKecil($id, $nomor_po){
        $data = DB::select("SELECT r.id_user, r.id_produk, p.nama_produk, r.stok, r.sample, r.harga_stok, r.created_at,r.nomor_po
                            FROM request_gudang_kecil r
                            JOIN products p ON p.id_produk = r.id_produk
                            WHERE id_user = $id AND nomor_po = '$nomor_po'");
        $user = DB::select("SELECT id, nama
                            FROM users
                            WHERE id = $id");
        $nomor_po = DB::select("SELECT nomor_po FROM request_gudang_kecil WHERE id_user = $id AND nomor_po = '$nomor_po'");
        // dd($data);
        return view('pages.gBesar.detailRequestBarangGKecil', compact('data', 'user', 'nomor_po'));
    }

    public function konfirmasiRequest($id_user, $nomor_po){
        // dd($nomor_po);
        // dd($id_user );
        $tanggal = Carbon::now();
        $coba = DB::update("UPDATE request_gudang_kecil SET konfirmasi2 = 1, tgl_konfirmasi2 = '$tanggal'
                    WHERE id_user = $id_user AND nomor_po = '$nomor_po';");
        // dd($coba);
        return redirect('/gBesar/request_gKecil/');
    }

    public function terimaBarang(Request $request) {
        dd($request->all());
        $user = auth()->user()->id;
        if($request->has('setuju')) {
            // dd($request->all());
            for($i = 0; $i < sizeof($request->id_produk); $i++) {
                GudangKecil::create(
                    [
                        'id_user' => auth()->user()->id,
                        'id_produk' => $request->id_produk[$i],
                        'stok' => (int) $request->jumlah[$i],
                    ]
                );
            }
        }
        DB::delete("DELETE FROM request_gudang_kecil WHERE id_user = $user");

        return redirect('/gBesar/request_gKecil/');
    }
}
