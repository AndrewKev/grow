<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryRequestPenjualan extends Model
{
    use HasFactory;
    protected $table = 'history_request_sales_stor_penjualan';
    protected $fillable = [
        'tanggal',
        'nama_sales',
        'nama_produk',
        'terjual',
        'total_harga',
        'konfirmasi_admin',
        'keterangan',
    ];
}
