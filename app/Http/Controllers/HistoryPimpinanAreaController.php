<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HistoryStokPimpinanArea;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class HistoryPimpinanAreaController extends Controller
{
    //HISTORY REQUEST PIMPINAN AREA
    public function admin2RequestStok(Request $request, $konfirmasiPA, $konfirmasiGB, $konfirmasiHA, $hargaStok){
        for($i = 0; $i < sizeof($request->id_produk); $i++) {
            $produk = Product::where('id_produk', $request->id_produk[$i])->first(); // Ambil data produk berdasarkan id_produk saat ini
            $hargaStok = $produk->harga_toko * (int) $request->produk[$i]; // Hitung harga_stok berdasarkan harga_toko produk saat ini
            $history = HistoryStokPimpinanArea::create(
                [
                    'tanggal' => Carbon::now(),
                    'nama_admin' => auth()->user()->nama,
                    'nama_produk'=> $request->nama_produk[$i],
                    'req_stok' => (int) $request->produk[$i],
                    'tanggal_po' => Carbon::now(),
                    'harga_stok' => $hargaStok,
                    'deadline_kirim' =>Carbon::now()->addDays(2),
                    'catatan' => $request->catatan,
                    'konfirmasi' => $konfirmasiPA,
                    'konfirmasi2' => $konfirmasiGB,
                    'konfirmasi3' => $konfirmasiHA,
                    'keterangan' => 'Admin Request Stok',
                ]
            );
        }
    }

    public function getReqKonfirmasiPA($id_user) {
        $data = DB::select("SELECT r.id_user, u.nama, r.id_produk, p.nama_produk, r.tanggal_po, r.stok, r.harga_stok, r.deadline_kirim, r.catatan, r.konfirmasi, r.tgl_konfirmasi, r.konfirmasi2, r.tgl_konfirmasi2
                            FROM request_gudang_kecil r 
                            JOIN products p ON p.id_produk = r.id_produk 
                            JOIN users u ON r.id_user = u.id 
                            WHERE r.konfirmasi = 1 AND r.id_user = $id_user;");
        return $data;
    }
    public function konfirmasiStokPA($id_user){
        $dataKonfirmasi = $this->getReqKonfirmasiPA($id_user);
        foreach ($dataKonfirmasi as $data) {
            $history = HistoryStokPimpinanArea::create(
                [
                    'tanggal' => Carbon::now(),
                    'nama_admin' => $data->nama,
                    'nama_produk'=> $data->nama_produk,
                    'req_stok' => $data->stok,
                    'tanggal_po' => $data->tanggal_po,
                    'harga_stok' => $data->harga_stok,
                    'deadline_kirim' =>$data->deadline_kirim,
                    'catatan' => $data->catatan,
                    'konfirmasi' => 1,
                    'konfirmasi2' =>0,
                    'tanggal_konfirm' => $data->tgl_konfirmasi,
                    'keterangan' => 'konfirmasi PA',
                ]
            );
        }

        return $history;
    }

    public function getReqKonfirmasiGB($id_user) {
        $data = DB::select("SELECT r.id_user, u.nama, r.id_produk, p.nama_produk, r.tanggal_po, r.stok, r.harga_stok, r.deadline_kirim, r.catatan, r.konfirmasi, r.tgl_konfirmasi, r.konfirmasi2, r.tgl_konfirmasi2, r.konfirmasi3, r.tgl_konfirmasi3, r.catatan_pim_area
                            FROM request_gudang_kecil r 
                            JOIN products p ON p.id_produk = r.id_produk 
                            JOIN users u ON r.id_user = u.id 
                            WHERE ((r.konfirmasi2 = 1) OR (r.konfirmasi = 0 AND r.konfirmasi2 = 1 )) AND r.id_user = $id_user;");
        return $data;
    }

    
    public function konfirmasiStokGB($id_user)
    {
        $dataKonfirmasi = $this->getReqKonfirmasiGB($id_user);
        foreach ($dataKonfirmasi as $data) {
            $keterangan = '';
            
            if ($data->konfirmasi == 0 && $data->konfirmasi2 == 1) {
                $keterangan = 'konfirmasi GB, tanpa PA';
            } else {
                $keterangan = 'konfirmasi GB dan PA';
            }

            $history = HistoryStokPimpinanArea::create([
                'tanggal' => Carbon::now(),
                'nama_admin' => $data->nama,
                'nama_produk' => $data->nama_produk,
                'req_stok' => $data->stok,
                'tanggal_po' => $data->tanggal_po,
                'harga_stok' => $data->harga_stok,
                'deadline_kirim' => $data->deadline_kirim,
                'catatan' => $data->catatan,
                'catatan_pim_area' =>$data->catatan_pim_area,
                'konfirmasi' => $data->konfirmasi,
                'konfirmasi2' => $data->konfirmasi2,
                'konfirmasi3' => $data->konfirmasi3,
                'tanggal_konfirm' => $data->tgl_konfirmasi,
                'tanggal_konfirm2' => $data->tgl_konfirmasi2,
                'tanggal_konfirm3' => $data->tgl_konfirmasi3,
                'keterangan' => $keterangan,
            ]);
        }

        return $history;
    }

    public function getRequestStokHA($id_user) {
        $data = DB::select("SELECT r.id_user, u.nama, r.id_produk, p.nama_produk, r.tanggal_po, r.stok, r.harga_stok, r.deadline_kirim, r.catatan, r.konfirmasi, r.tgl_konfirmasi, r.konfirmasi2, r.tgl_konfirmasi2, r.konfirmasi3,
                            FROM request_gudang_kecil r 
                            JOIN products p ON p.id_produk = r.id_produk 
                            JOIN users u ON r.id_user = u.id 
                            WHERE r.konfirmasi3 = 0 AND r.id_user = $id_user;");
        return $data;
    }
    public function requestStokHA($id_user)
    {
        $dataKonfirmasi = $this->getRequestStokHA($id_user);
        foreach ($dataKonfirmasi as $data) {
            $history = HistoryStokPimpinanArea::create([
                'tanggal' => Carbon::now(),
                'nama_admin' => $data->nama,
                'nama_produk' => $data->nama_produk,
                'req_stok' => $data->stok,
                'tanggal_po' => $data->tanggal_po,
                'harga_stok' => $data->harga_stok,
                'deadline_kirim' => $data->deadline_kirim,
                'catatan' => $data->catatan,
                'konfirmasi' => $data->konfirmasi,
                'konfirmasi2' => $data->konfirmasi2,
                'konfirmasi3' => 0,
                'tanggal_konfirm' => $data->tgl_konfirmasi,
                'tanggal_konfirm2' => $data->tgl_konfirmasi2,
                'keterangan' => 'GB req HA',
            ]);
        }

        return $history;
    }

    public function getKonfirmasiReqHA($id_user) {
        $data = DB::select("SELECT r.id_user, u.nama, r.id_produk, p.nama_produk, r.tanggal_po, r.stok, r.harga_stok, r.deadline_kirim, r.catatan, r.konfirmasi, r.tgl_konfirmasi, r.konfirmasi2, r.tgl_konfirmasi2, r.konfirmasi3, r.tgl_konfirmasi3, r.catatan_pim_area
                            FROM request_gudang_kecil r 
                            JOIN products p ON p.id_produk = r.id_produk 
                            JOIN users u ON r.id_user = u.id 
                            WHERE r.konfirmasi3 = 1 AND r.id_user = $id_user;");
        return $data;
    }

    public function konfirmasiReqHA($id_user)
    {
        $dataKonfirmasi = $this->getKonfirmasiReqHA($id_user);
        $history = null;
        foreach ($dataKonfirmasi as $data) {
            $history = HistoryStokPimpinanArea::create([
                'tanggal' => Carbon::now(),
                'nama_admin' => $data->nama,
                'nama_produk' => $data->nama_produk,
                'req_stok' => $data->stok,
                'tanggal_po' => $data->tanggal_po,
                'harga_stok' => $data->harga_stok,
                'deadline_kirim' => $data->deadline_kirim,
                'catatan' => $data->catatan,
                'catatan_pim_area' =>$data->catatan_pim_area,
                'konfirmasi' => $data->konfirmasi,
                'konfirmasi2' => $data->konfirmasi2,
                'konfirmasi3' => 1,
                'tanggal_konfirm' => $data->tgl_konfirmasi,
                'tanggal_konfirm2' => $data->tgl_konfirmasi2,
                'tanggal_konfirm3' => $data->tgl_konfirmasi3,
                'keterangan' => 'HA Konfirmasi',
            ]);
        }

        return $history;
    }

}
