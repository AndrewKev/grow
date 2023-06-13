<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Admin1Controller extends Controller
{
    public function admin1Page() {
        return view('pages.admin.dashboard');
    }

    public function daftaReqSalesStorUang() {
        $daftarSales = DB::select("SELECT DISTINCT u.id, u.nama, r.tanggal_stor_barang 
                                   FROM request_stor_barang AS r
                                   JOIN users AS u ON u.id = r.id_user
                                   WHERE konfirmasi2 = 0;");
        return $daftarSales;
    }
    public function reqSalesStorUang() {
        $daftarReqStorUang = $this->daftaReqSalesStorUang();
        return view('pages.admin.requestStorProduk', compact('daftarReqStorUang'));
    }

    public function detailReqSalesStorUang($id) {
        // $tanggal = Carbon::now()->format('Y-m-d');
        $data = DB::select("SELECT r.id_user, r.id_produk, p.nama_produk,r.terjual, r.tanggal_stor_barang, r.tanggal_stor_uang, r.konfirmasi2, r.harga_produk, r.total_harga, ru.seratus_ribu, ru.lima_puluh_ribu, ru.dua_puluh_ribu, ru.sepuluh_ribu, ru.lima_ribu, ru.dua_ribu, ru.seribu, ru.seribu_koin, ru.lima_ratus_koin, ru.dua_ratus_koin, ru.seratus_koin 
                            FROM request_stor_barang r 
                            JOIN products p ON p.id_produk = r.id_produk 
                            JOIN rincian_uang ru ON ru.id_rincian_uang = r.id_rincian_uang 
                            WHERE r.id_user = $id AND r.konfirmasi2 = 0");
        $sales = DB::select("SELECT id, nama
                            FROM users
                            WHERE id = $id");
        // dd($data);
        return view('pages.admin.detailRequestStorProduk', compact('data', 'sales'));
    }

    public function konfirmasiRequestStorUang($id_user) {
        // dd("hello");
        DB::update("UPDATE request_stor_barang SET konfirmasi2 = 1
                    WHERE id_user = $id_user");
                    app('App\Http\Controllers\HistoryRequestSalesController')->konfirmasiAdminStorPenjualan($id_user);
        return redirect('/admin/request_stor_uang');
    }

    public function tampilAbsensi(){
        $listAbsenUser = DB::select("SELECT u.nama, u.no_telp, a.waktu_masuk, a.waktu_keluar, a.keterangan, a.latitude, a.longitude
                        FROM absensi as a
                        JOIN users as u ON a.id_user = u.id
                        ORDER BY a.waktu_masuk DESC");
        // dd($listAbsenUser);
        return view('pages.admin.tampilAbsensi', compact('listAbsenUser'));
    }

    public function historyRequestStorUang(){
        $historyReqSalesSU = $this->getHistoryRequestSalesStorUang();
        return view('pages.admin.historyRequestStorProduk', compact('historyReqSalesSU'));
    }

    public function getHistoryRequestSalesStorUang(){
        // $historyReqSales = DB::select("SELECT DISTINCT keterangan, tanggal, nama_sales FROM history_request_sales_stor_penjualan;");
        // return $historyReqSales;
        $historyReqSales = DB::select("SELECT keterangan, tanggal, nama_sales, MAX(created_at) AS created_at FROM history_request_sales_stor_penjualan GROUP BY keterangan, tanggal, nama_sales ORDER BY created_at DESC;");
        return $historyReqSales;
    }

    public function detailHistoryRequestStorUang($keterangan, $nama_sales){
        $data = DB::select("SELECT  * FROM history_request_sales_stor_penjualan
        WHERE keterangan = '$keterangan' AND nama_sales = '$nama_sales';");
        // dd($data);
        
        return view('pages.admin.detailHistoryRequestSalesStorPenjualan', compact('data'));
    }
    // public function konfirmasiRequestStorUang($id_user){
    //     // dd($request -> all());
    //     $user = auth()->user()->id;
    //     DB::update("UPDATE request_stor_barang SET konfirmasi2 = 1
    //                 WHERE id_user = $user");
        
    //     // if($request->has('setujuStorUang')) {
    //     //     // dd($request->all());
    //     //     for($i = 0; $i < sizeof($request->id_produk); $i++) {
    //     //         StorProduk::create(
    //     //             [
    //     //             'id_user'=> auth()->user()->id,
    //     //             'id_produk'=> $request->id_produk[$i],
    //     //             'tanggal_stor'=>Carbon::now(),
    //     //             'stok_awal'=>(int) $request->stok_awal[$i],
    //     //             'sisa_stok'=>(int) $request->stok_sekarang[$i],
    //     //             'harga_produk'=>(int) $request->harga_toko[$i],
    //     //             'total_harga'=>(int) $request->total_harga[$i]
    //     //             ]
    //     //         );
    //     //     }
    //     // }
    //     // DB::delete("DELETE FROM stor_produk WHERE id_user = $user");
    //     return redirect('/admin/request_stor_uang');
    // }

}
