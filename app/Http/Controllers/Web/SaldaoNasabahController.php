<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Public\NasabahModel;
use App\Models\Public\SaldoNasabahModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SaldaoNasabahController extends Controller
{
    function index() {
        $data['nasabah'] = NasabahModel::leftJoin('master.jenis_tabungan as j', 'j.uuid', '=', 'data_nasabah.tabungan_id')
            ->get(['j.nama as tabungan', 'data_nasabah.*']);
        $data['saldo'] = SaldoNasabahModel::select(
                'saldo_nasabah.*',
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
            )
            ->join('data_nasabah as n', 'n.uuid', '=', 'saldo_nasabah.nasabah_id')
            ->get();
        
        return view('pages.saldo.saldo', $data);
    }

    function store(Request $r) {
        // return $r->all();
        SaldoNasabahModel::updateOrCreate(['nasabah_id'=>$r->nasabah_id],[
            'no_rekening' => $r->norek,
            'nasabah_id' => $r->nasabah_id,
            'last_update' => date('Y-m-d H:i:s'),
            'saldo' => $r->saldo,
            'mengendap' => $r->mengendap,
            'updater' => Auth::user()->uuid,
        ]);
        return redirect('/saldo');
    }

    function import() {
        
    }
}
