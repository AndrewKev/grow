<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RequestGudangKecil;
use App\Models\Product;
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
        $daftarSales = DB::select("SELECT DISTINCT u.id, u.nama, r.tanggal_stor_barang
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
        $data = DB::select("SELECT r.id_user, r.id_produk, p.nama_produk, r.stok_awal,r.terjual, r.sisa_stok, r.tanggal_stor_barang, r.konfirmasi
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
        app('App\Http\Controllers\HistoryRequestSalesController')->konfirmasiAdminStorBarang($id_user);
        return redirect('/admin2/request_stor_barang');
    }

    // HISTORY REQUEST SALES
    public function historyRequestSales(){
        $historyReqSales = $this->getHistoryRequestSales();
        return view('pages.admin2.historyRequestSales', compact('historyReqSales'));
    }

    public function getHistoryRequestSales(){
        $historyReqSales = DB::select("SELECT keterangan, tanggal, nama_sales, MAX(created_at) AS created_at FROM history_request_stok_sales GROUP BY keterangan, tanggal, nama_sales ORDER BY created_at DESC;");
        return $historyReqSales;

    }

    public function detailHistoryRequestSales($keterangan, $nama_sales){
        $data = DB::select("SELECT  * FROM history_request_stok_sales
        WHERE keterangan = '$keterangan' AND nama_sales = '$nama_sales';");
        // dd($data);
        
        return view('pages.admin2.detailHistoryRequestSales', compact('data'));
    }

    public function historyRequestStorBarang(){
        $historyReqSalesSP = $this->getHistoryRequestSalesStorBarang();
        return view('pages.admin2.historyRequestSalesStorBarang', compact('historyReqSalesSP'));
    }

    public function getHistoryRequestSalesStorBarang(){
        // $historyReqSales = DB::select("SELECT DISTINCT keterangan, tanggal, nama_sales FROM history_request_sales_stor_produk;");
        // return $historyReqSales;
        $historyReqSales = DB::select("SELECT keterangan, tanggal, nama_sales, MAX(created_at) AS created_at FROM history_request_sales_stor_produk GROUP BY keterangan, tanggal, nama_sales ORDER BY created_at DESC;");
        return $historyReqSales;
    }

    public function detailHistoryRequestStorBarang($keterangan, $nama_sales){
        $data = DB::select("SELECT  * FROM history_request_sales_stor_produk
        WHERE keterangan = '$keterangan' AND nama_sales = '$nama_sales';");
        // dd($data);
        
        return view('pages.admin2.detailHistoryRequestSalesStorBarang', compact('data'));
    }
    

    // STOK GUDANG KECIL
    public function stokGudangKecil(){
        $stokSample = $this->getStokSampleBarang();
        $requestBarang = $this->isRequestProduk(auth()->user()->id);
        $accPimArea = $this->isPimAreaAcc(auth()->user()->id);
        $accGBesar = $this->isGudangBesarAcc(auth()->user()->id);
        $barangKonfirmasi = $this->getBarangKonfirmasi();
        return view('pages.admin2.stokGudangKecil', compact('stokSample', 'requestBarang', 'accPimArea', 'accGBesar', 'barangKonfirmasi'));
    }

    public function getBarangKonfirmasi() {
        $user = auth()->user()->id;
        $barangKonfirmasi = DB::select("SELECT p.id_produk, p.nama_produk, r.stok FROM request_gudang_kecil r
                    JOIN products p ON r.id_produk = p.id_produk
                    WHERE id_user = $user
                    AND konfirmasi2 =  1");

        return $barangKonfirmasi;
    }

    public function getStokSampleBarang(){
        $stokSampleBarang = DB::select("SELECT * FROM gudang_kecil");
        return $stokSampleBarang;
    }

    public function isRequestProduk($id_user) { // cek apakah user sudah melakukan request ke admin
        $cek = DB::select("SELECT * FROM `request_gudang_kecil` 
                           WHERE id_user = '$id_user' AND konfirmasi = 0;");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    public function isPimAreaAcc($id_user) { // cek apakah user sudah melakukan request ke admin
        $cek = DB::select("SELECT * FROM `request_gudang_kecil` 
                           WHERE id_user = '$id_user' AND konfirmasi = 1 AND konfirmasi2 = 0;");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    public function isGudangBesarAcc($id_user) { // cek apakah user sudah melakukan request ke admin
        $cek = DB::select("SELECT * FROM `request_gudang_kecil` 
                           WHERE id_user = '$id_user' AND konfirmasi2 = 1;");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    public function requestStokGKecil(Request $request) {
        // dd($request->all());
        for($i = 0; $i < 10; $i++) {
            if($request->produk[$i] != '0') {
                $produk = Product::where('id_produk', $request->id_produk[$i])->first(); // Ambil data produk dari tabel products
                // dd($produk);
                $hargaStok = $produk->harga_toko * (int) $request->produk[$i]; // Kalikan harga_toko dengan stok
                // dd($hargaStok);
                RequestGudangKecil::create(
                    [
                        'id_user' => auth()->user()->id,
                        'id_produk' => $request->id_produk[$i],
                        'tanggal_po' => Carbon::now()->format('Y-m-d'),
                        'nomor_po' =>$request->nomor_po,
                        'stok' => (int) $request->produk[$i],
                        'harga_stok' => $hargaStok,
                        'deadline_kirim' =>Carbon::now()->addDays(2),
                        'catatan' => $request->catatan,
                        'konfirmasi' => 0
                    ]
                );
            }
        }
        return redirect('/admin2/stok_barang_gKecil');
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
