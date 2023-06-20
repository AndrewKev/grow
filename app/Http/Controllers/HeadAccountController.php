<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HeadAccountController extends Controller
{
    public function headAccount(){
        return view('pages.headAcc.dashboard');
    }

    public function reqGudangBesar(){
        $daftarReq = $this->daftaReqGKecil();
        return view('pages.headAcc.requestBarangGBesar', compact('daftarReq'));
    }

    public function daftaReqGKecil() {
        $daftarReq = DB::select("SELECT u.id, u.nama, r.tanggal_po, r.deadline_kirim, r.catatan, MAX(r.created_at) AS created_at, r.konfirmasi, r.tgl_konfirmasi, r.tgl_req_gb
        FROM request_gudang_kecil AS r
        JOIN users AS u ON u.id = r.id_user
        WHERE r.konfirmasi3 = 0
        GROUP BY u.id, u.nama, r.tanggal_po,
         r.deadline_kirim, r.catatan, r.konfirmasi, r.tgl_konfirmasi, r.tgl_req_gb;");
        return $daftarReq;
    }

    public function detailReqGudangBesar($id){
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
        return view('pages.headAcc.detailRequestBarangGBesar', compact('data', 'user', 'dataBarangKonfirmasi'));
    }

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
        $coba = DB::update("UPDATE request_gudang_kecil SET konfirmasi3 = 1, tgl_konfirmasi3 = '$tanggal'
                    WHERE id_user = $id_user ;");
        $controller = new HistoryPimpinanAreaController();
        $controller->konfirmasiReqHA($id_user);
        // dd($coba);
        return redirect('/headAcc/request_gudang_besar/');
    }

    // HISTORY GUDANG BESAR
    public function historyRequestBarangGBesar(){
        $historyRequestGBesar = $this->getHistoryRequestGBesar();
        return view('pages.headAcc.historyRequestBarangGBesar', compact('historyRequestGBesar'));
    }

    public function getHistoryRequestGBesar(){
        $historyGBesar = DB::select("SELECT keterangan, tanggal, nama_admin, MAX(tanggal_po) AS tanggal_po, MAX(deadline_kirim) AS deadline_kirim, catatan, konfirmasi, konfirmasi2, MAX(tanggal_konfirm) AS tanggal_konfirm, MAX(tanggal_konfirm2) AS tanggal_konfirm2, MAX(created_at) AS created_at FROM history_stok_pimpinan_area GROUP BY keterangan, tanggal, nama_admin,  deadline_kirim, catatan, konfirmasi, konfirmasi2 ORDER BY created_at DESC;");
        return $historyGBesar;
    }

    public function detailHistoryRequestStorGBesar($keterangan, $nama_admin, $tanggal){
        $data = DB::select("SELECT  * FROM history_stok_pimpinan_area
        WHERE keterangan = '$keterangan' AND nama_admin  = '$nama_admin' AND tanggal = '$tanggal';");
        // dd($data);
        
        return view('pages.headAcc.detailHistoryRequestBarangGBesar', compact('data'));

    }
}
