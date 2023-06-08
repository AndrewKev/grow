<?php

namespace App\Http\Controllers;

use App\Models\KPI;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

use Carbon\Carbon;

class KPIController extends Controller
{
    protected $callMadeTarget = 35;
    protected $empTarget = 35;
    protected $volumeTarget = 150;
    protected $ioTarget = 5;
    protected $roTarget = 15;
    protected $rocTarget = 0;
    protected $greenlandTarget = 10;

    /**
     * Menampilkan penjualan toko tanggal tertentu.
     * Return Collection.
     */
    public function getPenjualan($tanggal) {
        $user = $this->getUser();
        $list = DB::select("SELECT * FROM penjualan_laku_cash
                            WHERE id_user = $user
                            AND created_at BETWEEN '$tanggal 00:00:00' AND '$tanggal 23:59:59'
                            ");
        // return $list;
        $collection = collect($list);
        $grouped = $collection->groupBy('id_toko');
        
        return $grouped;
    }

    /**
     * Hitung volume yang didapat.
     * Return int.
     */
    public function getVolume() {
        $volume = collect([]);
        $datas = $this->getpenjualan(Carbon::now()->format('Y-m-d'))->all();

        foreach ($datas as $data) {
            for ($i=0; $i < $data->count(); $i++) { 
                $volume->push($data->all()[$i]->jumlah_produk);
            }
        }

        // return $datas['440']->all()[0]->jumlah_produk;
        // return $datas;
        return $volume->sum();
    }

    /**
     * Hitung EMP yang didapat.
     * Return int.
     */
    public function getEmp() {
        $emp = collect();
        $datas = $this->getpenjualan(Carbon::now()->format('Y-m-d'))->all();
        $keys = $this->getpenjualan(Carbon::now()->format('Y-m-d'))->keys();

        foreach ($datas as $data) {
            $emp->push(['emp' => $data->all()[0]->emp]);
        }

        $combinedKeyEmp = $keys->combine($emp->all());

        // return $keys;
        // return $datas;
        // return $datas['440']->all()[0]->emp;
        // return $emp->all();
        // return $emp->where('emp', '!=', '');
        return $combinedKeyEmp->where('emp', '!=', '')->count();
    }

    /**
     * Hitung IO yang didapat.
     * Return int.
     */
    public function getIO() {
        $io = collect();
        $datas = $this->getpenjualan(Carbon::now()->format('Y-m-d'))->all();
        $keys = $this->getpenjualan(Carbon::now()->format('Y-m-d'))->keys();

        foreach ($datas as $data) {
            $io->push(['id_kunjungan' => $data->all()[0]->id_kunjungan]);
        }

        $combinedKeyIO = $keys->combine($io->all());

        return $combinedKeyIO->where('id_kunjungan', 'IO')->count();
    }

    /**
     * Hitung RO yang didapat.
     * Return int.
     */
    public function getRO() {
        $ro = collect();
        $datas = $this->getpenjualan(Carbon::now()->format('Y-m-d'))->all();
        $keys = $this->getpenjualan(Carbon::now()->format('Y-m-d'))->keys();

        foreach ($datas as $data) {
            $ro->push(['id_kunjungan' => $data->all()[0]->id_kunjungan]);
        }

        $combinedKeyRO = $keys->combine($ro->all());

        return $combinedKeyRO->where('id_kunjungan', 'RO')->count();
    }

    /**
     * Hitung ROC yang didapat.
     * Return int.
     */
    public function getROC() {
        $roc = collect();
        $datas = $this->getpenjualan(Carbon::now()->format('Y-m-d'))->all();
        $keys = $this->getpenjualan(Carbon::now()->format('Y-m-d'))->keys();

        foreach ($datas as $data) {
            $roc->push(['id_kunjungan' => $data->all()[0]->id_kunjungan]);
        }

        $combinedKeyROC = $keys->combine($roc->all());

        return $combinedKeyROC->where('id_kunjungan', 'ROC')->count();
    }

    /**
     * Menampilkan toko dan produk yang dijual.
     * Return int.
     */
    public function getGreenland() {
        $collectionProduk = collect();
        $keysProduk = collect();
        $sum = collect();

        $datas = $this->getpenjualan(Carbon::now()->format('Y-m-d'))->all();
        $keysToko = $this->getpenjualan(Carbon::now()->format('Y-m-d'))->keys();

        foreach ($datas as $data) {
            $jumlahPerToko = collect();
            for ($i=0; $i < $data->count(); $i++) { 
                $jumlahPerToko->push($data->all()[$i]->jumlah_produk);
            }
            $sum->push(['jumlah' => $jumlahPerToko->sum()]);
        }

        $combinedKeyToko = $keysToko->combine($sum->all());

        return $combinedKeyToko->where('jumlah', '>=', 10)->count();
    }


    /**
     * Get user id yg login.
     */
    public function getUser() {
        return auth()->user()->id;
    }

    /**
     * Insert data ke table KPI.
     */
    public function insertKPI() {
        KPI::create(
            [
                'id_user' => $this->getUser(),
                'call_made' => $this->getPenjualan(Carbon::now()->format('Y-m-d'))->count(),
                'emp' => $this->getEmp(),
                'volume' => $this->getVolume(),
                'io' => $this->getIO(),
                'ro' => $this->getRO(),
                'roc' => $this->getROC(),
                'greenland' => $this->getGreenland(),
            ]
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd($this->getPenjualan(Carbon::now()->format('Y-m-d'))->all());
        // dd($this->getUser());
        // dd($this->getVolume());
        // dd($this->getEmp());
        // dd($this->getIO());
        // dd($this->getRO());
        // dd($this->getROC());
        // dd($this->getTokoJumlahJual());
    }
}
