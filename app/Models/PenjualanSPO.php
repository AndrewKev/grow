<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanSPO extends Model
{
    use HasFactory;
    protected $table = 'penjualan_spo';
    protected $fillable = [
        'id_user',
        'id_produk',
        'id_distrik',
        'id_toko',
        'jenis_spo',
        'nomor_spo',
        'id_kunjungan',
        'jumlah_produk',
        'emp',
        'id_keterangan',
        'id_foto',
        'latitude',
        'longitude',
        'created_at',
    ];
}
