<?php

namespace App\Http\Controllers;

use App\Models\ClosedSPO;
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
use App\Models\AktivasiSPO;
// use App\Http\Controllers\SalesController;
use App\Http\Controllers\Penjualan\FormProdukController;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class SPOController extends Controller
{
    private $salesController;
    private $empController;
    private $formProdukController;

    public function __construct(SalesController $salesController, EmpController $empController, FormProdukController $formProdukController)
    {
        $this->salesController = $salesController;
        $this->empController = $empController;
        $this->formProdukController = $formProdukController;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd($this->getAllToko()->where('id_distrik', 'BTL'));
        // dd(Carbon::now()->addDays(30)->format('Y-m-d'));
        // dd($this->getAllToko());
        // dd($this->getLastToko());
        // dd($this->getPenjualanSPO(auth()->user()->id));
        // $tanggal1 = Carbon::parse($this->getPenjualanSPO(auth()->user()->id)->get(0)->tanggal_masuk);
        // $tanggal2 = Carbon::parse($this->getPenjualanSPO(auth()->user()->id)->get(0)->tanggal_jatuh_tempo);
        // dd($tanggal1->diff($tanggal2)->days);
        // dd($this->getTokoByDistrik('KOT'));
        // dd($this->getAktivasi('109', '001'));
        // dd($this->salesController->tes(90));
        // dd($this->getTokoById(110));
        // dd($this->detailJualSPO(110));
        // dd($this->getPenjualanSPO(auth()->user()->id));
        return view('pages.spo.dashboard');
    }

    /**
     * Menampilkan halaman absensi SPO.
     */
    public function pageAbsensiSPO()
    {
        $username = auth()->user()->username;
        $finishStor = $this->isFinishStor(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $isAbsensi = $this->isAbsensi(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $listAbsenUser = app('App\Http\Controllers\SalesController')->listAbsenUser(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $listAbsenUserAll = app('App\Http\Controllers\SalesController')->listAbsenUserAll(auth()->user()->username);


        return app('App\Http\Controllers\AbsensiController')->indexSpo($finishStor, $isAbsensi, $listAbsenUser, $listAbsenUserAll);
    }

    /**
     * Cek apakah user sudah melakukan stor.
     * Return boolean.
     */
    protected function isFinishStor($id_user, $tanggal)
    {
        $tanggal = Carbon::now()->format('Y-m-d');
        $cek = DB::select("SELECT * FROM stor_produk
            WHERE id_user = '$id_user'
            AND created_at BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");

        $collection = collect($cek);
        if ($collection->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Absensi untuk SPO.
     */
    public function postAbsensi(Request $request)
    {
        return app('App\Http\Controllers\AbsensiController')->store($request);
    }

    public function absensiKeluar()
    {
        $timeNow = Carbon::now();
        $lastIdAbsen = $this->getLastAbsen();
        $target = DB::update("UPDATE `absensi`
                              SET `waktu_keluar` = '$timeNow'
                              WHERE `absensi`.`id_absensi` = $lastIdAbsen;");

        return redirect('/spo/absensi');
    }

    public function getLastAbsen()
    {
        return app('App\Http\Controllers\SalesController')->getLastAbsen();
    }

    /**
     * Cek apakah user sudah melakukan absensi.
     * Return boolean.
     */
    protected function isAbsensi($id_user, $tanggal)
    {
        // $tanggal = Carbon::now()->format('Y-m-d');
        $cek = DB::select("SELECT * FROM `absensi`
            WHERE id_user = '$id_user'
            AND waktu_keluar BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");

        // dd($cek);
        if (sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Cek apakah user sudah melakukan absensi.
     * Return boolean.
     */
    public function isAbsenMasuk($id_user, $tanggal)
    {
        $cek = DB::select("SELECT * FROM `absensi`
                           WHERE id_user = '$id_user'
                           AND waktu_masuk BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");
        // dd($cek);
        if (sizeof($cek) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Mendapatkan stok yang dibawah oleh sales SPO.
     * Return Collection.
     */
    public function getStokSPO()
    {
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
    public function isCarry()
    {
        if ($this->getStokSPO()->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Cek apakah user sudah melakukan request barang ke admin.
     * Return boolean.
     */
    public function isRequest($id_user, $tanggal)
    {
        $cek = DB::select("SELECT * FROM `request_sales`
                           WHERE id_user = '$id_user'
                           AND tanggal_request BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'");

        $collection = collect($cek);
        if ($collection->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Cek apakah admin sudah melakukan konfirmasi terhadap request barang.
     * Return boolean.
     */
    public function isKonfirmasi($id_user, $tanggal)
    {
        $cek = DB::select("SELECT * FROM `request_sales`
                           WHERE id_user = '$id_user'
                           AND tanggal_request BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'
                           AND konfirmasi = 1;");

        $collection = collect($cek);
        if ($collection->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * Get barang yg sudah dikonfirmasi oleh admin.
     * Return Collection.
     */
    public function getBarangKonfirmasi()
    {
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
    public function stokJalanPage()
    {
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
    public function requestBarangStokJalan(Request $request)
    {
        // dd($request->all());
        $keys = collect(['idProduk', 'namaProduk', 'jumlah']);
        $products = collect();

        for ($i = 0; $i < sizeof($request->id_produk); $i++) {
            $combined = $keys->combine([$request->id_produk[$i], $request->nama_produk[$i], (int) $request->produk[$i]]);
            $products->push($combined->all());
        }

        $filteredProduct = $products->where('jumlah', '!=', 0);

        foreach ($filteredProduct as $inp) {
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
    public function terimaBarang(Request $request)
    {
        $user = auth()->user()->id;
        if ($request->has('setuju')) {
            for ($i = 0; $i < sizeof($request->id_produk); $i++) {
                CarryProduk::create(
                    [
                        'id_user' => auth()->user()->id,
                        'id_produk' => $request->id_produk[$i],
                        'tanggal_carry' => Carbon::now(),
                        'stok_awal' => (int) $request->jumlah[$i],
                        'stok_sekarang' => (int) $request->jumlah[$i],
                    ]
                );

                app('App\Http\Controllers\HistoryRequestSalesController')->konfirmasiSales($request, 'sales terima', $i);
            }
        } else {
            for ($i = 0; $i < sizeof($request->id_produk); $i++) {
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
    public function totalCarryProduk($id_user, $tanggal)
    {
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
    public function penjualanSPO()
    {
        $totalCarryProduk = app('App\Http\Controllers\SalesController')->getCarriedStok();

        // $getPenjualanSPO = $this->getPenjualanSPO(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        // $getPenjualanSPO = $this->getPenjualanSPO(auth()->user()->id)->where('is_close', 0)->values();
        $getPenjualanSPO = $this->getPenjualanSPO(auth()->user()->id);
        // dd($getPenjualanSPO->where('is_close', 0)->values());
        return view('pages.spo.tampilPenjualanSPO', compact('totalCarryProduk', 'getPenjualanSPO'));
    }


    /**
     * Data yang tampil di penjualan_spo.
     * Sudah beserta sisa hari menuju jatuh tempo.
     * Return Collection.
     */
    public function getPenjualanSPO($idUser)
    {
        // $penjualanSPO = DB::select("SELECT DISTINCT toko_spo.id AS 'id_toko', toko_spo.nama_toko, p.id_distrik, p.jenis_spo, aspo.is_close, p.nomor_spo, p.tanggal_masuk,p.tanggal_jatuh_tempo, keterangan, p.emp, p.latitude, p.longitude, foto.nama_foto
        //     FROM penjualan_spo AS p
        //     JOIN aktivasi_spo AS aspo
        //     JOIN toko_spo ON toko_spo.id = p.id_toko
        //     JOIN foto ON foto.id_foto = p.id_foto
        //     JOIN keterangan ON keterangan.id_keterangan = p.id_keterangan
        //     WHERE p.id_user = '$idUser'");
        $penjualanSPO = DB::select("SELECT pspo.id_toko, t.nama_toko, pspo.id_distrik, pspo.nomor_spo, pspo.tanggal_masuk, pspo.tanggal_jatuh_tempo, k.keterangan, pspo.emp, f.nama_foto, MAX(aspo.aktivasi) AS aktivasi, MIN(aspo.is_close) AS is_close, MAX(aspo.is_cash) AS is_cash FROM toko_spo t JOIN penjualan_spo pspo ON pspo.id_toko = t.id JOIN keterangan k ON k.id_keterangan = pspo.id_keterangan JOIN foto f ON f.id_foto = pspo.id_foto JOIN aktivasi_spo aspo ON aspo.id_toko = t.id WHERE pspo.id_user = ? GROUP BY pspo.id_toko, t.nama_toko, pspo.id_distrik, pspo.nomor_spo, pspo.tanggal_masuk, pspo.tanggal_jatuh_tempo, k.keterangan, pspo.emp, f.nama_foto;", [$idUser]);

        // menghilangkan simbol +
        // contoh : +"id_toko": 110
        // sehingga menjadi 'key' => 'value'
        $collection = collect($penjualanSPO)->map(function ($item) {
            return collect($item)->mapWithKeys(function ($value, $key) {
                $cleanedKey = ltrim($key, '+');
                return [$cleanedKey => $value];
            });
        });

        // menghitung sisa hari menuju jatuh tempo
        $collection->map(function ($item) {
            $tgl1 = Carbon::now();
            $tgl2 = Carbon::parse($item->get('tanggal_jatuh_tempo'));
            $sisa_jatuh_tempo = $tgl1->diff($tgl2)->days;

            $item['sisa_jatuh_tempo'] = $sisa_jatuh_tempo;
            return $item;
        });

        return $collection;
    }

    public function getPenjualanSPOClose($idUser)
    {
        $penjualanSPO = DB::select("SELECT DISTINCT pspo.id_toko, t.nama_toko, pspo.id_distrik, pspo.nomor_spo, pspo.tanggal_masuk, pspo.tanggal_jatuh_tempo, k.keterangan, pspo.emp, f.nama_foto, aspo.aktivasi, aspo.is_close, aspo.is_cash FROM toko_spo t JOIN penjualan_spo pspo ON pspo.id_toko = t.id JOIN keterangan k ON k.id_keterangan = pspo.id_keterangan JOIN foto f ON f.id_foto = pspo.id_foto JOIN aktivasi_spo aspo ON aspo.id_toko = t.id WHERE pspo.id_user = ? AND is_close = 1;", [$idUser]);
        // dd($penjualanSPO);
    }

    /**
     * Mengambil stok user carry_spo untuk diinputkan penjualan_spo
     */
    public function getStokUser()
    {
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
    public function getStokCarryProduk($id_produk, $id_user)
    {
        $query = DB::select("SELECT stok_sekarang
                            FROM carry_produk
                            WHERE id_produk = '$id_produk' AND id_user = $id_user");
        return $query;
    }

    /**
     * Membuat keterangan untuk diinputkan penjualan_spo
     */
    public function createKeterangan($keterangan)
    {
        Keterangan::create(
            [
                'keterangan' => $keterangan,
                'id_user' => auth()->user()->id,
                'tanggal' => Carbon::now()->format('Y-m-d')
            ]
        );
    }

    /**
     * Membuat createToko untuk diinputkan penjualan_spo
     */
    public function createToko($req)
    {
        // dd($req->all());
        TokoSPO::create(
            [
                'nama_toko' => $req->inputTokoBaru,
                'alamat' => $req->alamat_spo,
                'id_distrik' => $req->distrik_spo,
                'ws' => $req->wsCode,
                'telepon' => $req->telepon,
                'latitude' => $req->latitude,
                'longitude' => $req->longitude
            ]
        );
    }

    public function getLastToko()
    {
        $toko = DB::select("SELECT * FROM `toko_spo` ORDER BY created_at DESC LIMIT 1");
        $collectToko = collect($toko);
        return $collectToko;
    }

    /**
     * Mengambil Data Toko Baru
     */
    public function getTokoBaru(Request $request): Collection
    {
        // $toko = DB::select("SELECT * FROM `toko_spo`
        //                     WHERE id_distrik = '$req->distrik_spo'
        //                     AND nama_toko = '$req->inputTokoBaru'
        //                     ORDER BY created_at DESC
        //                     LIMIT 1");
        $toko = DB::select("SELECT * FROM `toko_spo`
                            WHERE id_distrik = '$request->distrik_spo'
                            AND nama_toko = '$request->inputTokoBaru'");
        // $collectToko = collect($toko);s
        return new Collection($toko);
    }

    /**
     * Mengambil Data Toko Lama
     */
    public function getTokoLama($req)
    {
        // dd($request->all());
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
    public function postPenjualanSPO(Request $request)
    {
        $requestToCollection = collect($request);
        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');

        $emp = (!empty($requestToCollection->has('emp'))) ? $this->empController->proccessEmp($request) : "";

        // dd($request->all());
        // UPDATE STOK
        $barang = $this->getStokUser();
        $data = [];
        for ($i = 0; $i < count($request->id_produk); $i++) {
            if ($request->jumlah[$i] != '0') {
                $productId = $request->id_produk[$i];
                $carryValue = (int) $request->jumlah[$i];
                $stokCarry = $this->getStokCarryProduk($productId, $id_user);
                $stokCarryValue = $stokCarry[0]->stok_sekarang;

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
        }

        // FOTO
        $validatedData = $request->validate([
            'foto' => 'image'
        ]);
        // ddd($validatedData);
        $fotoPath = $request->file('foto')->store('public/fotoTokoSpo'); // Simpan file gambar ke direktori penyimpanan
        Foto::create([
            'nama_foto' => $fotoPath,
            'id_user' => auth()->user()->id,
            'tanggal' => $tanggal
        ]);
        $id_user = auth()->user()->id;
        $foto = DB::select("SELECT * FROM `foto`
                       WHERE id_user = '$id_user'
                       AND tanggal = '$tanggal'
                       ORDER BY created_at DESC");

        // KETERANGAN
        if ($request->get('keterangan') != null) {
            $this->createKeterangan($request->get('keterangan'));
        }

        $keterangan = DB::select("SELECT * FROM `keterangan`
                       WHERE id_user = '$id_user'
                       AND tanggal = '$tanggal'
                       ORDER BY created_at DESC");

        if ($request->jenisToko == 'TokoBaru') {
            $this->createToko($request);
            $toko = $this->getTokoBaru($request);
            $id_toko = $toko->get(0)->id;
            $this->createAktivasi($request, $id_toko);
        } else {
            $id_toko = $request->inputTokoLama;
            $this->createAktivasi($request, $id_toko);
        }

        for ($i = 0; $i < count($request->id_produk); $i++) {
            if ($request->jumlah[$i] != '0') {
                if ($request->get('keterangan') != null) {
                    PenjualanSPO::create(
                        [
                            'id_user' => auth()->user()->id,
                            'id_distrik' => $request->distrik_spo,
                            'id_toko' => $id_toko,
                            'tanggal_masuk' => $tanggal,
                            'tanggal_jatuh_tempo' => Carbon::now()->addDays(30)->format('Y-m-d'),
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

        return redirect('/spo/penjualan_spo');
    }

    /**
     * Mengambil Detail Penjualan SPO.
     */
    public function detailJualSPO($id_toko)
    {
        $toko = $this->getTokoById($id_toko);
        $data = DB::select("SELECT p.id_penjualan_spo, p.id_toko, p.tanggal_masuk, p.tanggal_jatuh_tempo, p.jenis_spo, p.nomor_spo, p.emp, p.latitude, p.longitude, products.id_produk, products.nama_produk, p.jumlah_produk, products.harga_toko
        FROM penjualan_spo AS p
        JOIN products ON products.id_produk = p.id_produk
        WHERE p.id_toko = $id_toko;");

        $closed = $this->getClosedSpo($id_toko);
        // dd($closed->get(0));

        return view('pages.spo.tampilDetailPenjualanSPO', compact('data', 'toko', 'closed'));
    }

    public function tampilStorProduk()
    {
        $storproduk = $this->getStorProduk();
        $storPenjualan = app('App\Http\Controllers\SalesController')->getStorPenjualan();
        $req = app('App\Http\Controllers\SalesController')->isRequestStorBarang(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $reqUang = app('App\Http\Controllers\SalesController')->isRequestStorUang(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $konfirmasi = app('App\Http\Controllers\SalesController')->isKonfirmasiStorBarang(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $konfirmasiUang = app('App\Http\Controllers\SalesController')->isKonfirmasiStorUang(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $storToday = app('App\Http\Controllers\SalesController')->isTodayStorProduk(auth()->user()->id, Carbon::now()->format('Y-m-d'));
        $closeToday = $this->isCloseSPO();
        $carryToday = $this->isCarry();
        // dd($carryToday);
        return view('pages.spo.storprodukspo', compact('storproduk', 'storPenjualan', 'req', 'reqUang', 'konfirmasi', 'konfirmasiUang', 'storToday', 'closeToday', 'carryToday'));
    }

    public function getStorProduk()
    {
        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');
        $barang = DB::select("SELECT users.nama, c.*,
         products.nama_produk,
         products.harga_toko,c.jumlah_produk,
         c.jumlah_produk * products.harga_toko as total_harga
        FROM closed_spo AS c
        JOIN products ON products.id_produk = c.id_produk
        JOIN users ON c.id_user = users.id
        WHERE c.id_user = '$id_user' AND c.tanggal_close_spo BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59';");
        return $barang;
    }

    public function getStokUserClose()
    {
        $id_user = auth()->user()->id;
        $tanggal = Carbon::now()->format('Y-m-d');
        $barang = DB::select("SELECT users.nama, c.*, products.nama_produk
        FROM closed_spo AS c
        JOIN products ON products.id_produk = c.id_produk
        JOIN users ON c.id_user = users.id
        WHERE c.id_user = '$id_user' AND c.tanggal_close_spo BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59';");

        return collect($barang);
    }

    public function isCloseSPO()
    { // cek apakah sales sudah bawa barang
        if (sizeof($this->getStokUserClose()) > 0) {
            return true;
        }
        return false;
    }

    public function requestStorBarang(Request $request)
    {
        //  dd($request->all());
        $user = auth()->user()->id;
        if ($request->has('setujuStorProduk')) {
            // dd($request->all());
            for ($i = 0; $i < sizeof($request->id_produk); $i++) {
                RequestStorBarang::create(
                    [
                        'id_user' => auth()->user()->id,
                        'id_produk' => $request->id_produk[$i],
                        'tanggal_stor_barang' => Carbon::now(),
                        'stok_awal' => 0,
                        'sisa_stok' => 0,
                        'terjual' => (int) $request->jumlah_produk[$i],
                        'harga_produk' => (int) $request->harga_toko[$i],
                        'total_harga' => (int) $request->total_harga[$i],
                        'konfirmasi' => 0,
                    ]
                );

                DB::update("UPDATE `gudang_kecil`
                        SET `stok` = `stok` + :stok
                        WHERE `id_produk` = :id_produk", [
                    'stok' => (int) $request->jumlah_produk[$i],
                    'id_produk' => $request->id_produk[$i]
                ]);
            }
        }
        app('App\Http\Controllers\HistoryRequestSalesController')->salesRequestStorBarangSPO($request, 0);
        return redirect('/spo/stor_produk');
    }

    public function requestStorUang(Request $request)
    {
        // dd($request->all());
        $user = auth()->user()->id;
        $today = Carbon::now()->format('Y-m-d');
        if ($request->has('setujuStorUang')) {
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
            } else {
                $user = auth()->user()->id;
                $today = Carbon::now()->format('Y-m-d');
                RincianUang::create(
                    [
                        'id_user' => auth()->user()->id,
                        'tanggal_masuk' => $today,
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

                if ($record) {
                    $record->where('id_user', $user)->update([
                        'tanggal_stor_uang' => Carbon::now(),
                        'konfirmasi2' => 0,
                        'id_rincian_uang' => $ambilUang[0]->id_rincian_uang
                    ]);
                }
            }
        }

        app('App\Http\Controllers\HistoryRequestSalesController')->salesRequestStorPenjualanSPO($request, 0);
        return redirect('/spo/stor_produk');
    }

    public function insertStorProduk(Request $request)
    {
        $user = auth()->user()->id;
        if ($request->has('setujuinsert')) {
            // dd($request->all());
            for ($i = 0; $i < sizeof($request->id_produk); $i++) {
                StorProduk::create(
                    [
                        'id_user' => auth()->user()->id,
                        'id_produk' => $request->id_produk[$i],
                        'tanggal_stor_barang' => $request->tanggal_stor_barang[$i],
                        'tanggal_stor_uang' => $request->tanggal_stor_uang[$i],
                        'stok_awal' => (int) $request->stok_awal[$i],
                        'terjual' => (int) $request->terjual[$i],
                        'sisa_stok' => (int) $request->sisa_stok[$i],
                        'harga_produk' => (int) $request->harga_produk[$i],
                        'total_harga' => (int) $request->total_harga[$i],
                        'id_rincian_uang' => (int) $request->id_rincian_uang[$i]
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
    public function getDistrik()
    {
        $distrik = DB::select("SELECT * FROM distrik WHERE id_user IS NULL");

        return response()->json($distrik);
    }

    /**
     * Get toko SPO berdasatkan id_distrik.
     * Return JSON response.
     */
    public function getTokoByDistrik($idDistrik)
    {
        $toko = $this->getAllToko()->where('id_distrik', $idDistrik)->values();

        return response()->json($toko);
    }

    public function getTokoById($idToko): TokoSPO
    {
        $toko = TokoSPO::find($idToko);

        return $toko;
    }

    /**
     * Get semua data toko SPO.
     * Return Collection.
     */
    public function getAllToko()
    {
        // $toko = DB::select("SELECT * FROM toko_spo");
        $toko = DB::select("SELECT t.*, aspo.aktivasi, aspo.is_close, aspo.is_cash
        FROM aktivasi_spo AS aspo
        JOIN toko_spo AS t ON t.id = aspo.id_toko;");

        return collect($toko)->lazy();
    }

    /**
     * insert data tabel aktivasi
     */
    public function createAktivasi($request, $idToko)
    {
        AktivasiSPO::create(
            [
                // 'id_toko' => $toko->id,
                'id_toko' => $idToko,
                'aktivasi' => $request->nomorAktivasi,
                'id_close' => 0,
                'is_cash' => 0,
            ]
        );
    }

    /**
     * Get data dari berdasarkan id_toko dan nomor aktivasi data tabel aktivasi
     */
    public function getAktivasi($idToko)
    {
        $data = DB::select("SELECT *
        FROM aktivasi_spo
        WHERE id_toko = $idToko");

        return collect($data);
    }

    // public function getLastAktivasi()
    // {
    //     $data = DB::select("SELECT * FROM aktivasi_spo ORDER BY id DESC LIMIT 1;");

    //     return $data;
    // }

    /**
     * Get nomor aktivasi SPO sesuai id_toko.
     * Misal 001 + 1 = 002.
     * Return last value aktivasi + 1 dari toko tertentu.
     */
    public function getIncLastAktivasi($idToko)
    {
        $data = DB::select("SELECT * FROM aktivasi_spo WHERE id_toko = $idToko");

        $aktivasi = collect($data);

        $sortedAktivasi = $aktivasi->sortBy('aktivasi', SORT_NATURAL)->values();
        $result = $sortedAktivasi->last()->aktivasi;

        $inc = (int) $result + 1;
        $incResult = sprintf('%03d', $inc);

        return $incResult;
        // return $sortedAktivasi->values()->last()->aktivasi;
    }

    /**
     * Get WS code + 1 pada distrik tertentu.
     * Misal 039 + 1 = 040.
     * Return JSON response last value WS code + 1 dari distrik tertentu.
     */
    public function getLastWsCode($distrik)
    {
        $data = DB::select("SELECT aspo.*, ts.*
            FROM aktivasi_spo aspo
            JOIN toko_spo ts ON aspo.id_toko = ts.id
            WHERE ts.id_distrik = '$distrik'");

        $sortedWs = collect($data)->sortBy('ws', SORT_NATURAL)->values();
        $result = $sortedWs->last()->ws;

        $inc = (int) $result + 1;
        $incResult = sprintf('%03d', $inc);
        return response()->json($incResult);
        // return $data;
    }

    /**
     * Get alamat dari toko berdasarkan id_toko.
     * Return JSON response.
     */
    public function getAlamatToko($idToko)
    {
        $toko = $this->getAllToko()->where('id', $idToko);
        $aktivasi = $this->getIncLastAktivasi($idToko);
        $value = $toko->values();

        $data = collect($value->get(0));
        $data->put('aktivasi', $aktivasi);

        return response()->json([$data]);
    }

    /**
     * Close SPO.
     */
    public function closeSpo(Request $request, $idToko): \Illuminate\Http\RedirectResponse
    {
        $produk = $this->formProdukController->collectProduk($request);
        // $produk = FormProdukController::collectProduk($request);
        $produk->map(function ($item) use ($idToko) {
            if ($item['jumlah'] > 0) {
                return ClosedSPO::create(
                    [
                        'id_user' => auth()->user()->id,
                        'id_produk' => $item['idProduk'],
                        'id_aktivasi' => $this->getAktivasi($idToko)->last()->id,
                        'tanggal_close_spo' => Carbon::now()->format('Y-m-d'),
                        'jumlah_produk' => $item['jumlah'],
                    ]
                );
            }
        });

        AktivasiSPO::where('id_toko', $this->getAktivasi($idToko)->last()->id)->update(['is_close' => 1]);

        return redirect('/spo/penjualan_spo/' . $idToko);
    }

    public function getClosedSpo(int $idToko): Collection
    {
        $closed = DB::select("SELECT c.tanggal_close_spo, c.id_produk, p.nama_produk, c.jumlah_produk, aspo.aktivasi, aspo.is_close, aspo.is_cash, t.id 'id_toko', t.nama_toko
        FROM closed_spo c
        JOIN aktivasi_spo aspo ON aspo.id = c.id_aktivasi
        JOIN products p ON p.id_produk = c.id_produk
        JOIN toko_spo t ON t.id = aspo.id_toko
        WHERE t.id = ?", [$idToko]);

        $cleanedData = collect($closed)->map(function ($item) {
            return collect($item)->mapWithKeys(function ($value, $key) {
                $cleanedKey = ltrim($key, '+');
                return [$cleanedKey => $value];
            })->all();
        });

        return new Collection($cleanedData);
    }

    public function listSpoClose(): View
    {
        $tokoClosedSpo = $this->getPenjualanSPOClose(auth()->user()->id);
        // dd($this->getClosedSpo(110));
        return view('pages.spo.daftarCloseSpo', compact('tokoClosedSpo'));
    }

}
