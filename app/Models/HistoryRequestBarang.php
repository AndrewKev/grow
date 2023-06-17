<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryRequestBarang extends Model
{
    use HasFactory;
    protected $table = 'history_request_sales_stor_produk';
    protected $fillable = [
        'tanggal',
        'nama_sales',
        'nama_produk',
        'stok_awal',
        'terjual',
        'sisa_stok',
        'konfirmasi_admin',
        'keterangan',
    ];
}
