<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokoSPO extends Model
{
    use HasFactory;
    protected $table = 'toko_spo';
    protected $fillable = [
        'nama_toko',
        'alamat',
        'id_distrik',
        'ws',
        'telepon',
        'latitude',
        'longitude',

    ];
}
