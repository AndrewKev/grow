<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RequestGudangKecil;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PimpinanAreaController extends Controller
{
    public function pimpinanArea(){
        return view('pages.pimArea.dashboard');
    }

    public function reqGudangKecil(){
        $daftarReq = $this->daftaReqGKecil();
        return view('pages.pimArea.requestBarangGKecil', compact('daftarReq'));
    }

    public function daftaReqGKecil() {
        $daftarReq = DB::select("SELECT u.id, u.nama, r.tanggal_po, r.nomor_po, r.deadline_kirim, r.catatan,MAX(r.created_at) AS created_at
        FROM request_gudang_kecil AS r
        JOIN users AS u ON u.id = r.id_user
        WHERE r.konfirmasi = 0
        GROUP BY u.id, u.nama,r.tanggal_po, r.nomor_po, r.deadline_kirim,r.catatan");
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
        return view('pages.pimArea.detailRequestBarangGKecil', compact('data', 'user', 'nomor_po'));
    }

    public function ubahReqGudangKecil(Request $request, $id_user, $nomor_po, $id_produk){
        // dd($request->all());
        $produk = Product::where('id_produk', $request->id_produk)->first(); // Ambil data produk dari tabel products
                // dd($produk);
        $hargaStok = $produk->harga_toko * (int) $request->jumlah; 
        // dd($hargaStok);
        DB::update("UPDATE request_gudang_kecil SET stok = $request->jumlah, harga_stok = $hargaStok
        WHERE id_user = $id_user AND nomor_po = '$nomor_po'
        AND id_produk = '$id_produk'");
        
        // DB::update("UPDATE request_gudang_kecil SET stok = $request->jumlah
        // WHERE id_user = $id_user AND nomor_po = '$nomor_po'
        // AND id_produk = '$id_produk'");

        return redirect('/pimArea/daftar_req_gudang_kecil/'.$id_user.'/'.$nomor_po);
    }

    public function konfirmasiRequest($id_user, $nomor_po){
        // dd($nomor_po);
        // dd($id_user );
        $tanggal = Carbon::now();
        $coba = DB::update("UPDATE request_gudang_kecil SET konfirmasi = 1, tgl_konfirmasi = '$tanggal'
                    WHERE id_user = $id_user AND nomor_po = '$nomor_po';");
        // dd($coba);
        return redirect('/pimArea/daftar_req_gudang_kecil/');
    }
}
