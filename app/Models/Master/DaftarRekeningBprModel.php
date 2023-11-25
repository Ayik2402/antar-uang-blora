<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DaftarRekeningBprModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "master.daftar_rekening_bpr";
    protected $fillable = [
        'bank',
        'norek',
        'atas_nama',
        'status'
    ];
}
