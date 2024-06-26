<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BiayatransferModel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "biaya_transfer";
    // protected $table = "master.biaya_transfer";
    protected $fillable = [
        'nominal',
        'uuid'
    ];
}
