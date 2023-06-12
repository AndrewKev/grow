<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Absensi;
use App\Models\CarryProduk;
use App\Models\RequestBarang;
use App\Models\Penjualan;
use App\Models\Keterangan;
use App\Models\Toko;
use App\Models\StorProduk;
use App\Models\RequestStorBarang;
use App\Models\RincianUang;
use App\Http\Controllers\PenjualanLakuCashController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

use Carbon\Carbon;

// use App\Http\Controllers\AdminController;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $classSebelah = app('App\Http\Controllers\KPIController');
        // dd($classSebelah->index());
        return view('pages.karyawan.dashboard');
    }

    /**
     * Halaman Absensi
     */
    public function absensiPage() {
        // dd(auth()->user()->id);
        // dd(Absensi::where('id_user', auth()->user()->id)->get());
        // $listAbsenUser = DB::select('select * from absensi where id_user = '.auth()->user()->id);
        $username = auth()->user()->username;
        $finishStor = $this->isFinishStor(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $finishAbsensi = $this->isAbsensiFinish(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $listAbsenUser = DB::select("SELECT u.nama, u.no_telp, a.waktu_masuk, a.waktu_keluar, a.keterangan, a.latitude, a.longitude, a.foto
                                     FROM absensi as a
                                     JOIN users as u ON a.id_user = u.id
                                     WHERE u.username = '$username'
                                     ORDER BY a.waktu_masuk DESC");
        // dd(sizeof($listAbsenUser));
        return view('pages.karyawan.absensi', compact('listAbsenUser', 'finishStor', 'finishAbsensi'));
    }

    public function postAbsensi(Request $request) {
        // ddd($request);
        $validatedData = $request->validate([
            'foto' => 'image'
        ]);
    
        $fotoPath = $request->file('foto')->store('public/images'); // Simpan file gambar ke direktori penyimpanan
    
        Absensi::create([
            'id_user' => auth()->user()->id,
            'keterangan' => $request->keterangan,
            'waktu_masuk' => Carbon::now(),
            'foto' => $fotoPath, // Simpan path atau nama file gambar ke kolom 'foto'
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect('/user/absensi');
    }

    public function absensiKeluar() {
        $timeNow = Carbon::now();
        $lastIdAbsen = $this->getLastAbsen();
        $target = DB::update("UPDATE `absensi` 
                              SET `waktu_keluar` = '$timeNow' 
                              WHERE `absensi`.`id_absensi` = $lastIdAbsen;");
        
        return redirect('/user/absensi');
    }

    public function getLastAbsen() {
        $username = auth()->user()->username;
        $listAbsen = DB::select("SELECT a.id_absensi, a.id_user, a.waktu_keluar
                                 FROM absensi as a
                                 JOIN users as u ON a.id_user = u.id
                                 WHERE u.username = '$username'");
        
        $last = $listAbsen[sizeof($listAbsen)-1];                   
        return $last->id_absensi;
    }
    public function isFinishStor($id_user, $tanggal) { // cek apakah user sudah melakukan request ke admin
        $tanggal = Carbon::now()->format('Y-m-d');
        $cek = DB::select("SELECT * FROM `stor_produk` 
                           WHERE id_user = '$id_user' 
                           AND created_at BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    public function isAbsensiFinish($id_user, $tanggal) { // cek apakah user sudah melakukan request ke admin
        $tanggal = Carbon::now()->format('Y-m-d');
        $cek = DB::select("SELECT * FROM `absensi` 
                           WHERE id_user = '$id_user' 
                           AND waktu_keluar BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Halaman Stok Jalan
     */
    public function stokJalanPage() {
        $barang = $this->getStokUser();
        $req = $this->isRequest(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $konfirmasi = $this->isKonfirmasi(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $absenMasuk = $this->isAbsenMasuk(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $barangKonfirmasi = $this->getBarangKonfirmasi();
        $isCarry = $this->isCarry();

        // dd($barangKonfirmasi);
        return view('pages.karyawan.stokjalan', compact('barang', 'req', 'konfirmasi', 'barangKonfirmasi', 'isCarry', 'absenMasuk'));
    }

    public function isAbsenMasuk($id_user, $tanggal) { // cek apakah user sudah melakukan request ke admin
        $tanggal = Carbon::now()->format('Y-m-d');
        $cek = DB::select("SELECT * FROM `absensi` 
                           WHERE id_user = '$id_user' 
                           AND waktu_masuk BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }
    public function requestBarangStokJalan(Request $request) {
        // dd($request->all());

        for($i = 0; $i < 10; $i++) {
            if($request->produk[$i] != '0') {
                RequestBarang::create(
                    [
                        'id_user' => auth()->user()->id,
                        'id_produk' => $request->id_produk[$i],
                        'jumlah' => (int) $request->produk[$i],
                        'tanggal_request' => Carbon::now(),
                        'konfirmasi' => 0
                    ]
                );
            }
        }
        app('App\Http\Controllers\HistoryRequestSalesController')->salesRequest($request, 0, 0);

        return redirect('/user/stok_jalan');
    }

    public function getBarangKonfirmasi() {
        $user = auth()->user()->id;
        $barangKonfirmasi = DB::select("SELECT p.id_produk, p.nama_produk, r.jumlah FROM request_sales r
                    JOIN products p ON r.id_produk = p.id_produk
                    WHERE id_user = $user
                    AND konfirmasi =  1");

        return $barangKonfirmasi;
    }

    public function terimaBarang(Request $request) {
        $user = auth()->user()->id;
        if($request->has('setuju')) {
            // dd($request->all());
            for($i = 0; $i < sizeof($request->id_produk); $i++) {
                CarryProduk::create(
                    [
                        'id_user' => auth()->user()->id,
                        'id_produk' => $request->id_produk[$i],
                        'tanggal_carry' => Carbon::now(),
                        'stok_awal' => (int) $request->jumlah[$i],
                        'stok_sekarang' =>(int) $request->jumlah[$i],
                    ]
                );
                // app('App\Http\Controllers\HistoryRequestSalesController')->store($request);
                app('App\Http\Controllers\HistoryRequestSalesController')->konfirmasiSales($request, 'sales terima', $i);
            }
        }else {
            for($i = 0; $i < sizeof($request->id_produk); $i++) {
                app('App\Http\Controllers\HistoryRequestSalesController')->konfirmasiSales($request, 'sales tolak', $i);
            }
        }
        DB::delete("DELETE FROM request_sales WHERE id_user = $user");

        return redirect('/user/stok_jalan');
    }

    public function isRequest($id_user, $tanggal) { // cek apakah user sudah melakukan request ke admin
        $tanggal = Carbon::now()->format('Y-m-d');
        $cek = DB::select("SELECT * FROM `request_sales` 
                           WHERE id_user = '$id_user' 
                           AND tanggal_request BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    public function isKonfirmasi($id_user, $tanggal) { // cek apakah admin sudah melakukan konfirmasi
        $cek = DB::select("SELECT * FROM `request_sales` 
                           WHERE id_user = '$id_user' 
                           AND tanggal_request BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'
                           AND konfirmasi = 1;");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    public function isCarry() { // cek apakah sales sudah bawa barang
        if(sizeof($this->getStokUser()) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Penjualan Laku Cash
     */
    public function pageJualLakuCash() {
        return app('App\Http\Controllers\PenjualanLakuCashController')->index();
        // dd($classSebelah->getStok('B12'));
        // dd("tess");
    }

    public function postJualLakuCash(Request $request) {
        // dd($request->all());
        // $collectReq = collect($request);

        // $distrik = $collectReq->get('id_distrik');
        // $jumlahProduk = collect($collectReq->get('produk'));
        // $idProduk = collect($collectReq->get('id_produk'));

        // $att = collect(['id_produk', 'jumlah']);
        // $produk = $idProduk->combine($jumlahProduk->all());

        // $products = collect([]);
        // $products->push($att->all());
        
        // foreach($produk as $p) {

        // }

        // $singleProd = $prod->combine([$idProduk->all(), $jumlahProduk->all()]);

        // dd($products->all());
        
        return app('App\Http\Controllers\PenjualanLakuCashController')->store($request);
        // return redirect('/user/stok_jalan');
        // return redirect()->back('App\Http\Controllers\PenjualanLakuCashController')->index();

    }
    public function detailJualLakuCash($id_toko) {
        return app('App\Http\Controllers\PenjualanLakuCashController')->detailPenjualan($id_toko);
        // return redirect('/user/stok_jalan');
        // return redirect()->back('App\Http\Controllers\PenjualanLakuCashController')->index();
    }

    /**
    * Stor Produk
    */

    public function requestStorBarang(Request $request) {
        // dd($request->all());
        $user = auth()->user()->id;
        if($request->has('setujuStorProduk')) {
            // dd($request->all());
            for($i = 0; $i < sizeof($request->id_produk); $i++) {
                RequestStorBarang::create(
                    [
                    'id_user'=> auth()->user()->id,
                    'id_produk'=> $request->id_produk[$i],
                    'tanggal_stor_barang'=>Carbon::now(),
                    'stok_awal'=>(int) $request->stok_awal[$i],
                    'sisa_stok'=>(int) $request->stok_sekarang[$i],
                    'terjual'=>(int) $request->terjual[$i],
                    'harga_produk'=>(int) $request->harga_toko[$i],
                    'total_harga'=>(int) $request->total_harga[$i],
                    'konfirmasi' => 0,
                    ]
                );
            }
        }
        // DB::delete("DELETE FROM stor_produk WHERE id_user = $user");
        app('App\Http\Controllers\HistoryRequestSalesController')->salesRequestStorBarang($request, 0);
        return redirect('/user/stor_produk');
    }

    public function inputStorProduk(Request $request){
        // dd($request -> all());
        $user = auth()->user()->id;
        if($request->has('setujuStorProduk')) {
            // dd($request->all());
            for($i = 0; $i < sizeof($request->id_produk); $i++) {
                StorProduk::create(
                    [
                    'id_user'=> auth()->user()->id,
                    'id_produk'=> $request->id_produk[$i],
                    'tanggal_stor_barang'=>Carbon::now(),
                    'stok_awal'=>(int) $request->stok_awal[$i],
                    'sisa_stok'=>(int) $request->stok_sekarang[$i],
                    'harga_produk'=>(int) $request->harga_toko[$i],
                    'total_harga'=>(int) $request->total_harga[$i]
                    ]
                );
            }
        }
        // DB::delete("DELETE FROM stor_produk WHERE id_user = $user");
        return redirect('/user/stor_produk');
    }

    public function getStokUser() {
        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');
        $barang = DB::select("SELECT users.nama, c.*, products.nama_produk
        FROM carry_produk AS c
        JOIN products ON products.id_produk = c.id_produk
        JOIN users ON c.id_user = users.id
        WHERE c.id_user = '$id_user' AND c.tanggal_carry BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59';");

        return $barang;
    }
    public function getStorProduk(){
        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');
        $barang = DB::select("SELECT users.nama, c.*,
         products.nama_produk, 
         products.harga_toko, 
         c.stok_awal - c.stok_sekarang as terjual,
         (c.stok_awal - c.stok_sekarang) * products.harga_toko as total_harga
        FROM carry_produk AS c
        JOIN products ON products.id_produk = c.id_produk
        JOIN users ON c.id_user = users.id
        WHERE c.id_user = '$id_user' AND c.tanggal_carry BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59';");
        return $barang;
    }
    public function isRequestStorBarang($id_user, $tanggal) { // cek apakah user sudah melakukan request ke admin
        $tanggal = Carbon::now()->format('Y-m-d');
        $cek = DB::select("SELECT * FROM `request_stor_barang` 
                           WHERE id_user = '$id_user' 
                           AND tanggal_stor_barang BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    public function isKonfirmasiStorBarang($id_user, $tanggal) { // cek apakah admin sudah melakukan konfirmasi
        $cek = DB::select("SELECT * FROM `request_stor_barang` 
                           WHERE id_user = '$id_user' 
                           AND tanggal_stor_barang BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'
                           AND konfirmasi = 1;");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    public function isRequestStorUang($id_user, $tanggal) { // cek apakah user sudah melakukan request ke admin
        $tanggal = Carbon::now()->format('Y-m-d');
        $cek = DB::select("SELECT * FROM `request_stor_barang` 
                           WHERE id_user = '$id_user' 
                           AND tanggal_stor_barang BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59' AND konfirmasi = 1 AND konfirmasi2 = 0;");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    public function isKonfirmasiStorUang($id_user, $tanggal) { // cek apakah admin sudah melakukan konfirmasi
        $cek = DB::select("SELECT * FROM `request_stor_barang` 
                           WHERE id_user = '$id_user' 
                           AND tanggal_stor_barang BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'
                           AND konfirmasi = 1 AND konfirmasi2 = 1;");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }
    public function isTodayStorProduk($id_user, $tanggal) { // cek apakah admin sudah melakukan konfirmasi
        $cek = DB::select("SELECT * FROM stor_produk
                           WHERE id_user = $id_user
                           AND tanggal_stor_barang BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }
    public function getStorPenjualan(){
        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');
        $barang = DB::select("SELECT * FROM `request_stor_barang` 
        WHERE id_user = '$id_user' 
        AND tanggal_stor_barang BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
        return $barang;
    }
    public function tampilStorProduk() {
        $storproduk = $this->getStorProduk();
        $storPenjualan = $this->getStorPenjualan();
        $req = $this->isRequestStorBarang(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $reqUang = $this->isRequestStorUang(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $konfirmasi = $this->isKonfirmasiStorBarang(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $konfirmasiUang = $this->isKonfirmasiStorUang(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $storToday = $this->isTodayStorProduk(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $carryToday = $this->isCarry(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        // dd($storproduk);
        return view('pages.karyawan.storproduk', compact('storproduk','storPenjualan', 'req', 'reqUang', 'konfirmasi', 'konfirmasiUang', 'storToday', 'carryToday'));
    }


    /**
    * Stor Uang
    */
    public function requestStorUang(Request $request) {
        // dd($request->all());
        $user = auth()->user()->id;
        $today = Carbon::now()->format('Y-m-d');
        if($request->has('setujuStorUang')) {
            // dd($request->all());
            $request->validate([
                'seratusribu.*' => 'nullable|numeric|min:0',
                'limapuluhribu.*' => 'nullable|numeric|min:0',
                'duapuluhribu.*' => 'nullable|numeric|min:0',
                'sepuluhribu.*' => 'nullable|numeric|min:0',
                'limaribu.*' => 'nullable|numeric|min:0',
                'duaribu.*' => 'nullable|numeric|min:0',
                'seribu.*' => 'nullable|numeric|min:0',
                'seribukoin.*' => 'nullable|numeric|min:0',
                'limaratuskoin.*' => 'nullable|numeric|min:0',
                'duaratuskoin.*' => 'nullable|numeric|min:0',
                'seratuskoin.*' => 'nullable|numeric|min:0',
            ]);

            $totalUang = 100000 * $request->input('seratusribu', 0)
                 + 50000 * $request->input('limapuluhribu', 0)
                 + 20000 * $request->input('duapuluhribu', 0)
                 + 10000 * $request->input('sepuluhribu', 0)
                 + 5000 * $request->input('limaribu', 0)
                 + 2000 * $request->input('duaribu', 0)
                 + 1000 * $request->input('seribu', 0)
                 + 1000 * $request->input('seribukoin', 0)
                 + 500 * $request->input('limaratuskoin', 0)
                 + 200 * $request->input('duaratuskoin', 0)
                 + 100 * $request->input('seratuskoin', 0);
            // dd($totalUang);
            $result = DB::select("SELECT total_harga FROM `request_stor_barang` 
                                        WHERE id_user = '$user' 
                                        AND tanggal_stor_barang BETWEEN '$today 00:00:00' AND '$today 23:59:59'
                                        AND konfirmasi = 1;");
            $totalHarga = 0;
            foreach ($result as $item) {
                $totalHarga += $item->total_harga;
            }

            // dd($totalHarga);
            if ($totalUang != $totalHarga) {
                $errorMessage = 'Jumlah uang yang Anda masukkan (' . $totalUang . ') tidak sesuai dengan total harga (' . $totalHarga . ').';
                return back()->with('error', $errorMessage);
            }else{
                $user = auth()->user()->id;
                $today = Carbon::now()->format('Y-m-d');
                // dd($request->all());
                RincianUang::create(
                    [
                        'id_user' => auth()->user()->id,
                        'tanggal_masuk'=>$today,
                        'seratus_ribu' => $request->input('seratusribu'),
                        'lima_puluh_ribu' => $request->input('limapuluhribu'),
                        'dua_puluh_ribu' => $request->input('duapuluhribu'),
                        'sepuluh_ribu' => $request->input('sepuluhribu'),
                        'lima_ribu' => $request->input('limaribu'),
                        'dua_ribu' => $request->input('duaribu'),
                        'seribu' => $request->input('seribu'),
                        'seribu_koin' => $request->input('seribukoin'),
                        'lima_ratus_koin' => $request->input('limaratuskoin'),
                        'dua_ratus_koin' => $request->input('duaratuskoin'),
                        'seratus_koin' => $request->input('seratuskoin'),
                    ]
                );     
                $ambilUang = DB::select("SELECT * FROM `rincian_uang` 
                       WHERE id_user = '$user' 
                       AND tanggal_masuk = '$today'
                       ORDER BY created_at DESC
                       LIMIT 1");
                // dd($ambilUang);      
                $record = RequestStorBarang::where('id_user', $user)
                    ->whereBetween('tanggal_stor_barang', [$today . ' 00:00:00', $today . ' 23:59:59'])
                    ->first();
                // dd($record);
                if ($record) {
                    $record->where('id_user', $user)->update([
                        'tanggal_stor_uang' => Carbon::now(),
                        'konfirmasi2' => 0,
                        'id_rincian_uang' => $ambilUang[0]->id_rincian_uang
                    ]);
                }
            } 
        }
        // DB::delete("DELETE FROM stor_produk WHERE id_user = $user");
        app('App\Http\Controllers\HistoryRequestSalesController')->salesRequestStorPenjualan($request, 0);
        return redirect('/user/stor_produk');
    }

    public function insertStorProduk(Request $request) {
        $user = auth()->user()->id;
        if($request->has('setujuinsert')) {
        // dd($request->all());
            for($i = 0; $i < sizeof($request->id_produk); $i++) {
                StorProduk::create(
                    [
                    'id_user'=> auth()->user()->id,
                    'id_produk'=> $request->id_produk[$i],
                    'tanggal_stor_barang'=>$request->tanggal_stor_barang[$i],
                    'tanggal_stor_uang'=>$request->tanggal_stor_uang[$i],
                    'stok_awal'=>(int) $request->stok_awal[$i],
                    'terjual'=>(int)$request->terjual[$i],
                    'sisa_stok'=>(int) $request->sisa_stok[$i],
                    'harga_produk'=>(int) $request->harga_produk[$i],
                    'total_harga'=>(int) $request->total_harga[$i],
                    'id_rincian_uang'=>(int) $request->id_rincian_uang[$i]
                    ]
                );
            }
        }

        // app('App\Http\Controllers\HistoryRequestSalesController')->konfirmasiSalesPenjualan($request, 'sales konfirmasi selesai', $i);
        DB::delete("DELETE FROM request_stor_barang WHERE id_user = $user");

        // create KPI
        app('App\Http\Controllers\KPIController')->insertKPI();
        return redirect('/user/stor_produk');

    }

    public function tokoDropdown($id_routing) {
        return app('App\Http\Controllers\PenjualanLakuCashController')->getTokoDariRouting($id_routing);
    }

    // public function insertBarang($id_produk, $jumlahBarang) {
    //     CarryProduk::create(
    //         [
    //             'id_user' => auth()->user()->id,
    //             'id_produk' => $id_produk,
    //             'tanggal_carry' => Carbon::now()->format('Y-m-d'),
    //             'stok_dibawa'=> $jumlahBarang
    //         ]
    //     );
    // }

    // public function updateBarang($id_produk, $jumlahBarang) {
    //     $id_user = auth()->user()->id;
    //     DB::update("UPDATE carry_produk SET stok_dibawa = $jumlahBarang 
    //                 WHERE id_produk = '$id_produk' AND id_user = '$id_user';");
    // }

    // public function cekBarangDibawa($id_produk, $tanggal) {
    //     $id_user = auth()->user()->id;
    //     $barang = DB::select("SELECT * FROM `carry_produk` 
    //     WHERE id_user = '$id_user' 
    //     AND id_produk = '$id_produk'
    //     AND tanggal_carry = '$tanggal';");

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
