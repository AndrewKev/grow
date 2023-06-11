<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestStorBarang extends Model
{
    use HasFactory;
    protected $table = 'request_stor_barang';
    protected $fillable = [
        'id_user',
        'id_produk',
        'tanggal_stor_barang',
        'tanggal_stor_uang',
        'stok_awal',
        'sisa_stok',
        'terjual',
        'harga_produk',
        'total_harga',
        'konfirmasi',
        'konfirmasi2',
        'id_rincian_uang',
    ];
}
