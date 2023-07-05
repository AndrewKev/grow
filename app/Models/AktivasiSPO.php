<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivasiSPO extends Model
{
    use HasFactory;
    protected $table = 'aktivasi_spo';
    protected $fillable = [
        'id_toko',
        'aktivasi',
        'is_close',
        'is_cash',
    ];
}
