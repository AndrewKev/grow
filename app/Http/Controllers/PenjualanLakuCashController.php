<?php

namespace App\Http\Controllers;
use App\Models\Distrik;
use App\Models\RequestBarang;
use App\Models\Penjualan;
use App\Models\Keterangan;
use App\Models\Toko;
use App\Models\Foto;
use App\Models\CarryProduk;
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
        // dd($this->getRoutingUser($id_user));
        // $distrik = Distrik::where('id_user', Auth::id())->first();
        $distrik = DB::select("SELECT * FROM distrik WHERE id_user = $id_user");
        $tanggal = Carbon::now()->format('Y-m-d');
        
        $routing = $this->getRoutingUser($id_user);
        // dd($routing);
        
        // dd($distrik);
        $storToday = $this->isTodayStorProduk(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $carryToday = $this->isTodayCarryProduk(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $penjualanLk = DB::select("SELECT DISTINCT toko.id_toko, toko.nama_toko, routing.nama_routing, keterangan, p.emp, p.latitude, p.longitude, p.created_at, foto.nama_foto 
                                    FROM penjualan_laku_cash AS p 
                                    JOIN toko ON toko.id_toko = p.id_toko 
                                    JOIN routing ON routing.id_routing = p.id_routing 
                                    JOIN foto ON foto.id_foto = p.id_foto
                                    JOIN keterangan ON keterangan.id_keterangan = p.id_keterangan
                                    WHERE p.id_user = '$id_user'
                                    AND p.created_at BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
    
        // dd($penjualanLk);
        // return view('pages.karyawan.penjualanLakuCash', compact('distrik', 'penjualanLk', 'routing'));
        return view('pages.karyawan.penjualanLakuCash', compact('distrik', 'penjualanLk', 'routing', 'storToday', 'carryToday'));
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
        $query = DB::select("SELECT DISTINCT d.id_distrik, r.id_routing, r.nama_routing, t.id_toko, t.nama_toko
                FROM distrik d 
                JOIN routing r ON r.id_distrik = d.id_distrik 
                JOIN toko t ON t.id_routing = r.id_routing 
                WHERE d.id_user = $id_user AND r.id_routing = $id_routing");

        return response()->json($query);
        // return $query;
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
    public function store($request)
    {
        /** TEST COLLECTION */
        // $collection = collect($request);
        // $att = collect();
        // $jumlah = collect($collection->get('produk'));
        // $idProduk = collect($collection->get('id_produk'));
        
        // for ($i=0; $i < $jumlah->count(); $i++) {
        //     if($jumlah->get($i) != '0') {
        //         $att->push(['id_produk' => $idProduk->get($i), 'jumlah'=> $jumlah->get($i)]);
        //     } 
        // }
        
        // dd($request->all());

        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');
    
        $emp = "";
        if (!empty($request->emp)) {
            foreach ($request->emp as $e) {
                $emp .= $e . '; ';
            }
        }
        
        // UPDATE STOK
        $barang = $this->getStokUser();
        $data = [];
        for ($i = 0; $i < 10; $i++) {
            if ($request->produk[$i] != '0') {
                $productId = $request->id_produk[$i];
                $carryValue = (int) $request->produk[$i];

                $data[$productId] = [
                    'produk' => $productId,
                    'carry' => $carryValue
                ];
            }
        }

        // Mengurangi stok berdasarkan carry yang diinputkan
        foreach ($data as $productId => $item) {
            $carryValue = $item['carry'];

            foreach ($barang as $produk) {
                if ($produk->id_produk === $productId) {
                    $produk->stok_sekarang -= $carryValue;
                    break;
                }
            }
            // Lakukan update pada tabel CarryProduk
            DB::update("UPDATE carry_produk 
                        SET stok_sekarang = $produk->stok_sekarang 
                        WHERE id_produk = '$productId'
                        AND id_user = $id_user
                        AND tanggal_carry BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
            // CarryProduk::where('id_produk', $productId)->update(['stok_sekarang' => $produk->stok_sekarang]);
        }

        // FOTO
        $tanggal = Carbon::now()->format('Y-m-d');
        $validatedData = $request->validate([
            'foto' => 'image'
        ]);
        // dd($validatedData);
        $fotoPath = $request->file('foto')->store('public/fotoToko'); // Simpan file gambar ke direktori penyimpanan
        Foto::create([
            'nama_foto' => $fotoPath,
            'id_user' =>auth()->user()->id,
            'tanggal' =>$tanggal
        ]);
        $id_user = auth()->user()->id;
        $foto = DB::select("SELECT * FROM `foto` 
                       WHERE id_user = '$id_user' 
                       AND tanggal = '$tanggal'
                       ORDER BY created_at DESC");
        // dd($foto);
        // KETERANGAN
        if($request->get('keterangan') != null) {
            $this->createKeterangan($request->get('keterangan'));
        }

        // $id_user = auth()->user()->id;
        // $tanggal = Carbon::now()->format('Y-m-d');
        $keterangan = DB::select("SELECT * FROM `keterangan` 
                       WHERE id_user = '$id_user' 
                       AND tanggal = '$tanggal'
                       ORDER BY created_at DESC");
        
        if($request->jenis_kunjungan == 'IO') {
            $this->createToko($request);
            
            $toko = $this->getTokoIO($request);
        } else {
            $toko = $this->getToko($request);
        }
                            
        $id_toko = $toko[0]->id_toko;
        for($i = 0; $i < 10; $i++) {
            if($request->produk[$i] != '0') {
                if($request->get('keterangan') != null) {
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
                            'longitude' => $request->longitude,
                            'id_foto' => $foto[0]->id_foto,
    
                        ]
                    );
                }
            }            
        }
        // dd($request->id_produk);
        return redirect('/user/penjualan_laku_cash');
    }

    // public function createFoto($foto){
    //     dd($foto);
    //     $validatedData = $foto->validate([
    //         'foto' => 'image'
    //     ]);
    
    //     $fotoPath = $foto->file('foto')->store('public/fotoToko'); // Simpan file gambar ke direktori penyimpanan
    //     Foto::create([
    //         'nama_foto' => $fotoPath,
    //         'id_user' =>auth()->user()->id,
    //     ]);
    // }

    public function createKeterangan($keterangan) {
        Keterangan::create(
            [
                'keterangan' =>$keterangan,
                'id_user' => auth()->user()->id,
                'tanggal' =>Carbon::now()->format('Y-m-d')
            ]
        );
    }

    public function createToko($req) {
        Toko::create(
            [
                'id_routing' => $req->routing,
                'id_kunjungan' => $req->jenis_kunjungan,
                'nama_toko' => $req->namaToko
            ]
        );
    }

    public function getToko($req) {
        $toko = DB::select("SELECT * FROM `toko` 
                            WHERE id_toko = $req->toko
                            LIMIT 1");
        // $toko = DB::select("SELECT * FROm toko WHERE id_toko = ", [1])
        
        return $toko;
    }

    public function getTokoIO($req) {
        $toko = DB::select("SELECT * FROM `toko` 
                            WHERE id_routing = $req->routing
                            AND id_kunjungan = 'IO'
                            ORDER BY created_at DESC 
                            LIMIT 1");
        
        return $toko;
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
