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
        $daftarReq = DB::select("SELECT u.id, u.nama, r.tanggal_po, r.deadline_kirim, r.catatan,MAX(r.created_at) AS created_at
        FROM request_gudang_kecil AS r
        JOIN users AS u ON u.id = r.id_user
        WHERE r.konfirmasi = 0 AND r.konfirmasi3=0
        GROUP BY u.id, u.nama,r.tanggal_po, r.deadline_kirim,r.catatan");
        return $daftarReq;
    }

    public function detailReqGudangKecil($id){
        $data = DB::select("SELECT r.id_user, r.id_produk, p.nama_produk, r.stok, r.sample, r.harga_stok, r.created_at
                            FROM request_gudang_kecil r
                            JOIN products p ON p.id_produk = r.id_produk
                            WHERE id_user = $id");
        $user = DB::select("SELECT id, nama
                            FROM users
                            WHERE id = $id");
        // dd($data);
        return view('pages.pimArea.detailRequestBarangGKecil', compact('data', 'user'));
    }

    public function ubahReqGudangKecil(Request $request, $id_user, $id_produk){
        // dd($request->all());
        $produk = Product::where('id_produk', $request->id_produk)->first(); // Ambil data produk dari tabel products
                // dd($produk);
        $hargaStok = $produk->harga_toko * (int) $request->jumlah; 
        // dd($hargaStok);
        DB::update("UPDATE request_gudang_kecil SET stok = $request->jumlah, harga_stok = $hargaStok
        WHERE id_user = $id_user 
        AND id_produk = '$id_produk'");
        
        // DB::update("UPDATE request_gudang_kecil SET stok = $request->jumlah
        // WHERE id_user = $id_user AND nomor_po = '$nomor_po'
        // AND id_produk = '$id_produk'");

        return redirect('/pimArea/daftar_req_gudang_kecil/'.$id_user);
    }

    public function konfirmasiRequest($id_user){
        // dd($nomor_po);
        // dd($id_user );
        $tanggal = Carbon::now();
        $coba = DB::update("UPDATE request_gudang_kecil SET konfirmasi = 1, tgl_konfirmasi = '$tanggal'
                    WHERE id_user = $id_user;");
        // dd($coba);
        // ('App\Http\Controllers\HistoryPimpinanAreaController')->konfirmasiStokPA($id_user);
        $controller = new HistoryPimpinanAreaController();
        $controller->konfirmasiStokPA($id_user);
        return redirect('/pimArea/daftar_req_gudang_kecil/');
    }


    // HISTORY REQUEST GUDANG KECIL
    public function historyRequestBarangGKecil(){
        $historyRequestGKecil = $this->getHistoryRequestGKecil();
        return view('pages.pimArea.historyRequestBarangGKecil', compact('historyRequestGKecil'));
    }

    public function getHistoryRequestGKecil(){
        $historyGKecil = DB::select("SELECT keterangan, tanggal, nama_admin, MAX(tanggal_po) AS tanggal_po, MAX(deadline_kirim) AS deadline_kirim, catatan, konfirmasi, konfirmasi2, konfirmasi3, catatan_pim_area, MAX(tanggal_konfirm) AS tanggal_konfirm, MAX(tanggal_konfirm2) AS tanggal_konfirm2,MAX(tanggal_konfirm3) AS tanggal_konfirm3, MAX(created_at) AS created_at FROM history_stok_pimpinan_area GROUP BY keterangan, tanggal, nama_admin,  deadline_kirim, catatan, konfirmasi, konfirmasi2,konfirmasi3, catatan_pim_area ORDER BY created_at DESC;");
        return $historyGKecil;
    }

    public function detailHistoryRequestStorGKecil($keterangan, $nama_admin, $tanggal){
        $data = DB::select("SELECT  * FROM history_stok_pimpinan_area
        WHERE keterangan = '$keterangan' AND nama_admin  = '$nama_admin'AND tanggal = '$tanggal';");
        // dd($data);
        
        return view('pages.pimArea.detailHistoryRequestBarangGKecil', compact('data'));

    }

    // ABSESNSI
    public function tampilAbsensi(){
        $listAbsenUser = DB::select("SELECT u.nama, u.no_telp, a.waktu_masuk, a.waktu_keluar, a.keterangan, a.foto, a.latitude, a.longitude
                        FROM absensi as a
                        JOIN users as u ON a.id_user = u.id
                        ORDER BY a.waktu_masuk DESC");
        // dd($listAbsenUser);
        return view('pages.pimArea.tampilAbsensi', compact('listAbsenUser'));
    }

    // GUDANG BESAR
    public function tampilGudangBesar(){
        $stokSample = $this->getStokSampleBarang();
        return view('pages.pimArea.stokBarangGBesar', compact('stokSample'));
    }

    public function getStokSampleBarang(){
        $stokSampleBarang = DB::select("SELECT * FROM gudang_besar");
        return $stokSampleBarang;
    }


    // GUDANG KECIL
    public function tampilGudangKecil(){
        $stokSample = $this->getStokSampleBarangGKecil();
        return view('pages.pimArea.stokBarangGKecil', compact('stokSample'));
    }

    public function getStokSampleBarangGKecil(){
        $stokSampleBarang = DB::select("SELECT * FROM gudang_kecil");
        return $stokSampleBarang;
    }
}
