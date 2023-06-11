<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    use HasFactory;
    protected $table = 'foto';
    protected $fillable = [
        'id_foto',
        'nama_foto',
        'id_user',
        'tanggal',
        'created_at',
    ];
}
