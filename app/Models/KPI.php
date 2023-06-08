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
    ];
}
