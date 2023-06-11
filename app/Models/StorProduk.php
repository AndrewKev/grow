<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorProduk extends Model
{
    use HasFactory;
    protected $table = 'stor_produk';
    protected $fillable = [
        'id_user',
        'id_produk',
        'tanggal_stor',
        'tanggal_stor_uang',
        'stok_awal',
        'terjual',
        'sisa_stok',
        'harga_produk',
        'total_harga',
        'id_rincian_uang'
    ];
}
