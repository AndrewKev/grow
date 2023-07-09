<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use App\Models\Foto;
use Carbon\Carbon;

class FotoController extends Controller
{
    public function collectFoto(Request $request): Collection{
        $createCollection = collect($request);
        // dd($createCollection);
        $tanggal = Carbon::now()->format('Y-m-d');
        $validator = Validator::make($createCollection->all(), [
            'foto' => 'image'
        ]);
    
        if ($validator->fails()) {
            // Penanganan jika validasi gagal
        }
    
        // Lanjutkan dengan proses lainnya jika validasi berhasil
    
        $tanggal = Carbon::now()->format('Y-m-d');
        $fotoPath = $createCollection->get('foto')->store('public/fotoToko');
        $foto = Foto::create([
            'nama_foto' => $fotoPath,
            'id_user' => auth()->user()->id,
            'tanggal' => $tanggal
        ]);
        // dd($foto);
        return new Collection($foto->id);
        // return collect([$foto])->first()->id;
    }
}
