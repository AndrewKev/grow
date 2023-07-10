<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\CarryProduk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
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

    public function collectUpdateStok(Request $request): Collection
    {
        $createCollection = collect($request);
        // dd($createCollection);
        $data = [
            "idProduk" => $createCollection->get('id_produk'),
            "jumlah" => $createCollection->get('jumlah')
        ];
        // dd($data);
        $newData = collect($data['idProduk'])->map(function ($item, $index) use ($data) {
            return [
                'idProduk' => $item,
                'jumlah' => (int) $data['jumlah'][$index]
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

    public function updateStok(Request $request): void{
        $datas = $this->collectUpdateStok($request);
        // dd($datas);
        $id_user = auth()->user()->id;
        // dd($id_user);
        $tanggal = Carbon::now()->format('Y-m-d');
        // dd($tanggal);
        $barang = $this->getStokUser();
        // dd($barang);
        $data = [];
        // dd($data);

        $datas->map(function ($item, $key) use (&$data, $id_user, $tanggal, $barang) {
            $productId = $item['idProduk'];
            // dd($productId);
            $carryValue = $item['jumlah'];
            // dd($carryValue);

            $stokCarry = $this->getStokCarryProduk($productId, $id_user);
            // dd($stokCarry);
            $stokCarryValue = $stokCarry[0]->stok_sekarang;
            // dd($stokCarryValue);

            if ($carryValue > $stokCarryValue) {
                throw new Exception('Stok carry produk ' . $productId . ' kurang.');
            }

                foreach ($barang as $produk) {
                    if ($produk->id_produk === $productId) {
                        $produk->stok_sekarang -= $carryValue;
                        break;
                    }
                }
                // dd($produk);

                CarryProduk::where('id_produk', $productId)
                    ->where('id_user', $id_user)
                    ->whereBetween('tanggal_carry', ["$tanggal 00:00:00", "$tanggal 23:59:59"])
                    ->update(['stok_sekarang' => $produk->stok_sekarang]);
                
                // Tambahkan item ke dalam $data
                $data[$productId] = [
                    'produk' => $productId,
                    'carry' => $carryValue
                ];
        });
        // dd($data);
    }

    public function getStokUser() {
        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');
        $barang = CarryProduk::select('id_produk', 'stok_sekarang')
            ->where('id_user', $id_user)
            ->whereBetween('tanggal_carry', ["$tanggal 00:00:00", "$tanggal 23:59:59"])
            ->get();

        return $barang;
    }

    public function getStokCarryProduk($id_produk, $id_user){
        $query = CarryProduk::select('stok_sekarang')
            ->where('id_produk', $id_produk)
            ->where('id_user', $id_user)
            ->get();

        return $query;
    }

    // public function updateStok(Request $request): void
    // {
    //     $datas = $this->collectUpdateStok($request);
    //     dd($datas);
    //     $id_user = auth()->user()->id;
    //     $tanggal = Carbon::now()->format('Y-m-d');
    //     $barang = $this->getStokUser();
    //     $data = [];

    //     for($i=0; $i < count($request->id_produk); $i++){
    //         if($request->jumlah[$i] > '0'){
    //             $productId = $request->id_produk[$i];
    //             $carryValue = (int) $request->jumlah[$i];
    //             $stokCarry = $this->getStokCarryProduk($productId, $id_user);
    //             $stokCarryValue = $stokCarry[0]->stok_sekarang;
    //             // dd($productId);

    //             if($carryValue > $stokCarryValue){
    //                 throw new Exception('Stok carry produk '.$productId . ' kurang.');
    //             }

    //             $data[$productId]=[
    //                 'produk'=>$productId,
    //                 'carry'=>$carryValue
    //             ];
    //             // dd($data);
    //         }
    //     }
        
    //     foreach($data as $productId => $item){
    //         $carryValue = $item['carry'];

    //         foreach($barang as $produk){
    //             if($produk->id_produk === $productId){
    //                 $produk->stok_sekarang -= $carryValue;
    //                 break;
    //             }
    //         }

    //         DB::update("UPDATE carry_produk
    //                     SET stok_sekarang  = $produk->stok_sekarang
    //                     WHERE id_produk = '$productId'
    //                     AND id_user = $id_user
    //                     AND tanggal_carry BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'"); 
    //     }

    //     $barang = $this->getStokUser();

    //     foreach($data as $productId => $item){
    //         $carryValue = $item['carry'];

    //         foreach($barang as $produk){
    //             if($produk->id_produk === $productId){
    //                 $produk->stok_sekarang -= $carryValue;
    //                 break;
    //             }
    //         }
    //     }

    //     DB::update("UPDATE carry_produk
    //                 SET stok_sekarang = $produk->stok_sekarang
    //                 WHERE id_produk = '$productId'
    //                 AND id_user = $id_user
    //                 AND tanggal_carry BETWEEN '$tanggal 00:00:00' AND '$tanggal 00:00:00'");
        
    // }
}
