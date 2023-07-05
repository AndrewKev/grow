<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Events\UserLoggedOut;

use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(auth('sales')->user());
        return view('pages.karyawan.absensi');
    }

    /**
     * Absensi SPO.
     */
    public function indexSpo($finishStor, $isAbsensi, $listAbsenUser)
    {
        return view('pages.spo.absensi', compact('finishStor', 'isAbsensi', 'listAbsenUser'));
    }

    /**
     * Logout Otomatis.
     */
    public function logout()
    {
        event(new UserLoggedOut(auth()->user()->id));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $id_user = auth()->user()->id;
        $lastAbsensi = DB::select("SELECT * FROM absensi 
                                    WHERE id_user = $id_user 
                                    AND waktu_keluar IS NULL LIMIT 1;");

        // if (!empty($lastAbsensi)) {
        //     $absensiId = $lastAbsensi[0]->id_user;
        //     $timeNow = Carbon::now();

        //     DB::update("UPDATE absensi SET waktu_keluar = '$timeNow' WHERE id_user = $absensiId");
        // }

        if (!empty($lastAbsensi)) {
            $absensiId = $lastAbsensi[0]->id_user;
            $timeNow = date('Y-m-d H:i:s'); // Waktu saat ini dalam format Y-m-d H:i:s
    
            // Periksa apakah waktu keluar belum mencapai tengah malam
            $query = "UPDATE absensi SET waktu_keluar = CONCAT(DATE(waktu_masuk), ' 23:59:59') WHERE id_user = $absensiId AND waktu_keluar IS NULL";
            DB::update($query);
        }

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

        if(auth()->user()->level == 0) {
            return redirect('/user/absensi');
        } else {
            return redirect('/spo/absensi');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
