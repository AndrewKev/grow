<?php

namespace App\Http\Controllers;

use App\Models\RequestBarang;
use App\Models\CarryProduk;
use App\Models\TokoSPO;
use App\Models\Emp;
use App\Models\Keterangan;
use App\Models\PenjualanSPO;
use App\Models\Foto;
use App\Models\StorProduk;
use App\Models\RequestStorBarang;
use App\Models\RincianUang;
use App\Models\GudangKecil;
use App\Http\Controllers\SalesController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class SPOController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.spo.dashboard');
    }

    /**
     * Menampilkan halaman absensi SPO.
     */
    public function pageAbsensiSPO() {
        $username = auth()->user()->username;
        $finishStor = $this->isFinishStor(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $isAbsensi = $this->isAbsensi(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $listAbsenUser = DB::select("SELECT u.nama, u.no_telp, a.waktu_masuk, a.waktu_keluar, a.keterangan, a.latitude, a.longitude, a.foto
                                     FROM absensi as a
                                     JOIN users as u ON a.id_user = u.id
                                     WHERE u.username = '$username'
                                     ORDER BY a.waktu_masuk DESC");

        return app('App\Http\Controllers\AbsensiController')->indexSpo($finishStor, $isAbsensi, $listAbsenUser);
    }

    /**
     * Cek apakah user sudah melakukan stor.
     * Return boolean.
     */
    protected function isFinishStor($id_user, $tanggal) {
        $tanggal = Carbon::now()->format('Y-m-d');
        $cek = DB::select("SELECT * FROM stor_produk
            WHERE id_user = '$id_user'
            AND created_at BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");

        $collection = collect($cek);
        if($collection->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Absensi untuk SPO.
     */
    public function postAbsensi(Request $request) {
        return app('App\Http\Controllers\AbsensiController')->store($request);
    }

    public function absensiKeluar() {
        $timeNow = Carbon::now();
        $lastIdAbsen = $this->getLastAbsen();
        $target = DB::update("UPDATE `absensi`
                              SET `waktu_keluar` = '$timeNow'
                              WHERE `absensi`.`id_absensi` = $lastIdAbsen;");

        return redirect('/spo/absensi');
    }

    public function getLastAbsen() {
        return app('App\Http\Controllers\SalesController')->getLastAbsen();
    }

    /**
     * Cek apakah user sudah melakukan absensi.
     * Return boolean.
     */
    protected function isAbsensi($id_user, $tanggal) {
        $cek = DB::select("SELECT * FROM `absensi`
            WHERE id_user = '$id_user'
            AND waktu_keluar BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");

        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Cek apakah user sudah melakukan absensi.
     * Return boolean.
     */
    public function isAbsenMasuk($id_user, $tanggal) {
        $cek = DB::select("SELECT * FROM `absensi`
                           WHERE id_user = '$id_user'
                           AND waktu_masuk BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
        // dd($cek);
        if(sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Mendapatkan stok yang dibawah oleh sales SPO.
     * Return Collection.
     */
    public function getStokSPO() {
        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');
        $barang = DB::select("SELECT u.nama, c.*, p.nama_produk
            FROM carry_produk c
            JOIN products p ON p.id_produk = c.id_produk
            JOIN users u ON c.id_user = u.id
            WHERE c.id_user = $id_user AND c.tanggal_carry BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59';");

        $collection = collect($barang);
        return $collection;
    }

    /**
     * Cek apakah sales sudah membawa barang.
     * Return boolean.
     */
    public function isCarry() {
        if($this->getStokSPO()->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Cek apakah user sudah melakukan request barang ke admin.
     * Return boolean.
     */
    public function isRequest($id_user, $tanggal) {
        $cek = DB::select("SELECT * FROM `request_sales`
                           WHERE id_user = '$id_user'
                           AND tanggal_request BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");

        $collection = collect($cek);
        if($collection->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Cek apakah admin sudah melakukan konfirmasi terhadap request barang.
     * Return boolean.
     */
    public function isKonfirmasi($id_user, $tanggal) {
        $cek = DB::select("SELECT * FROM `request_sales`
                           WHERE id_user = '$id_user'
                           AND tanggal_request BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'
                           AND konfirmasi = 1;");

        $collection = collect($cek);
        if($collection->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Get barang yg sudah dikonfirmasi oleh admin.
     * Return Collection.
     */
    public function getBarangKonfirmasi() {
        $user = auth()->user()->id;
        $barangKonfirmasi = DB::select("SELECT p.id_produk, p.nama_produk, r.jumlah FROM request_sales r
                    JOIN products p ON r.id_produk = p.id_produk
                    WHERE id_user = $user
                    AND konfirmasi =  1");

        $collection = collect($barangKonfirmasi);
        return $collection;
        // return $barangKonfirmasi;
    }

    /**
     * Menampilkan halaman stok jalan.
     */
    public function stokJalanPage() {
        $barang = $this->getStokSPO();
        $req = $this->isRequest(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $konfirmasi = $this->isKonfirmasi(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $absenMasuk = $this->isAbsenMasuk(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $barangKonfirmasi = $this->getBarangKonfirmasi();
        $isCarry = $this->isCarry();

        // dd($this->getStokSPO());
        return view('pages.spo.stokJalan', compact('barang', 'req', 'konfirmasi', 'absenMasuk', 'barangKonfirmasi', 'isCarry'));
    }

    /**
     * Request barang ke admin.
     */
    public function requestBarangStokJalan(Request $request) {
        // dd($request->all());
        $keys = collect(['idProduk', 'namaProduk', 'jumlah']);
        $products = collect();

        for ($i=0; $i < sizeof($request->id_produk); $i++) {
            $combined = $keys->combine([$request->id_produk[$i], $request->nama_produk[$i], (int)$request->produk[$i]]);
            $products->push($combined->all());
        }

        $filteredProduct = $products->where('jumlah', '!=', 0);

        foreach($filteredProduct as $inp) {
            RequestBarang::create(
                [
                    'id_user' => auth()->user()->id,
                    'id_produk' => $inp['idProduk'],
                    'jumlah' => $inp['jumlah'],
                    'tanggal_request' => Carbon::now(),
                    'konfirmasi' => 0
                ]
            );
        }

        app('App\Http\Controllers\HistoryRequestSalesController')->salesRequest($request, 0, 0);

        return redirect('/spo/stok_jalan');
    }

    /**
     * Terima barang yang sudah diberikan admin.
     */
    public function terimaBarang(Request $request) {
        $user = auth()->user()->id;
        if($request->has('setuju')) {
            for($i = 0; $i < sizeof($request->id_produk); $i++) {
                CarryProduk::create(
                    [
                        'id_user' => auth()->user()->id,
                        'id_produk' => $request->id_produk[$i],
                        'tanggal_carry' => Carbon::now(),
                        'stok_awal' => (int) $request->jumlah[$i],
                        'stok_sekarang' =>(int) $request->jumlah[$i],
                    ]
                );

                app('App\Http\Controllers\HistoryRequestSalesController')->konfirmasiSales($request, 'sales terima', $i);
            }
        }else {
            for($i = 0; $i < sizeof($request->id_produk); $i++) {
                // melakukan pengembalian barang ke gudang kecil
                $id_produk = $request->id_produk[$i];
                $jumlah = $request->jumlah[$i];

                // Mendapatkan stok awal di gudang kecil
                $stokAwal = DB::select("SELECT stok FROM gudang_kecil WHERE id_produk = '$id_produk'")[0]->stok;

                // Menghitung stok setelah pengembalian
                $stokSekarang = $stokAwal + $jumlah;

                // Update stok di gudang kecil
                app('App\Http\Controllers\GudangKecilController')->update($id_produk, $stokSekarang);
                app('App\Http\Controllers\HistoryRequestSalesController')->konfirmasiSales($request, 'sales tolak', $i);

            }
        }
        DB::delete("DELETE FROM request_sales WHERE id_user = $user");

        return redirect('/spo/stok_jalan');
    }

    /**
     * Mengambil seluruh data carry produk di SPO
     */

    public function totalCarryProduk($id_user, $tanggal) {
        $cek = DB::select("SELECT *
                            FROM `carry_produk` as c
                            JOIN products AS p ON p.id_produk = c.id_produk
                            WHERE id_user = '$id_user'
                            AND tanggal_carry BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");

        return $cek;
    }

    /**
     * Halaman Penjualan SPO
     */
    public function penjualanSPO(){
        // $totalCarryProduk = $this->totalCarryProduk(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $totalCarryProduk = app('App\Http\Controllers\SalesController')->getCarriedStok();
        // dd($this->getAlamatToko(4));
        // dd($this->getLastWsCode('BTL'));
        $getPenjualanSPO = $this->getPenjualanSPO(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        return view('pages.spo.tampilPenjualanSPO', compact('totalCarryProduk', 'getPenjualanSPO'));
    }

    public function getPenjualanSPO($id_user, $tanggal){
        $penjualanSPO = DB::select("SELECT DISTINCT toko_spo.id, toko_spo.nama_toko, p.id_distrik, p.jenis_spo, p.nomor_spo, keterangan, p.emp, p.latitude, p.longitude, p.created_at, foto.nama_foto 
                FROM penjualan_spo AS p 
                JOIN toko_spo ON toko_spo.id = p.id_toko 
                JOIN foto ON foto.id_foto = p.id_foto 
                JOIN keterangan ON keterangan.id_keterangan = p.id_keterangan 
                WHERE p.id_user = '$id_user' 
                AND p.created_at 
                BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59';");
        $collection = collect($penjualanSPO);
        return $collection;
    }

    /**
     * Mengambil stok user carry_spo untuk diinputkan penjualan_spo
     */
    public function getStokUser() {
        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');
        $barang = DB::select("SELECT id_produk, stok_sekarang
        FROM carry_produk
        WHERE id_user = '$id_user' AND tanggal_carry BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59';");

        return $barang;
    }
    /**
     * Mengambil stok carry produk untuk diinputkan penjualan_spo
     */
    public function getStokCarryProduk($id_produk, $id_user){
        $query = DB::select("SELECT stok_sekarang
                            FROM carry_produk
                            WHERE id_produk = '$id_produk' AND id_user = $id_user");
        return $query;
    }

    /**
     * Membuat keterangan untuk diinputkan penjualan_spo
     */
    public function createKeterangan($keterangan) {
        Keterangan::create(
            [
                'keterangan' =>$keterangan,
                'id_user' => auth()->user()->id,
                'tanggal' =>Carbon::now()->format('Y-m-d')
            ]
        );
    }

    /**
     * Membuat createToko untuk diinputkan penjualan_spo
     */
    public function createToko($req) {
        // dd($req->all());
        TokoSPO::create(
            [
                'nama_toko' => $req->inputTokoBaru,
                'alamat' => $req->alamat_spo,
                'id_distrik'=>$req->distrik_spo,
                'ws'=>$req->wsCode,
                'telepon' =>$req->telepon,
                'latitude' =>$req->latitude,
                'longitude' =>$req->longitude
            ]
        );
    }

    /**
     * Mengambil Data Toko Baru
     */
    public function getTokoBaru($req) {

        $toko = DB::select("SELECT * FROM `toko_spo`
                            WHERE id_distrik = '$req->distrik_spo'
                            AND nama_toko = '$req->inputTokoBaru'
                            ORDER BY created_at DESC
                            LIMIT 1");
        $collectToko = collect($toko);
        return $collectToko;
    }

    /**
     * Mengambil Data Toko Lama
     */
    public function getTokoLama($req) {
        dd($request->all());
        $toko = DB::select("SELECT * FROM `toko_spo`
                            WHERE id_distrik = '$req->distrik_spo'
                            AND nama_toko = '$req->inputTokoLama'
                            ORDER BY created_at DESC
                            LIMIT 1");
        $collectToko = collect($toko);
        return $collectToko;
    }

    /**
     * Formulir Penjualan SPO
     */
    public function postPenjualanSPO(Request $request){
        // dd($request->all());
        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');

        $emp = "";
        // $jumlahEmp = [];
        // dd($request->jumlahEmp);
        if (!empty($request->emp)) {
            foreach ($request->emp as $index => $e) {
                $em = $request->jumlahEmp[$index];
                    $emp .= $e . '('.$em.')'.'; ';
            // Ambil data 'emp' dari tabel berdasarkan kolom 'jenis'
            $empData = Emp::where('jenis', $e)->first();

            // Lakukan pengurangan pada kolom 'jumlah'
            $updatedJumlah = $empData->jumlah - $em;

            // Perbarui (update) nilai kolom 'jumlah' dalam tabel 'emp'
            $empData->update(['jumlah' => $updatedJumlah]);
            }
            // dd($emp);
        }

        // UPDATE STOK
        $barang = $this->getStokUser();
        // dd($barang);
        $data = [];
        for ($i = 0; $i < count($request->id_produk); $i++) {
            if ($request->jumlah[$i] != '0') {
                $productId = $request->id_produk[$i];
                $carryValue = (int) $request->jumlah[$i];
                $stokCarry = $this->getStokCarryProduk($productId, $id_user);
                $stokCarryValue = $stokCarry[0]->stok_sekarang;
                // dd($stokCarryValue);

                if ($carryValue > $stokCarryValue) {
                    // Stok carry produk yang dibawa kurang, tampilkan pesan kesalahan
                    return redirect()->back()->with('error', 'Stok carry produk ' . $productId . ' kurang.');
                }

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
        // dd($request->all());
        // FOTO
        $tanggal = Carbon::now()->format('Y-m-d');
        $validatedData = $request->validate([
            'foto' => 'image'
        ]);
        // ddd($validatedData);
        $fotoPath = $request->file('foto')->store('public/fotoTokoSpo'); // Simpan file gambar ke direktori penyimpanan
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

        $keterangan = DB::select("SELECT * FROM `keterangan`
                       WHERE id_user = '$id_user'
                       AND tanggal = '$tanggal'
                       ORDER BY created_at DESC");

        // dd($request->all());

        if($request->jenisToko == 'TokoBaru') {
            $this->createToko($request);

            $toko = $this->getTokoBaru($request);
        } else {
            $toko = $this->getTokoLama($request);
        }

        $id_toko = $toko[0]->id;
        // dd($request->all());
        for ($i = 0; $i < count($request->id_produk); $i++) {
            if ($request->jumlah[$i] != '0') {
                if($request->get('keterangan') != null) {
                    // dd($request->all());
                    PenjualanSPO::create(
                        [
                            'id_user' => auth()->user()->id,
                            'id_distrik' => $request->distrik_spo,
                            'id_toko' => $id_toko,
                            'jenis_spo' => $request->jenisSpo,
                            'nomor_spo' => $request->nomor_nota,
                            'id_produk' => $request->id_produk[$i],
                            'jumlah_produk' => (int) $request->jumlah[$i],
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
        // dd($data);
        return redirect('/spo/penjualan_spo');
    }

    /**
     * Mengambil Detail Penjualan SPO.
     */
    public function detailJualSPO($id_toko){
        $data = DB::select("SELECT p.*, products.harga_toko, products.nama_produk, toko_spo.id 
        FROM penjualan_spo AS p 
        JOIN toko_spo ON toko_spo.id = p.id_toko 
        JOIN products ON products.id_produk = p.id_produk 
        WHERE p.id_toko = $id_toko;");
        // dd($data);

        return view('pages.spo.tampilDetailPenjualanSPO', compact('data'));
    }

    public function tampilStorProduk() {
        $storproduk = app('App\Http\Controllers\SalesController')->getStorProduk();
        $storPenjualan = app('App\Http\Controllers\SalesController')->getStorPenjualan();
        $req = app('App\Http\Controllers\SalesController')->isRequestStorBarang(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $reqUang = app('App\Http\Controllers\SalesController')->isRequestStorUang(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $konfirmasi = app('App\Http\Controllers\SalesController')->isKonfirmasiStorBarang(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $konfirmasiUang = app('App\Http\Controllers\SalesController')->isKonfirmasiStorUang(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $storToday = app('App\Http\Controllers\SalesController')->isTodayStorProduk(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $carryToday = app('App\Http\Controllers\SalesController')->isCarry();
        // dd($carryToday);
        return view('pages.spo.storprodukspo', compact('storproduk','storPenjualan', 'req', 'reqUang', 'konfirmasi', 'konfirmasiUang', 'storToday', 'carryToday'));
    }

    public function requestStorBarang(Request $request) {
        // dd($request->all());
        $user = auth()->user()->id;
        if($request->has('setujuStorProduk')) {
            // dd($request->all());
            for($i = 0; $i < sizeof($request->id_produk); $i++) {
                RequestStorBarang::create(
                    [
                    'id_user'=> auth()->user()->id,
                    'id_produk'=> $request->id_produk[$i],
                    'tanggal_stor_barang'=>Carbon::now(),
                    'stok_awal'=>(int) $request->stok_awal[$i],
                    'sisa_stok'=>(int) $request->stok_sekarang[$i],
                    'terjual'=>(int) $request->terjual[$i],
                    'harga_produk'=>(int) $request->harga_toko[$i],
                    'total_harga'=>(int) $request->total_harga[$i],
                    'konfirmasi' => 0,
                    ]
                );

                DB::update("UPDATE `gudang_kecil`
                        SET `stok` = `stok` + :stok
                        WHERE `id_produk` = :id_produk", [
                            'stok' => (int) $request->stok_sekarang[$i],
                            'id_produk' => $request->id_produk[$i]
                        ]);
            }
        }
        app('App\Http\Controllers\HistoryRequestSalesController')->salesRequestStorBarang($request, 0);
        return redirect('/spo/stor_produk');
    }

    public function requestStorUang(Request $request){
        // dd($request->all());
        $user = auth()->user()->id;
        $today = Carbon::now()->format('Y-m-d');
        if($request->has('setujuStorUang')) {
            // dd($request->all());
            $request->validate([
                'seratusribu.*' => 'nullable|numeric|min:0',
                'limapuluhribu.*' => 'nullable|numeric|min:0',
                'duapuluhribu.*' => 'nullable|numeric|min:0',
                'sepuluhribu.*' => 'nullable|numeric|min:0',
                'limaribu.*' => 'nullable|numeric|min:0',
                'duaribu.*' => 'nullable|numeric|min:0',
                'seribu.*' => 'nullable|numeric|min:0',
                'seribukoin.*' => 'nullable|numeric|min:0',
                'limaratuskoin.*' => 'nullable|numeric|min:0',
                'duaratuskoin.*' => 'nullable|numeric|min:0',
                'seratuskoin.*' => 'nullable|numeric|min:0',
            ]);

            $totalUang = 100000 * $request->input('seratusribu', 0)
                 + 50000 * $request->input('limapuluhribu', 0)
                 + 20000 * $request->input('duapuluhribu', 0)
                 + 10000 * $request->input('sepuluhribu', 0)
                 + 5000 * $request->input('limaribu', 0)
                 + 2000 * $request->input('duaribu', 0)
                 + 1000 * $request->input('seribu', 0)
                 + 1000 * $request->input('seribukoin', 0)
                 + 500 * $request->input('limaratuskoin', 0)
                 + 200 * $request->input('duaratuskoin', 0)
                 + 100 * $request->input('seratuskoin', 0);
            // dd($totalUang);
            $result = DB::select("SELECT total_harga FROM `request_stor_barang`
                                        WHERE id_user = '$user'
                                        AND tanggal_stor_barang BETWEEN '$today 00:00:00' AND '$today 23:59:59'
                                        AND konfirmasi = 1;");
            $totalHarga = 0;
            foreach ($result as $item) {
                $totalHarga += $item->total_harga;
            }

            // dd($totalHarga);
            if ($totalUang != $totalHarga) {
                // $errorMessage = 'Jumlah uang yang Anda masukkan (' . $totalUang . ') tidak sesuai dengan total harga (' . $totalHarga . ').';
                // return back()->with('error', $errorMessage);
            }else{
                $user = auth()->user()->id;
                $today = Carbon::now()->format('Y-m-d');
                // dd($request->all());
                RincianUang::create(
                    [
                        'id_user' => auth()->user()->id,
                        'tanggal_masuk'=>$today,
                        'seratus_ribu' => $request->input('seratusribu'),
                        'lima_puluh_ribu' => $request->input('limapuluhribu'),
                        'dua_puluh_ribu' => $request->input('duapuluhribu'),
                        'sepuluh_ribu' => $request->input('sepuluhribu'),
                        'lima_ribu' => $request->input('limaribu'),
                        'dua_ribu' => $request->input('duaribu'),
                        'seribu' => $request->input('seribu'),
                        'seribu_koin' => $request->input('seribukoin'),
                        'lima_ratus_koin' => $request->input('limaratuskoin'),
                        'dua_ratus_koin' => $request->input('duaratuskoin'),
                        'seratus_koin' => $request->input('seratuskoin'),
                    ]
                );
                $ambilUang = DB::select("SELECT * FROM `rincian_uang`
                       WHERE id_user = '$user'
                       AND tanggal_masuk = '$today'
                       ORDER BY created_at DESC
                       LIMIT 1");
                // dd($ambilUang);
                $record = RequestStorBarang::where('id_user', $user)
                    ->whereBetween('tanggal_stor_barang', [$today . ' 00:00:00', $today . ' 23:59:59'])
                    ->first();
                // dd($record);
                if ($record) {
                    $record->where('id_user', $user)->update([
                        'tanggal_stor_uang' => Carbon::now(),
                        'konfirmasi2' => 0,
                        'id_rincian_uang' => $ambilUang[0]->id_rincian_uang
                    ]);
                }
            }
        }
        // DB::delete("DELETE FROM stor_produk WHERE id_user = $user");
        app('App\Http\Controllers\HistoryRequestSalesController')->salesRequestStorPenjualan($request, 0);
        return redirect('/spo/stor_produk');
    }

    public function insertStorProduk(Request $request) {
        $user = auth()->user()->id;
        if($request->has('setujuinsert')) {
        // dd($request->all());
            for($i = 0; $i < sizeof($request->id_produk); $i++) {
                StorProduk::create(
                    [
                    'id_user'=> auth()->user()->id,
                    'id_produk'=> $request->id_produk[$i],
                    'tanggal_stor_barang'=>$request->tanggal_stor_barang[$i],
                    'tanggal_stor_uang'=>$request->tanggal_stor_uang[$i],
                    'stok_awal'=>(int) $request->stok_awal[$i],
                    'terjual'=>(int)$request->terjual[$i],
                    'sisa_stok'=>(int) $request->sisa_stok[$i],
                    'harga_produk'=>(int) $request->harga_produk[$i],
                    'total_harga'=>(int) $request->total_harga[$i],
                    'id_rincian_uang'=>(int) $request->id_rincian_uang[$i]
                    ]
                );
            }
        }
        DB::delete("DELETE FROM request_stor_barang WHERE id_user = $user");

        // create KPI
        app('App\Http\Controllers\KPIController')->insertKPI();
        return redirect('/spo/stor_produk');

    }


    /**
     * Get distrik SPO.
     * Distrik yang tidak memiliki id_user. (sementara)
     * Return JSON response.
     */
    public function getDistrik() {
        $distrik = DB::select("SELECT * FROM distrik WHERE id_user IS NULL");

        return response()->json($distrik);
    }

    /**
     * Get toko SPO berdasatkan id_distrik.
     * Return JSON response.
     */
    public function getTokoByDistrik($idDistrik) {
        $toko = $this->getAllToko()->where('id_distrik', $idDistrik);
        $collection = collect();

        foreach ($toko as $tk) {
            $collection->push($tk);
        }

        return response()->json($collection);
    }

    /**
     * Get semua data toko SPO.
     * Return Collection.
     */
    public function getAllToko() {
        $toko = DB::select("SELECT * FROM toko_spo");

        return collect($toko);
    }

    /**
     * Get nomor aktivasi SPO sesuai id_toko.
     * Return last value aktivasi dari toko tersebut.
     */
    public function getLastAktivasi($idToko) {
        $data = DB::select("SELECT * FROM aktivasi_spo WHERE id_toko = $idToko");

        $aktivasi = collect($data);

        $sortedAktivasi = $aktivasi->sortBy('aktivasi', SORT_NATURAL);
        return $sortedAktivasi->values()->last()->aktivasi;
    }

    /**
     * Get WS code pada distrik tertentu.
     * Return JSON response last value WS code dari distrik tersebut.
     */
    public function getLastWsCode($distrik) {
        $data = DB::select("SELECT aspo.*, ts.*
            FROM aktivasi_spo aspo
            JOIN toko_spo ts ON aspo.id_toko = ts.id
            WHERE ts.id_distrik = '$distrik'");

        $sortedWs = collect($data)->sortBy('ws', SORT_NATURAL)->values();
        $result = $sortedWs->last()->ws;
        return response()->json($result);
        // return $result;
    }

    /**
     * Get alamat dari toko berdasarkan id_toko.
     * Return JSON response.
     */
    public function getAlamatToko($idToko) {
        $toko = $this->getAllToko()->where('id', $idToko);
        $aktivasi = $this->getLastAktivasi($idToko);
        $value = $toko->values();

        $data = collect($value->get(0));
        $data->put('aktivasi', $aktivasi);

        return response()->json([$data]);
    }

}
