<?php

namespace App\Http\Controllers;

use App\Models\KPI;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

use Carbon\Carbon;

class KPIController extends Controller
{
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
     * Hitung produk yang dijual.
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
     * Hitung ACV Call Made.
     * Return float.
     */
    public function countAcvCallMade() {
        $callMade = $this->getPenjualan(Carbon::now()->format('Y-m-d'))->count();

        return $callMade / 35 * 100;
    }

    /**
     * Hitung ACV EMP.
     * Return float.
     */
    public function countAcvEmp() {
        $emp = $this->getEmp();

        return $emp / 35 * 100;
    }

    /**
     * Hitung ACV Volume.
     * Return float.
     */
    public function countAcvVolume() {
        $volume = $this->getVolume();

        return $volume / 150 * 100;
    }

    /**
     * Hitung ACV IO.
     * Return float.
     */
    public function countAcvIO() {
        $io = $this->getIO();

        return $io / 5 * 100;
    }

    /**
     * Hitung ACV RO.
     * Return float.
     */
    public function countAcvRO() {
        $ro = $this->getRO();

        return $ro / 15 * 100;
    }

    /**
     * Hitung ACV ROC.
     * Return float.
     */
    public function countAcvROC() {
        $roc = $this->getROC();

        return $roc * (-2);
    }

    /**
     * Hitung ACV Greenland.
     * Return float.
     */
    public function countAvcGreenland() {
        $greenland = $this->getGreenland();

        return $greenland / 10 * 100;
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
                'acv_call_made' => $this->countAcvCallMade(),
                'acv_emp' => $this->countAcvEmp(),
                'acv_volume' => $this->countAcvVolume(),
                'acv_io' => $this->countAcvIO(),
                'acv_ro' => $this->countAcvRO(),
                'acv_roc' => $this->countAcvROC(),
                'acv_greenland' => $this->countAvcGreenland(),
            ]
        );
    }

    /**
     * Get KPI untuk per minggu.
     * Return Collection.
     */
    public function getKPI() {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();

        $data = DB::table('kpi')
        ->whereBetween('created_at', [$startDate, $endDate])
        ->where('id_user', $this->getUser())
        ->get();

        $collection = collect($data);

        return $collection;
    }

    /**
     * Get efektivitas untuk per minggu.
     * Return Collection.
     */
    public function getWeeklyEv() {
        $collection = $this->getKPI();
        $tempTotalEvPerDay = collect();
        $totalEvPerDay = collect();

        foreach($collection as $data) {
            $tempTotalEvPerDay->push($data->acv_call_made);
            $tempTotalEvPerDay->push($data->acv_emp);
            $tempTotalEvPerDay->push($data->acv_volume);
            $tempTotalEvPerDay->push($data->acv_io);
            $tempTotalEvPerDay->push($data->acv_ro);
            $tempTotalEvPerDay->push($data->acv_roc);
            $tempTotalEvPerDay->push($data->acv_greenland);

            $totalEvPerDay->push($tempTotalEvPerDay->sum() / 6);
            $tempTotalEvPerDay = collect();
        }

        return $totalEvPerDay;
    }

    /**
     * Get efektivitas untuk per minggu
     * dengan key hari dan value nilai efektivitas.
     * Return Collection.
     */
    public function getWeeklyEvDay() {
        $collection = $this->getKPI();
        $ev = $this->getWeeklyEv();
        $days = collect();

        foreach ($collection as $data) {
            $dayData = Carbon::parse($data->created_at);
            $dayData->settings(['formatFunction' => 'translatedFormat']); // translate nama hari
            $days->push($dayData->format('l'));
        }
        $combinedDayName = $days->combine($ev);

        return $combinedDayName;
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
        // dd($this->countAvcGreenland());
        // dd($this->getKPI());
        // dd($this->getWeeklyEv());
        // dd($this->getWeeklyEvDay());
    }
}
