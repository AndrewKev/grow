<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClosedSPO extends Model
{
    use HasFactory;

    protected $table = 'closed_spo';

    protected $fillable = [
        'id_user',
        'id_produk',
        'id_aktivasi',
        'tanggal_close_spo',
        'jumlah_produk',
    ];
}
