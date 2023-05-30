<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan_laku_cash';
    protected $fillable = [
        'id_user',
        'id_produk',
        'id_distrik',
        'id_routing',
        'id_toko',
        'id_kunjungan',
        'jumlah_produk',
        'emp',
        'id_keterangan',
        // 'id_foto',
        'latitude',
        'longitude',
        'created_at',
    ];
}
