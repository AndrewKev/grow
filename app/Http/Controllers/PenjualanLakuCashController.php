<?php

namespace App\Http\Controllers;
use App\Models\Distrik;
use App\Models\RequestBarang;
use App\Models\Penjualan;
use App\Models\Keterangan;
use App\Models\Toko;
use App\Models\Foto;
use App\Models\Emp;
use App\Models\CarryProduk;
use Carbon\Carbon;
use App\Http\Controllers\EmpController;
use App\Http\Controllers\FotoController;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use Illuminate\Contracts\View\View;
use Illuminate\Routing\Redirector;

class PenjualanLakuCashController extends Controller
{
    private $empController;
    private $fotoController;
    private $tokoController;

    public function __construct(EmpController $empController, FotoController $fotoController, TokoController $tokoController)
    {
        $this->empController = $empController;
        $this->fotoController = $fotoController;
        $this->tokoController = $tokoController;

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $id_user = auth()->user()->id;
        $distrik = DB::select("SELECT * FROM distrik WHERE id_user = $id_user");
        $tanggal = Carbon::now()->format('Y-m-d');

        $routing = $this->getRoutingUser($id_user);
        $storToday = $this->isTodayStorProduk(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $carryToday = $this->isTodayCarryProduk(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $totalCarryProduk = app('App\Http\Controllers\SalesController')->getCarriedStok();
        // $totalCarryProduk = $this->totalCarryProduk(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $penjualanLk = DB::select("SELECT DISTINCT toko.id_toko, toko.nama_toko, routing.nama_routing, keterangan, p.emp, p.mapping, p.latitude, p.longitude, p.created_at, foto.nama_foto
                                    FROM penjualan_laku_cash AS p
                                    JOIN toko ON toko.id_toko = p.id_toko
                                    JOIN routing ON routing.id_routing = p.id_routing
                                    JOIN foto ON foto.id_foto = p.id_foto
                                    JOIN keterangan ON keterangan.id_keterangan = p.id_keterangan
                                    WHERE p.id_user = '$id_user'
                                    AND p.created_at BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");

        // dd($penjualanLk);
        // return view('pages.karyawan.penjualanLakuCash', compact('distrik', 'penjualanLk', 'routing'));
        return view('pages.karyawan.penjualanLakuCash', compact('distrik', 'penjualanLk', 'routing', 'storToday', 'carryToday', 'totalCarryProduk'));
    }
    public function isTodayStorProduk($id_user, $tanggal) {
        $cek = DB::select("SELECT * FROM `stor_produk`
                           WHERE id_user = '$id_user'
                           AND tanggal_stor_barang BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    public function isTodayCarryProduk($id_user, $tanggal) {
        $cek = DB::select("SELECT * FROM `carry_produk`
                           WHERE id_user = '$id_user'
                           AND tanggal_carry BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    public function totalCarryProduk($id_user, $tanggal) {
        $cek = DB::select("SELECT *
                            FROM `carry_produk` as c
                            JOIN products AS p ON p.id_produk = c.id_produk
                            WHERE id_user = '$id_user'
                            AND tanggal_carry BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");

        return $cek;
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

    public function getStokUser() {
        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');
        $barang = DB::select("SELECT id_produk, stok_sekarang
        FROM carry_produk
        WHERE id_user = '$id_user' AND tanggal_carry BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59';");

        return $barang;
    }

    public function isAbsenMasuk($id_user, $tanggal) { // cek apakah user sudah melakukan request ke admin
        $tanggal = Carbon::now()->format('Y-m-d');
        $cek = DB::select("SELECT * FROM `absensi`
                           WHERE id_user = '$id_user'
                           AND waktu_masuk BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }


    public function stokJalanPage() {
        $barang = $this->getStokUser();
        $req = $this->isRequest(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $konfirmasi = $this->isKonfirmasi(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $barangKonfirmasi = $this->getBarangKonfirmasi();
        $isCarry = $this->isCarry();

        return view('pages.karyawan.stokjalan', compact('barang', 'req', 'konfirmasi', 'barangKonfirmasi', 'isCarry'));
    }

    public function getRoutingUser($id_user) {
        $query = DB::select("SELECT DISTINCT d.id_distrik, r.id_routing, r.nama_routing
                            FROM distrik d
                            JOIN routing r ON r.id_distrik = d.id_distrik
                            WHERE d.id_user = $id_user");

        // return response()->json($query);
        return $query;
    }

    public function getTokoDariRouting($id_routing) {
        $id_user = auth()->user()->id;
        $query = DB::select("SELECT DISTINCT d.id_distrik, r.id_routing, r.nama_routing, t.mapping, t.id_toko, t.nama_toko
                FROM distrik d
                JOIN routing r ON r.id_distrik = d.id_distrik
                JOIN toko t ON t.id_routing = r.id_routing
                WHERE d.id_user = $id_user AND r.id_routing = $id_routing");

        return response()->json($query);
        // return $query;
    }

    public function getStokCarryProduk($id_produk, $id_user){
        $query = DB::select("SELECT stok_sekarang
                            FROM carry_produk
                            WHERE id_produk = '$id_produk' AND id_user = $id_user");
        return $query;
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
    // public function store($request)
    // {
    //     /** TEST COLLECTION */
    //     // $collection = collect($request);
    //     // $att = collect();
    //     // $jumlah = collect($collection->get('produk'));
    //     // $idProduk = collect($collection->get('id_produk'));

    //     // for ($i=0; $i < $jumlah->count(); $i++) {
    //     //     if($jumlah->get($i) != '0') {
    //     //         $att->push(['id_produk' => $idProduk->get($i), 'jumlah'=> $jumlah->get($i)]);
    //     //     }
    //     // }

    //     // dd($request->all());

    //     $id_user = auth()->user()->id;
    //     $tanggal = Carbon::now()->format('Y-m-d');
    //     $emp = "";
    //     // $jumlahEmp = [];
    //     // dd($request->jumlahEmp);
    //     if (!empty($request->emp)) {
    //         foreach ($request->emp as $index => $e) {
    //             $em = $request->jumlahEmp[$index];
    //                 $emp .= $e . '('.$em.')'.'; ';
    //         // Ambil data 'emp' dari tabel berdasarkan kolom 'jenis'
    //         $empData = Emp::where('jenis', $e)->first();
    //         // dd($empData);
    //         // Lakukan pengurangan pada kolom 'jumlah'
    //         $updatedJumlah = $empData->jumlah - $em;

    //         // Perbarui (update) nilai kolom 'jumlah' dalam tabel 'emp'
    //         $empData->update(['jumlah' => $updatedJumlah]);
    //         }
    //         // dd($emp);
    //     }
    //     // $stokEmp = Emp::where('jenis')



    //     // UPDATE STOK
    //     $barang = $this->getStokUser();
    //     $data = [];
    //     for ($i = 0; $i < count($request->id_produk); $i++) {
    //         if ($request->jumlah[$i] > '0') {
    //             $productId = $request->id_produk[$i];
    //             $carryValue = (int) $request->jumlah[$i];
    //             $stokCarry = $this->getStokCarryProduk($productId, $id_user);
    //             $stokCarryValue = $stokCarry[0]->stok_sekarang;
    //             // dd($stokCarryValue);

    //             if ($carryValue > $stokCarryValue) {
    //                 // Stok carry produk yang dibawa kurang, tampilkan pesan kesalahan
    //                 return redirect()->back()->with('error', 'Stok carry produk ' . $productId . ' kurang.');
    //             }

    //             $data[$productId] = [
    //                 'produk' => $productId,
    //                 'carry' => $carryValue
    //             ];
    //         }
    //     }

    //     // Mengurangi stok berdasarkan carry yang diinputkan
    //     foreach ($data as $productId => $item) {
    //         $carryValue = $item['carry'];

    //         foreach ($barang as $produk) {
    //             if ($produk->id_produk === $productId) {
    //                 $produk->stok_sekarang -= $carryValue;
    //                 break;
    //             }
    //         }
    //         // Lakukan update pada tabel CarryProduk
    //         DB::update("UPDATE carry_produk
    //                     SET stok_sekarang = $produk->stok_sekarang
    //                     WHERE id_produk = '$productId'
    //                     AND id_user = $id_user
    //                     AND tanggal_carry BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
    //         // CarryProduk::where('id_produk', $productId)->update(['stok_sekarang' => $produk->stok_sekarang]);
    //     }

    //     // FOTO
    //     $tanggal = Carbon::now()->format('Y-m-d');
    //     $validatedData = $request->validate([
    //         'foto' => 'image'
    //     ]);
    //     // dd($validatedData);
    //     $fotoPath = $request->file('foto')->store('public/fotoToko'); // Simpan file gambar ke direktori penyimpanan
    //     Foto::create([
    //         'nama_foto' => $fotoPath,
    //         'id_user' =>auth()->user()->id,
    //         'tanggal' =>$tanggal
    //     ]);
    //     $id_user = auth()->user()->id;
    //     $foto = DB::select("SELECT * FROM `foto`
    //                    WHERE id_user = '$id_user'
    //                    AND tanggal = '$tanggal'
    //                    ORDER BY created_at DESC");
    //     // dd($foto);
    //     // KETERANGAN
    //     if($request->get('keterangan') != null) {
    //         $this->createKeterangan($request->get('keterangan'));
    //     }

    //     // $id_user = auth()->user()->id;
    //     // $tanggal = Carbon::now()->format('Y-m-d');
    //     $keterangan = DB::select("SELECT * FROM `keterangan`
    //                    WHERE id_user = '$id_user'
    //                    AND tanggal = '$tanggal'
    //                    ORDER BY created_at DESC");

    //     if($request->jenis_kunjungan == 'IO') {
    //         $this->createToko($request);

    //         $toko = $this->getTokoIO($request);
    //     } else {
    //         $toko = $this->getToko($request);
    //     }

    //     $id_toko = $toko[0]->id_toko;
    //     for ($i = 0; $i < count($request->id_produk); $i++) {
    //         if ($request->jumlah[$i] >= '0') {
    //             if($request->get('keterangan') != null) {
    //                 Penjualan::create(
    //                     [
    //                         'id_user' => auth()->user()->id,
    //                         'id_distrik' => $request->id_distrik,
    //                         'id_routing' => $request->routing,
    //                         'id_toko' => $id_toko,
    //                         'id_kunjungan' => $request->jenis_kunjungan,
    //                         'id_produk' => $request->id_produk[$i],
    //                         'jumlah_produk' => (int) $request->jumlah[$i],
    //                         'mapping'=>$request->toko_mapping,
    //                         'id_keterangan' => $keterangan[0]->id_keterangan,
    //                         'emp' => $emp,
    //                         'latitude' => $request->latitude,
    //                         'longitude' => $request->longitude,
    //                         'id_foto' => $foto[0]->id_foto,

    //                     ]
    //                 );
    //             }
    //         }
    //     }
    //     // dd($request->id_produk);
    //     return redirect('/user/penjualan_laku_cash');
    // }

    public function store($request){
        // $this->updateEmpData($request);
        $this->createPenjualan($request);
        $this->updateStokCarry($request);
        return redirect('/user/penjualan_laku_cash');
    }

    public function updateEmpData($request){
        // dd($request->all());
        $requestToCollection = collect($request);
        // dd($requestToCollection);
        $emp = (!empty($requestToCollection->has('emp'))) ? $this->empController->proccessEmp($request) : "";
        // dd($emp);
        return($emp);
    }

    public function uploadFoto($request){
        $requestToCollection = collect($request);
        // dd($requestToCollection);
        $uploadFoto = (!empty($requestToCollection->has('foto'))) ? $this->fotoController->collectFoto($request) : "";
        // dd($uploadFoto);
        return($uploadFoto);
        // dd($requestToCollection);
    }

    public function updateStokCarry($request){
        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');
        $barang = $this->getStokUser();
        $data = [];

        for($i=0; $i < count($request->id_produk); $i++){
            if($request->jumlah[$i] > '0'){
                $productId = $request->id_produk[$i];
                $carryValue = (int) $request->jumlah[$i];
                $stokCarry = $this->getStokCarryProduk($productId, $id_user);
                $stokCarryValue = $stokCarry[0]->stok_sekarang;
                // dd($productId);

                if($carryValue > $stokCarryValue){
                    return redirect()->back()->with('error', 'Stok carry produk '.$productId . ' kurang.');
                }

                $data[$productId]=[
                    'produk'=>$productId,
                    'carry'=>$carryValue
                ];
                // dd($data);
            }
        }
        
        foreach($data as $productId => $item){
            $carryValue = $item['carry'];

            foreach($barang as $produk){
                if($produk->id_produk === $productId){
                    $produk->stok_sekarang -= $carryValue;
                    break;
                }
            }

            DB::update("UPDATE carry_produk
                        SET stok_sekarang  = $produk->stok_sekarang
                        WHERE id_produk = '$productId'
                        AND id_user = $id_user
                        AND tanggal_carry BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'"); 
        }
        $barang = $this->getStokUser();

        foreach($data as $productId => $item){
            $carryValue = $item['carry'];

            foreach($barang as $produk){
                if($produk->id_produk === $productId){
                    $produk->stok_sekarang -= $carryValue;
                    break;
                }
            }
        }

        DB::update("UPDATE carry_produk
                    SET stok_sekarang = $produk->stok_sekarang
                    WHERE id_produk = '$productId'
                    AND id_user = $id_user
                    AND tanggal_carry BETWEEN '$tanggal 00:00:00' AND '$tanggal 00:00:00'");
    }

    // public function updateStokBarang($request){
    //     dd($request->all());
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


    public function createKeterangan($keterangan) {
        Keterangan::create(
            [
                'keterangan' =>$keterangan,
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
        // dd($keterangan);
        return $keterangan[0]->id_keterangan;
    }

    public function getToko($request){
        $requestToCollection = collect($request);
        // dd($requestToCollection);
        if ($requestToCollection->get('jenis_kunjungan') == 'IO') {
            // dd("coba awal");
            $this->tokoController->createToko($request);
            // dd("coba");
            $getToko = $this->tokoController->getTokoIO($request);
            // dd($getToko);
        } else {
            $getToko = (!empty($requestToCollection->has('toko'))) ? $this->tokoController->getToko($request) : "";
            // dd($getToko);
        }
        // $getToko = (!empty($requestToCollection->has('toko'))) ? $this->tokoController->getTokoAll($request) : "";
        // $getToko = $this->tokoController->getTokoAll($request);
        // dd($getToko);
        return($getToko);
        // dd($requestToCollection);
    }

    private function createPenjualan($request){
        $emp = $this->updateEmpData($request);
        $id_foto = $this->uploadFoto($request)->first();
        $keterangan = $this->createKeterangan($request->get('keterangan'));
        $id_toko = $this->getToko($request);
        for ($i = 0; $i < count($request->id_produk); $i++) {
            if ($request->jumlah[$i] >= '0') {
                if ($request->get('keterangan') != null) {
                    Penjualan::create([
                        'id_user' => auth()->user()->id,
                        'id_distrik' => $request->id_distrik,
                        'id_routing' => $request->routing,
                        'id_toko' => $id_toko,
                        'id_kunjungan' => $request->jenis_kunjungan,
                        'id_produk' => $request->id_produk[$i],
                        'jumlah_produk' => (int) $request->jumlah[$i],
                        'mapping' => $request->toko_mapping,
                        'id_foto' => $id_foto,
                        'id_keterangan' => $keterangan,
                        'emp' => $emp,
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now()
                        
                    ]);
                }
            }
        }
    }

    // public function createToko($req) {
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

    // public function getTokoIO($req) {
    //     $toko = DB::select("SELECT * FROM `toko`
    //                         WHERE id_routing = $req->routing
    //                         AND id_kunjungan = 'IO'
    //                         ORDER BY created_at DESC
    //                         LIMIT 1");

    //     return $toko;
    // }

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
