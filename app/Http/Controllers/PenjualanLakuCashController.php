<?php

namespace App\Http\Controllers;
use App\Models\Distrik;
use App\Models\RequestBarang;
use App\Models\Penjualan;
use App\Models\Keterangan;
use App\Models\Toko;
use Carbon\Carbon;
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
        // dd($request->all());
        $emp = "";
        foreach($request->emp as $e) {
            $emp .= $e . '; ';
        }
        // dd($emp);

        Keterangan::create(
            [
                'keterangan' =>$request->keterangan,
                'id_user' => auth()->user()->id,
                'tanggal' =>Carbon::now()->format('Y-m-d')
            ]
        );
        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');
        $keterangan = DB::select("SELECT * FROM `keterangan` 
                       WHERE id_user = '$id_user' 
                       AND tanggal = '$tanggal'
                       ORDER BY created_at DESC");
        
        if($request->jenis_kunjungan == 'IO') {
            $coba = Toko::create(
                [
                    'id_routing' => $request->routing,
                    'id_kunjungan' => $request->jenis_kunjungan,
                    'nama_toko' => $request->namaToko
                ]
            );
        }
        
        // dd($coba);

        // $id_routing = DB::select("SELECT * FROM `routing` 
        //                         WHERE id_routing = '$request->routing'");
        // $id_kunjungan = DB::select("SELECT * FROM `jenis_kunjungan` 
        //                         WHERE id_kunjungan = '$request->jenis_kunjungan'");
        $toko = DB::select("SELECT * FROM `toko` 
                            WHERE id_routing = $request->routing
                            AND id_kunjungan = '$request->jenis_kunjungan'
                            ORDER BY created_at DESC 
                            LIMIT 1");
        // dd($toko);
        $id_toko = $toko[0]->id_toko;
        for($i = 0; $i < 10; $i++) {
            if($request->produk[$i] != '0') {
                Penjualan::create(
                    [
                        'id_user' => auth()->user()->id,
                        'id_distrik' => $request->id_distrik,
                        'id_routing' => $request->routing,
                        'id_toko' => $id_toko,
                        'id_kunjungan' => $request->jenis_kunjungan,
                        'id_produk' => $request->id_produk[$i],
                        'jumlah_produk' => (int) $request->produk[$i],
                        'id_keterangan' => $keterangan[0]->id_keterangan,
                        'emp' => $request->$emp,
                        // 'id_foto' => $request->id_foto[$i],
                    ]
                );
            }
        }

        return redirect('/user/penjualan_laku_cash');
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
