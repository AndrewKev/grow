<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestBarang extends Model
{
    use HasFactory;

    protected $table = 'request_sales';
    protected $fillable = [
        'id_user',
        'id_produk',
        'jumlah',
        'tanggal_request',
        'konfirmasi',
    ];
}
