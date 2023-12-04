<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengajuantransferController extends Controller
{
    public function datapengajuantramsfer(Request $request)
    {
        return view('pages.pengajuan.transfer');
    }
}
