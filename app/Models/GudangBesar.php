<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangBesar extends Model
{
    use HasFactory;
    protected $table = 'gudang_besar';
    protected $fillable = [
        'stok',
        'sample',
        'harga_stok',
        'retur',
        'created_at',
    ];
}
