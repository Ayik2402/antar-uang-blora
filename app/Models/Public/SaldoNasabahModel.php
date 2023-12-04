<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoNasabahModel extends Model
{
    use HasFactory;
    protected $table = "public.saldo_nasabah";
    protected $fillable = [
        'no_rekening',
        'nasabah_id',
        'last_update',
        'saldo',
        'mengendap',
    ];
}
