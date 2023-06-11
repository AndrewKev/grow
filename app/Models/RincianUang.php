<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RincianUang extends Model
{
    use HasFactory;
    protected $table = 'rincian_uang';
    protected $fillable = [
            'id_rincian_uang',
            'id_user',
            'tanggal_masuk',
            'seratus_ribu',
            'lima_puluh_ribu',
            'dua_puluh_ribu',
            'sepuluh_ribu',
            'lima_ribu',
            'dua_ribu',
            'seribu',
            'seribu_koin',
            'lima_ratus_koin',
            'dua_ratus_koin',
            'seratus_koin',
        ];
    }
    
