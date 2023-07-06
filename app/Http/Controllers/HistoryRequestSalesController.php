<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoryRequest;
use App\Models\HistoryRequestBarang;
use App\Models\HistoryRequestPenjualan;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;



class HistoryRequestSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd($this->adminKonfirmasi(4));
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
    public function salesRequest(Request $request, $konfirmasiAdmin, $konfirmasiSales)
    {
        for($i = 0; $i < sizeof($request->id_produk); $i++) {
            if($request->produk[$i] != '0') {
                $history = HistoryRequest::create(
                    [
                        'tanggal' => Carbon::now(),
                        'nama_sales' => auth()->user()->nama,
                        'nama_produk'=> $request->nama_produk[$i],
                        'jumlah' => (int) $request->produk[$i],
                        'konfirmasi_admin' => $konfirmasiAdmin,
                        'konfirmasi_sales' => $konfirmasiSales,
                        'keterangan' => 'sales request',
                    ]
                );
            }
        }

        return $history;
    }

    public function konfirmasiAdmin($id_user) {
        $dataKonfirmasi = $this->getReqKonfirmasiByIdSales($id_user);

        foreach ($dataKonfirmasi as $data) {
            $history = HistoryRequest::create(
                [
                    'tanggal' => Carbon::now(),
                    'nama_sales' => $data->nama,
                    'nama_produk'=> $data->nama_produk,
                    'jumlah' => $data->jumlah,
                    'konfirmasi_admin' => 1,
                    'konfirmasi_sales' => 0,
                    'keterangan' => 'admin konfirmasi',
                ]
            );
        }

        return $history;
    }

    public function konfirmasiSales(Request $request, $keterangan, $i) {
        $history = HistoryRequest::create(
            [
                'tanggal' => Carbon::now(),
                'nama_sales' => auth()->user()->nama,
                'nama_produk'=> $request->nama_produk[$i],
                'jumlah' => (int) $request->jumlah[$i],
                'konfirmasi_admin' => 1,
                'konfirmasi_sales' => 1,
                'keterangan' => $keterangan, // sales terima / tolak
            ]
        );

        return $history;
    }

    public function getReqKonfirmasiByIdSales($id_user) {
        $data = DB::select("SELECT r.id_user, u.nama, r.id_produk, p.nama_produk, r.jumlah, r.konfirmasi
                    FROM request_sales r
                    JOIN products p ON p.id_produk = r.id_produk
                    JOIN users u ON r.id_user = u.id
                    WHERE r.konfirmasi = 1 AND r.id_user = $id_user");

        return $data;
    }

    // HISTORY REQUEST STOR BARANG
    public function salesRequestStorBarang(Request $request, $konfirmasiAdmin)
    {
        for($i = 0; $i < sizeof($request->id_produk); $i++) {
                $history = HistoryRequestBarang::create(
                    [
                        'tanggal' => Carbon::now(),
                        'nama_sales' => auth()->user()->nama,
                        'nama_produk'=> $request->nama_produk[$i],
                        'stok_awal'=>(int) $request->stok_awal[$i],
                        'sisa_stok'=>(int) $request->stok_sekarang[$i],
                        'terjual'=>(int) $request->terjual[$i],
                        'konfirmasi_admin' => $konfirmasiAdmin,
                        'keterangan' => 'sales request',
                    ]
                );
        }

        return $history;
    }

    public function salesRequestStorBarangSPO(Request $request, $konfirmasiAdmin)
    {
        for($i = 0; $i < sizeof($request->id_produk); $i++) {
                $history = HistoryRequestBarang::create(
                    [
                        'tanggal' => Carbon::now(),
                        'nama_sales' => auth()->user()->nama,
                        'nama_produk'=> $request->nama_produk[$i],
                        'terjual'=>(int) $request->jumlah_produk[$i],
                        'konfirmasi_admin' => $konfirmasiAdmin,
                        'keterangan' => 'sales request',
                        'stok_awal'=>0,
                        'sisa_stok'=>0,
                        
                    ]
                );
        }

        return $history;
    }

    public function getReqKonfirmasiStorBarang($id_user) {
        $data = DB::select("SELECT r.id_user, u.nama, r.id_produk, p.nama_produk, r.stok_awal, r.terjual, r.sisa_stok, r.konfirmasi 
                            FROM request_stor_barang r 
                            JOIN products p ON p.id_produk = r.id_produk 
                            JOIN users u ON r.id_user = u.id 
                            WHERE r.konfirmasi = 1 AND r.id_user = $id_user;");
        return $data;
    }

    public function konfirmasiAdminStorBarang($id_user){
        $dataKonfirmasi = $this->getReqKonfirmasiStorBarang($id_user);

        foreach ($dataKonfirmasi as $data) {
            $history = HistoryRequestBarang::create(
                [
                    'tanggal' => Carbon::now(),
                    'nama_sales' => $data->nama,
                    'nama_produk'=> $data->nama_produk,
                    'stok_awal' => $data->stok_awal,
                    'terjual'=>$data->terjual,
                    'sisa_stok'=>$data->sisa_stok,
                    'konfirmasi_admin' => 1,
                    'keterangan' => 'admin konfirmasi',
                ]
            );
        }

        return $history;
    }


    // HISTORY REQUEST STOR PENJUALAN
    public function salesRequestStorPenjualan(Request $request, $konfirmasiAdmin)
    {
        // dd($request->all());
        for($i = 0; $i < sizeof($request->id_produk); $i++) {
                $history = HistoryRequestPenjualan::create(
                    [
                        'tanggal' => Carbon::now(),
                        'nama_sales' => auth()->user()->nama,
                        'nama_produk'=> $request->nama_produk[$i],
                        'terjual'=>(int)$request->terjual[$i],
                        'total_harga'=>(int) $request->total_harga[$i],
                        'konfirmasi_admin' => $konfirmasiAdmin,
                        'keterangan' => 'sales request penjualan',
                    ]
                );
        }

        return $history;
    }

    

    // HISTORY REQUEST STOR PENJUALAN
    public function salesRequestStorPenjualanSPO(Request $request, $konfirmasiAdmin)
    {
        // dd($request->all());
        for($i = 0; $i < sizeof($request->id_produk); $i++) {
                $history = HistoryRequestPenjualan::create(
                    [
                        'tanggal' => Carbon::now(),
                        'nama_sales' => auth()->user()->nama,
                        'nama_produk'=> $request->nama_produk[$i],
                        'terjual'=>(int)$request->jumlah_produk[$i],
                        'total_harga'=>(int) $request->total_harga[$i],
                        'konfirmasi_admin' => $konfirmasiAdmin,
                        'keterangan' => 'sales request penjualan',
                    ]
                );
        }

        return $history;
    }

    public function getReqKonfirmasiStorPenjualan($id_user) {
        $data = DB::select("SELECT r.id_user, u.nama, r.id_produk, p.nama_produk, r.terjual, r.total_harga, r.konfirmasi 
                            FROM request_stor_barang r 
                            JOIN products p ON p.id_produk = r.id_produk 
                            JOIN users u ON r.id_user = u.id 
                            WHERE r.konfirmasi = 1 AND r.id_user = $id_user;");
        return $data;
    }

    public function konfirmasiAdminStorPenjualan($id_user){
        // dd($request->all());
        $dataKonfirmasi = $this->getReqKonfirmasiStorPenjualan($id_user);

        foreach ($dataKonfirmasi as $data) {
            $history = HistoryRequestPenjualan::create(
                [
                    'tanggal' => Carbon::now(),
                    'nama_sales' => $data->nama,
                    'nama_produk'=> $data->nama_produk,
                    'terjual'=>$data->terjual,
                    'total_harga'=>$data->total_harga,
                    'konfirmasi_admin' => 1,
                    'keterangan' => 'admin konfirmasi penjualan',
                ]
            );
        }

        return $history;
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
