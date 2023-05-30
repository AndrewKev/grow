<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoryRequest;
use Carbon\Carbon;


class HistoryRequestSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, $konfirmasiAdmin, $konfirmasiSales)
    {
        for($i = 0; $i < sizeof($request->id_produk); $i++) {
            if($request->produk[$i] != '0') {
                $history = HistoryRequest::create(
                    [
                        'tanggal_request' => Carbon::now(),
                        'nama_sales' => auth()->user()->nama,
                        'nama_produk'=> $request->nama_produk[$i],
                        'jumlah' => (int) $request->produk[$i],
                        'konfirmasi_admin' => $konfirmasiAdmin,
                        'konfirmasi_sales' => $konfirmasiSales,
                    ]
                );
            }
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
