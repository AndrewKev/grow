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

    public function detailReqGudangKecil($id, $nomor_po) {
        $data = DB::select("SELECT r.id_user, r.id_produk, p.nama_produk, r.stok, r.sample, r.harga_stok, r.created_at, r.nomor_po
                            FROM request_gudang_kecil r
                            JOIN products p ON p.id_produk = r.id_produk
                            WHERE id_user = $id AND nomor_po = '$nomor_po'");
        $user = DB::select("SELECT id, nama
                            FROM users
                            WHERE id = $id");
        $nomor_po = DB::select("SELECT nomor_po FROM request_gudang_kecil WHERE id_user = $id AND nomor_po = '$nomor_po'");
        // $dataBarangKonfirmasi = $this->getBarangKonfirmasi($id, $nomor_po);
        $nomor_po_value = $nomor_po[0]; // Ambil elemen pertama dari array $nomor_po
        $dataBarangKonfirmasi = $this->getBarangKonfirmasi($id, $nomor_po_value);
        // dd($dataBarangKonfirmasi);
        return view('pages.gBesar.detailRequestBarangGKecil', compact('data', 'user', 'nomor_po', 'dataBarangKonfirmasi'));
    }

    public function getBarangKonfirmasi($id, $nomor_po) {
        // $user = auth()->user()->id;
        // dd($id);
        $barangKonfirmasi = DB::select("SELECT p.id_produk, p.nama_produk, r.stok FROM request_gudang_kecil r
                    JOIN products p ON r.id_produk = p.id_produk
                    WHERE id_user = $id
                    AND nomor_po =  '$nomor_po->nomor_po'");
        // dd($barangKonfirmasi);
        return $barangKonfirmasi;
    }

    public function konfirmasiRequest(Request $request, $id_user, $nomor_po){
        $barangKonfirmasi = $this->getBarangKonfirmasiAdmin2($id_user, $nomor_po);
        // dd($request->all());;

        foreach ($barangKonfirmasi as $barang) {
            $id_produk = $barang->id_produk;
            $jumlahDiminta = $barang->stok;
            // dd($jumlahDiminta);
            $stokGudangBesar = $this->getStokGudangBesar($id_produk);
            // dd($stokGudangBesar);
            if ($stokGudangBesar < $jumlahDiminta) {
                // Stok kurang dari yang diminta, tampilkan pesan peringatan
                session()->flash('error', 'Stok barang tidak mencukupi untuk konfirmasi. Silahkan Cek kembali stok Gudang Besar Area!');
                return redirect()->back();
            }
        } 
        foreach ($barangKonfirmasi as $barang) {
                    $id_produk = $barang->id_produk;
                    $jumlahDiminta = $barang->stok;
            //         // dd($jumlahDiminta);
                    DB::update("UPDATE `gudang_besar` 
                        SET `stok` = `stok` - :stok
                        WHERE `id_produk` = :id_produk", [
                            'stok' => (int) $jumlahDiminta,
                            'id_produk' => $id_produk
                        ]);
                    }       
        $tanggal = Carbon::now();
        $coba = DB::update("UPDATE request_gudang_kecil SET konfirmasi2 = 1, tgl_konfirmasi2 = '$tanggal'
                    WHERE id_user = $id_user AND nomor_po = '$nomor_po';");
        // dd($coba);
        return redirect('/gBesar/request_gKecil/');
    }
    
    public function getBarangKonfirmasiAdmin2($id_user, $nomor_po) {
        $barangKonfirmasi = DB::select("SELECT id_produk, stok FROM request_gudang_kecil
                                        WHERE id_user = $id_user AND nomor_po = '$nomor_po'");
        // dd($barangKonfirmasi);
        return $barangKonfirmasi;
    }
    
    public function getStokGudangBesar($id_produk) {
        $stokGudangBesar = DB::select("SELECT stok FROM gudang_besar WHERE id_produk = '$id_produk'")[0]->stok;    
        // dd($stokGudangKecil);
        return $stokGudangBesar;
    }  
}
