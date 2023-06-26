<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;
    protected $table = 'toko';
    protected $fillable = [
        'id_routing',
        'id_kunjungan',
        'nama_toko',
        'latitude',
        'longitude',
        'mapping'

    ];
}
