<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestGudangKecil extends Model
{
    use HasFactory;
    protected $table = 'request_gudang_kecil';
    protected $fillable = [
        'id_user',
        'id_produk',
        'tanggal_po',
        'stok',
        'harga_stok',
        'sample',
        'deadline_kirim',
        'catatan',
        'konfirmasi',
        'tgl_konfirmasi',
        'konfirmasi2',
        'tgl_konfirmasi2'
    ];
}
