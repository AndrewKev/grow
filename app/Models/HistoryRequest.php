<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryRequest extends Model
{
    use HasFactory;
    protected $table = 'history_request_stok_sales';
    protected $fillable = [
        'tanggal_request',
        'nama_sales',
        'nama_produk',
        'jumlah',
        'konfirmasi_admin',
        'konfirmasi_sales',
    ];
}
