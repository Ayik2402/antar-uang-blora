<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NasabahModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "public.data_nasabah";
    protected $fillable = [
        'tabungan_id',
        'noregister',
        'norek',
        'nama',
        'email',
        'no_hp',
        'type_nasabah',
        'aktivasi',
        'alamat_ktp',
        'alamat_domisili',
        'same_domisili',
        'tag_bpr',
    ];
}
