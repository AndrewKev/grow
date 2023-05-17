<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarryProduk extends Model
{
    use HasFactory;
    protected $table = 'carry_produk';
    protected $fillable = [
        'id_user',
        'id_produk',
        'tanggal_carry',
        'stok_dibawa',
    ];
}
