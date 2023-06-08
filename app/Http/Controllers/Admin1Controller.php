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
        $data = DB::select("SELECT r.id_user, r.id_produk, p.nama_produk,r.terjual, r.tanggal_stor_barang, r.tanggal_stor_uang, r.konfirmasi2, r.harga_produk, r.total_harga
                            FROM request_stor_barang r
                            JOIN products p ON p.id_produk = r.id_produk
                            WHERE id_user = $id AND r.konfirmasi2 = 0");
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
        return redirect('/admin/request_stor_uang');
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
