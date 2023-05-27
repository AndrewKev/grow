<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keterangan extends Model
{
    use HasFactory;
    protected $table = 'keterangan';
    protected $fillable = [
        'keterangan',
        'id_user',
        'tanggal',
        'created_at',
    ];
}
