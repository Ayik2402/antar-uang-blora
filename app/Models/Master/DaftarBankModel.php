<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DaftarBankModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "master.daftar_bank";
    protected $fillable = [
        'bank',
        'status'
    ];
}
