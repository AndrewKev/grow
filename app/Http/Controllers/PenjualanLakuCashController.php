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
        
        $penjualanLk = DB::select("SELECT DISTINCT toko.id_toko, toko.nama_toko, routing.nama_routing, keterangan, p.emp, p.latitude, p.longitude, p.created_at 
                                    FROM penjualan_laku_cash AS p 
                                    JOIN toko ON toko.id_toko = p.id_toko 
                                    JOIN routing ON routing.id_routing = p.id_routing 
                                    JOIN keterangan ON keterangan.id_keterangan = p.id_keterangan
                                    WHERE p.id_user = '$id_user'");
    
        // dd($penjualanLk);
        return view('pages.karyawan.penjualanLakuCash', compact('distrik', 'penjualanLk'));
    }

    public function detailPenjualan($id_toko){
        // $id_user = auth()->user()->id;
        // $data = DB::select("SELECT * FROM penjualan_laku_cash
        //                     WHERE id_toko = $id_toko");
        $data = DB::select("SELECT  p.*, products.harga_toko, products.nama_produk, toko.id_toko
        FROM penjualan_laku_cash AS p
        JOIN toko ON toko.id_toko = p.id_toko
        JOIN products ON products.id_produk = p.id_produk
        WHERE p.id_toko = $id_toko;");
        // dd($data);

        return view('pages.karyawan.tampilPenjualanLakuCash', compact('data'));
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
                        'emp' => $emp,
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude
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
