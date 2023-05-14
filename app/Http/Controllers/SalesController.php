<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.karyawan.dashboard');
    }

    public function absensiPage() {
        // dd(auth()->user()->id);
        // dd(Absensi::where('id_user', auth()->user()->id)->get());
        // $listAbsenUser = DB::select('select * from absensi where id_user = '.auth()->user()->id);
        $username = auth()->user()->username;
        $listAbsenUser = DB::select("SELECT u.nama, u.no_telp, a.waktu_masuk, a.waktu_keluar, a.keterangan, a.latitude, a.longitude
                                     FROM absensi as a
                                     JOIN users as u ON a.id_user = u.id
                                     WHERE u.username = '$username'
                                     ORDER BY a.waktu_masuk DESC");
        // dd($this->getLastAbsen());
        return view('pages.karyawan.absensi', compact('listAbsenUser'));
    }

    public function postAbsensi(Request $request) {
        Absensi::create(
            [
                'id_user' => auth()->user()->id,
                'keterangan' => $request->keterangan,
                'waktu_masuk' => Carbon::now(),
            ]
        );

        return redirect('/user/absensi');
    }

    public function absensiKeluar() {
        $timeNow = Carbon::now();
        $lastIdAbsen = $this->getLastAbsen();
        $target = DB::update("UPDATE `absensi` 
                              SET `waktu_keluar` = '$timeNow' 
                              WHERE `absensi`.`id_absensi` = $lastIdAbsen;");
        
        return redirect('/user/absensi');
    }

    public function getLastAbsen() {
        $username = auth()->user()->username;
        $listAbsen = DB::select("SELECT a.id_absensi, a.id_user, a.waktu_keluar
                                 FROM absensi as a
                                 JOIN users as u ON a.id_user = u.id
                                 WHERE u.username = '$username'");
        
        $last = $listAbsen[sizeof($listAbsen)-1];                   
        return $last->id_absensi;
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
