<?php

namespace App\Http\Controllers;

use App\Models\Toko;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TokoController extends Controller
{
    public function collectToko(Request $request): Collection{
        $createCollection = collect($request);
        // dd($createCollection);

        $data = [
            "routing" => $createCollection->get('routing'),
            "id_kunjungan" => $createCollection->get('jenis_kunjungan'),
            "nama_toko" => $createCollection->get('namaToko'),
            "latitude" => $createCollection->get('latitude'),
            "longitude" => $createCollection->get('longitude'),
            "toko"=>$createCollection->get('toko')
        ];
        // dd($data);

        $newData = collect($data['id_kunjungan'])->map(function ($item, $index) use ($data) {
            return [
                'routing' => (int) $data['routing'],
                'toko' => $data['toko']?? "",
                'nama_toko' => $data['nama_toko'] ?? "",
                'id_kunjungan' => $item,
                'latitude' => $data['latitude'], 
                'longitude' => $data['longitude'], 
            ];
        });

        // dd($newData);
        return new Collection($newData);
    }

    public function getToko(Request $request): int {
        $datas = $this->collectToko($request);
        // dd($datas);
        $tokoId = $datas->pluck('toko')->first();
        // dd($tokoId);

        $toko = Toko::where('id_toko', $tokoId)
            ->value('id_toko');
        // dd($toko);
        return $toko;
    }

    public function createToko(Request $request):void{
        $datas = $this->collectToko($request);
        // dd($datas);
        $datas->map(function ($data) {
            $id_routing = $data['routing'];
            $lastMapping = Toko::where('id_routing', $id_routing)
                ->max('mapping');
            $mapping = $lastMapping ? $lastMapping + 1 : 1;
    
            Toko::insert([
                'id_routing' => $data['routing'],
                'id_kunjungan' => $data['id_kunjungan'],
                'nama_toko' => $data['nama_toko'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'mapping' => $mapping
            ]);
        });
    }

    public function getTokoIO(Request $request): int {
        $datas = $this->collectToko($request);
        // dd($datas);
        $routing = $datas->pluck('routing');
        // dd($routing);
        $toko = Toko::select('id_toko')
            ->where('id_routing', $routing)
            ->where('id_kunjungan', 'IO')
            ->orderBy('created_at', 'ASC')
            ->limit(1)
            ->value('id_toko');
        // dd($toko);
        return $toko;
    }
    // public function getTokoIO($req) {
    //     $toko = DB::select("SELECT id_toko FROM `toko`
    //                         WHERE id_routing = $req->routing
    //                         AND id_kunjungan = 'IO'
    //                         ORDER BY created_at DESC
    //                         LIMIT 1");

    //     return $toko;
    // }

    // public function getTokoAll($request){
    //     // dd($request);
    //     $datas = $this->collectToko($request);
    //     dd($datas);
    //     if ($datas->id_kunjungan == 'IO') {
    //         $this->createToko($request);
    //         $toko = $this->getTokoIO($request);
    //     } else {
    //         $toko = $this->getToko($request);
    //     }
    //     dd($toko);
    //     // $id_toko = $toko[0]->id_toko;
    //     return $toko;
    // }

    // public function createToko2($req) {
    //     $id_routing = $req->routing;
    //     // dd($id_routing);
    //     $lastMapping = Toko::where('id_routing', $id_routing)->max('mapping');
    //     // dd($lastMapping);
    //     $mapping = $lastMapping ? $lastMapping + 1 : 1;
    //     // dd($mapping);
    //      // dd($req->all());
    //     Toko::create(
    //         [
    //             'id_routing' => $req->routing,
    //             'id_kunjungan' => $req->jenis_kunjungan,
    //             'nama_toko' => $req->namaToko,
    //             'latitude' =>$req->latitude,
    //             'longitude' =>$req->longitude,
    //             'mapping' =>$mapping
    //         ]
    //     );
    // }

    // public function getToko2($req) {
    //     $toko = DB::select("SELECT id_toko FROM `toko`
    //                         WHERE id_toko = $req->toko
    //                         LIMIT 1");

    //     return $toko;
    // }
}
