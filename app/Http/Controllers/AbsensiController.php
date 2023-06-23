<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
