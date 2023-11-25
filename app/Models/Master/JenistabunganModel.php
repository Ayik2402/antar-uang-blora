<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenistabunganModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "master.jenis_tabungan";
    protected $fillable = [
        'nama',
        'status'
    ];
}
