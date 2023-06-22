<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HeadAccountController extends Controller
{
    public function headAccount(){
        return view('pages.headAcc.dashboard');
    }

    public function reqGudangKecil(){
        $daftarReq = $this->daftaReqGKecil();
        return view('pages.headAcc.requestBarangGKecil', compact('daftarReq'));
    }

    public function daftaReqGKecil() {
        $daftarReq = DB::select("SELECT u.id, u.nama, r.tanggal_po, r.deadline_kirim, r.catatan, MAX(r.created_at) AS created_at, r.konfirmasi
        FROM request_gudang_kecil AS r
        JOIN users AS u ON u.id = r.id_user
        WHERE r.konfirmasi = 0 AND r.konfirmasi3 = 0
        GROUP BY u.id, u.nama, r.tanggal_po,
         r.deadline_kirim, r.catatan, r.konfirmasi;");
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
        // $dataBarangKonfirmasi = 
        $dataBarangKonfirmasi = $this->getBarangKonfirmasi($id);
        // dd($dataBarangKonfirmasi);
        return view('pages.headAcc.detailRequestBarangGKecil', compact('data', 'user', 'dataBarangKonfirmasi'));
    }

    // public function isPimAreaAcc($id_user) { // cek apakah user sudah melakukan request ke admin
    //     $cek = DB::select("SELECT * FROM `request_gudang_kecil` 
    //                        WHERE id_user = '$id_user' AND ((konfirmasi2 = 1 AND konfirmasi = 0) OR (konfirmasi2 = 1) );");
    //     // dd($cek);
    //     if(sizeof($cek) > 0) {
    //         return true;
    //     }
    //     return false;
    // }

    public function getBarangKonfirmasi($id) {
        // $user = auth()->user()->id;
        // dd($id);
        $barangKonfirmasi = DB::select("SELECT p.id_produk, p.nama_produk, r.stok FROM request_gudang_kecil r
                    JOIN products p ON r.id_produk = p.id_produk
                    WHERE id_user = $id");
        // dd($barangKonfirmasi);
        return $barangKonfirmasi;
    }

    public function konfirmasiRequest(Request $request, $id_user){      
        $tanggal = Carbon::now();
        $coba = DB::update("UPDATE request_gudang_kecil SET konfirmasi3 = 1, tgl_konfirmasi3 = '$tanggal', catatan_pim_area = '$request->catatan'
                    WHERE id_user = $id_user ;");
        $controller = new HistoryPimpinanAreaController();
        $controller->konfirmasiReqHA($id_user);
        // dd($coba);
        return redirect('/headAcc/request_gudang_kecil/');
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

        return redirect('/headAcc/request_gudang_kecil/'.$id_user);
    }

    // HISTORY GUDANG BESAR
    public function historyRequestBarangGKecil(){
        $historyRequestGKecil = $this->getHistoryRequestGKecil();
        return view('pages.headAcc.historyRequestBarangGKecil', compact('historyRequestGKecil'));
    }

    public function getHistoryRequestGKecil(){
        $historyGKecil = DB::select("SELECT keterangan, tanggal, nama_admin, MAX(tanggal_po) AS tanggal_po, MAX(deadline_kirim) AS deadline_kirim, catatan, konfirmasi, konfirmasi2, konfirmasi3, catatan_pim_area, MAX(tanggal_konfirm) AS tanggal_konfirm, MAX(tanggal_konfirm2) AS tanggal_konfirm2,MAX(tanggal_konfirm3) AS tanggal_konfirm3, MAX(created_at) AS created_at FROM history_stok_pimpinan_area GROUP BY keterangan, tanggal, nama_admin,  deadline_kirim, catatan, konfirmasi, konfirmasi2,konfirmasi3, catatan_pim_area ORDER BY created_at DESC;");
        return $historyGKecil;
    }

    public function detailHistoryRequestStorGKecil($keterangan, $nama_admin, $tanggal){
        $data = DB::select("SELECT  * FROM history_stok_pimpinan_area
        WHERE keterangan = '$keterangan' AND nama_admin  = '$nama_admin' AND tanggal = '$tanggal';");
        // dd($data);
        
        return view('pages.headAcc.detailHistoryRequestBarangGKecil', compact('data'));

    }
}
