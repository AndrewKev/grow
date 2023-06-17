<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPI extends Model
{
    use HasFactory;
    protected $table = 'kpi';
    protected $fillable = [
        'id_user',
        'call_made',
        'emp',
        'volume',
        'io',
        'ro',
        'roc',
        'greenland',
        'acv_call_made',
        'acv_emp',
        'acv_volume',
        'acv_io',
        'acv_ro',
        'acv_roc',
        'acv_greenland',
        // 'efektivitas',
    ];
}
