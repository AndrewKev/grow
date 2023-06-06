<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }
    /**
     * Admin 2
     */
    public function admin2Page() {
        return view('pages.admin2.dashboard');
    }

    public function reqSalesPage() {
        $daftarReq = $this->daftaReqSales();
        return view('pages.admin2.request', compact('daftarReq'));
    }

    public function detailReqSales($id) {
        $data = DB::select("SELECT r.id_user, r.id_produk, p.nama_produk, r.jumlah, r.tanggal_request 
                            FROM request_sales r
                            JOIN products p ON p.id_produk = r.id_produk
                            WHERE id_user = $id");
        $sales = DB::select("SELECT id, nama
                            FROM users
                            WHERE id = $id");
        // dd($data);
        return view('pages.admin2.detailRequest', compact('data', 'sales'));
    }

    public function ubahRequestStok(Request $request, $id_user, $id_produk) {
        // dd($request);
        DB::update("UPDATE request_sales SET jumlah = $request->jumlah
        WHERE id_user = $id_user
        AND id_produk = '$id_produk'");

        return redirect('/admin2/request_sales/'.$id_user);
    }

    public function daftaReqSales() {
        $daftarSales = DB::select("SELECT DISTINCT u.id, u.nama, r.tanggal_request 
                                   FROM request_sales AS r
                                   JOIN users AS u ON u.id = r.id_user
                                   WHERE konfirmasi = 0;");
        return $daftarSales;
    }

    public function konfirmasiRequest($id_user) {
        // dd("hello");
        DB::update("UPDATE request_sales SET konfirmasi = 1
                    WHERE id_user = $id_user");

        app('App\Http\Controllers\HistoryRequestSalesController')->konfirmasiAdmin($id_user);
        return redirect('/admin2/request_sales');
    }

    public function test() {
        dd(app('App\Http\Controllers\HistoryRequestSalesController')->getReqKonfirmasiByIdSales(4));
    }

    // SALES REQ BARANG

    public function daftaReqSalesStorBarang() {
        $daftarSales = DB::select("SELECT DISTINCT u.id, u.nama, r.tanggal_stor 
                                   FROM request_stor_barang AS r
                                   JOIN users AS u ON u.id = r.id_user
                                   WHERE konfirmasi = 0;");
        return $daftarSales;
    }

    public function reqSalesStorBarang() {
        $daftarReqStorBarang = $this->daftaReqSalesStorBarang();
        // dd($daftarReqStorBarang);
        return view('pages.admin2.requestStorBarang', compact('daftarReqStorBarang'));
    }

    public function detailReqSalesStorBarang($id) {
        $data = DB::select("SELECT r.id_user, r.id_produk, p.nama_produk, r.stok_awal,r.terjual, r.sisa_stok, r.tanggal_stor, r.konfirmasi
                            FROM request_stor_barang r
                            JOIN products p ON p.id_produk = r.id_produk
                            WHERE id_user = $id AND r.konfirmasi = 0");
        $sales = DB::select("SELECT id, nama
                            FROM users
                            WHERE id = $id");
        // dd($data);
        return view('pages.admin2.detailRequestStorBarang', compact('data', 'sales'));
    }

    public function konfirmasiRequestStorBarang($id_user) {
        // dd("hello");
        DB::update("UPDATE request_stor_barang SET konfirmasi = 1
                    WHERE id_user = $id_user");
        return redirect('/admin2/request_stor_barang');
    }


    // public function cekBarang($id_user, $id_produk) {
    //     $tanggal = Carbon::now()->format('Y-m-d');
    //     $barang = DB::select("SELECT * FROM `request_sales` 
    //     WHERE id_user = '$id_user' 
    //     AND id_produk = '$id_produk'
    //     AND tanggal_request = '$tanggal';");

    //     return sizeof($barang);
    // }

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
