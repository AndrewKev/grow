<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GudangKecilController extends Controller
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
    public function getStok($id_produk) {
        $stok = DB::select("SELECT id_produk, stok FROM gudang_kecil WHERE id_produk = '$id_produk'");

        return $stok[0]->stok;
    }
    public function update($id_produk, $jumlahBarang)
    {
        DB::update("UPDATE gudang_kecil SET stok = $jumlahBarang 
                    WHERE id_produk = '$id_produk';");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
