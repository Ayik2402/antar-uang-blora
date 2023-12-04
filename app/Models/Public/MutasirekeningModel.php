<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MutasirekeningModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "public.mutasi_rekening";
    protected $fillable = [
        'nasabah_id',
        'tanggal',
        'kode',
        'keterangan',
        'debit',
        'kredit',
        'saldo',
    ];
}
