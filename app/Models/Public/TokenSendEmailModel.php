<?php

namespace App\Models\Public;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenSendEmailModel extends Model
{
    use HasFactory;
    protected $table = "token_send_email";
    protected $fillable = [
        'nasabah_id',
        'token',
        'hingga',
        'uuid'
    ];
}
