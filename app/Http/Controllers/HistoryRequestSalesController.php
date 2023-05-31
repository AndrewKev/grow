<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoryRequest;
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
