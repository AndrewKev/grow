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
        // return view('pages.admin2.dashboard');
    }
    


    /**
     * Admin 2
     */
    public function admin2Page() {
        return view('pages.admin2.dashboard');
    }

    public function reqSalesPage() {
        return view('pages.admin2.request');
    }

    public function konfirmasiReq() {
        dd($this->cekBarang(5, 'B20'));
        for($i = 0; $i < 10; $i++) {
            if($this->cekBarangDibawa($request->id_produk[$i], Carbon::now()->format('Y-m-d')) == 0) {
                // dd($request->all());
                if($request->produk[$i] != '0') {
                    $this->insertBarang($request->id_produk[$i], (int)$request->produk[$i]);
                    $stokSaatIni = app('App\Http\Controllers\GudangKecilController')->getStok($request->id_produk[$i]);
                    app('App\Http\Controllers\GudangKecilController')->update($request->id_produk[$i], $stokSaatIni - (int)$request->produk[$i]);
                }
            } else {
                if($request->produk[$i] != '0') {
                    $this->updateBarang($request->id_produk[$i], (int)$request->produk[$i] + $this->getStokUser()[$i]->stok_dibawa);
                    $stokSaatIni = app('App\Http\Controllers\GudangKecilController')->getStok($request->id_produk[$i]);
                    app('App\Http\Controllers\GudangKecilController')->update($request->id_produk[$i], $stokSaatIni - (int)$request->produk[$i]);
                }
            }
        }
    }

    public function cekBarang($id_user, $id_produk) {
        $tanggal = Carbon::now()->format('Y-m-d');
        $barang = DB::select("SELECT * FROM `request_sales` 
        WHERE id_user = '$id_user' 
        AND id_produk = '$id_produk'
        AND tanggal_request = '$tanggal';");

        return sizeof($barang);
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
