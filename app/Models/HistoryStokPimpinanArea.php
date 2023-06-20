<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryStokPimpinanArea extends Model
{
    use HasFactory;
    protected $table = 'history_stok_pimpinan_area';
    protected $fillable = [
        'nama_admin',
        'nama_produk',
        'req_stok',
        'harga_stok',
        'catatan',
        'konfirmasi',
        'konfirmasi2',
        'konfirmasi3',
        'tanggal',
        'tanggal_po',
        'deadline_kirim',
        'tanggal_konfirm',
        'tanggal_konfirm2',
        'tanggal_konfirm3',
        'tgl_req_gb',
        'keterangan'
    ];
}
