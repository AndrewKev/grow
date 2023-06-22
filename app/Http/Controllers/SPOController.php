<?php

namespace App\Http\Controllers;

use App\Models\RequestBarang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class SPOController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.spo.dashboard');
    }

    /**
     * Menampilkan halaman absensi SPO.
     */
    public function pageAbsensiSPO() {
        $username = auth()->user()->username;
        $finishStor = $this->isFinishStor(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $isAbsensi = $this->isAbsensi(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $listAbsenUser = DB::select("SELECT u.nama, u.no_telp, a.waktu_masuk, a.waktu_keluar, a.keterangan, a.latitude, a.longitude, a.foto
                                     FROM absensi as a
                                     JOIN users as u ON a.id_user = u.id
                                     WHERE u.username = '$username'
                                     ORDER BY a.waktu_masuk DESC");

        return app('App\Http\Controllers\AbsensiController')->indexSpo($finishStor, $isAbsensi, $listAbsenUser);
    }

    /**
     * Cek apakah user sudah melakukan stor.
     * Return boolean.
     */
    protected function isFinishStor($id_user, $tanggal) {
        $tanggal = Carbon::now()->format('Y-m-d');
        $cek = DB::select("SELECT * FROM stor_produk
            WHERE id_user = '$id_user'
            AND created_at BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");

        $collection = collect($cek);
        if($collection->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Absensi untuk SPO.
     */
    public function postAbsensi(Request $request) {
        return app('App\Http\Controllers\AbsensiController')->store($request);
    }

    /**
     * Cek apakah user sudah melakukan absensi.
     * Return boolean.
     */
    protected function isAbsensi($id_user, $tanggal) {
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
     * Cek apakah user sudah melakukan absensi.
     * Return boolean.
     */
    public function isAbsenMasuk($id_user, $tanggal) {
        $cek = DB::select("SELECT * FROM `absensi`
                           WHERE id_user = '$id_user'
                           AND waktu_masuk BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Mendapatkan stok yang dibawah oleh sales SPO.
     * Return Collection.
     */
    public function getStokSPO() {
        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');
        $barang = DB::select("SELECT u.nama, c.*, p.nama_produk
            FROM carry_spo c
            JOIN products p ON p.id_produk = c.id_produk
            JOIN users u ON c.id_user = u.id
            WHERE c.id_user = 12 AND c.tanggal_carry BETWEEN '2023-06-22 00:00:00' AND '2023-06-22 23:59:59';");

        $collection = collect($barang);
        return $collection;
    }

    /**
     * Cek apakah sales sudah membawa barang.
     * Return boolean.
     */
    public function isCarry() {
        if($this->getStokSPO()->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Cek apakah user sudah melakukan request barang ke admin.
     * Return boolean.
     */
    public function isRequest($id_user, $tanggal) {
        $cek = DB::select("SELECT * FROM `request_sales`
                           WHERE id_user = '$id_user'
                           AND tanggal_request BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");

        $collection = collect($cek);
        if($collection->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Cek apakah admin sudah melakukan konfirmasi terhadap request barang.
     * Return boolean.
     */
    public function isKonfirmasi($id_user, $tanggal) {
        $cek = DB::select("SELECT * FROM `request_sales`
                           WHERE id_user = '$id_user'
                           AND tanggal_request BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'
                           AND konfirmasi = 1;");

        $collection = collect($cek);
        if($collection->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Get barang yg sudah dikonfirmasi oleh admin.
     * Return .
     */
    public function getBarangKonfirmasi() {
        $user = auth()->user()->id;
        $barangKonfirmasi = DB::select("SELECT p.id_produk, p.nama_produk, r.jumlah FROM request_sales r
                    JOIN products p ON r.id_produk = p.id_produk
                    WHERE id_user = $user
                    AND konfirmasi =  1");

        $collection = collect($barangKonfirmasi);
        return $collection;
        // return $barangKonfirmasi;
    }

    /**
     * Menampilkan halaman stok jalan.
     */
    public function stokJalanPage() {
        $barang = $this->getStokSPO();
        $req = $this->isRequest(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $konfirmasi = $this->isKonfirmasi(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $absenMasuk = $this->isAbsenMasuk(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $barangKonfirmasi = $this->getBarangKonfirmasi();
        $isCarry = $this->isCarry();

        // dd($this->getStokSPO()->count());
        return view('pages.spo.stokJalan', compact('barang', 'req', 'konfirmasi', 'absenMasuk', 'barangKonfirmasi', 'isCarry'));
    }

    /**
     * Request barang ke admin.
     */
    public function requestBarangStokJalan(Request $request) {
        $keys = collect(['idProduk', 'namaProduk', 'jumlah']);
        $products = collect();

        for ($i=0; $i < sizeof($request->jumlah); $i++) {
            $combined = $keys->combine([$request->id_produk[$i], $request->nama_produk[$i], (int)$request->jumlah[$i]]);
            $products->push($combined->all());
        }

        $filteredProduct = $products->where('jumlah', '!=', 0);

        foreach($filteredProduct as $inp) {
            RequestBarang::create(
                [
                    'id_user' => auth()->user()->id,
                    'id_produk' => $inp['idProduk'],
                    'jumlah' => $inp['jumlah'],
                    'tanggal_request' => Carbon::now(),
                    'konfirmasi' => 0
                ]
            );
        }

        return redirect('/spo/stok_jalan');
        // dd($filteredProduct->get(0)['namaProduk']);
    }

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
