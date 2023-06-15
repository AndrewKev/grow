<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangKecil extends Model
{
    use HasFactory;
    protected $table = 'gudang_kecil';
    protected $fillable = [
        'id_user',
        'tanggal_po',
        'nomor_po',
        'stok',
        'sample',
        'harga_stok',
        'deadline_kirim',
        'catatan',
        'created_at',
    ];
}
