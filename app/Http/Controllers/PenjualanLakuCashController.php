<?php

namespace App\Http\Controllers;
use App\Models\Distrik;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenjualanLakuCashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $id_user = auth()->user()->id;
        // dd($id_user);
        // $distrik = Distrik::where('id_user', Auth::id())->first();
        $distrik = DB::select("SELECT * FROM distrik WHERE id_user = $id_user");
        // dd($distrik);
        $penjualanLk = DB::select("SELECT * FROM penjualan_laku_cash WHERE id_user = $id_user");
        // dd($penjualanLk);
        $routing = DB::select("SELECT * FROM routing JOIN distrik ON distrik.id_distrik = routing.id_distrik WHERE id_user = $id_user");
        // dd($routing);
        // Memastikan $routing bukan array kosong
        if (!empty($routing)) {
            $id_routing = $routing[0]->id_routing;
            $nama_toko = DB::select("SELECT * FROM toko JOIN routing ON routing.id_routing = toko.id_routing JOIN distrik ON distrik.id_distrik = routing.id_distrik WHERE toko.id_routing = $id_routing AND distrik.id_user = $id_user");
        } else {
            //jika $routing kosong
            $nama_toko = [];
        }
        // dd($nama_toko);
        return view('pages.karyawan.penjualanLakuCash', compact('distrik', 'penjualanLk', 'routing', 'nama_toko'));
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
        dd($request->all());
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
