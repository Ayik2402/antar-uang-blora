<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermohonanRekeningTransferModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'uuid',
        'bank_id',
        'user_id',
        'norek',
        'atas_nama',
        'status'
    ];
    protected $table = "permohonan_rekening_transfer";
}
