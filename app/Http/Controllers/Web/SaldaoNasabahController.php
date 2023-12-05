<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Imports\SaldoImport;
use App\Models\Public\NasabahModel;
use App\Models\Public\SaldoNasabahModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

    function import(Request $r) {
        DB::table('history_update_saldo')->insert([
            'type' => 0,
            'waktu' => date('Y-m-d H:i:s'),
            'updater' => Auth::user()->uuid,
        ]);
        if ($r->hasFile('import_file')) {
            $reqarr = Excel::toCollection(new SaldoImport, $r->file('import_file'));
            $reknotfwnd = [];
            if (count($reqarr) > 0) {
                unset($reqarr[0][0]);
                foreach ($reqarr[0] as $k => $v) {
                    $nasabah = NasabahModel::where('norek', $v[0])->first();
                    if ($nasabah) {
                        SaldoNasabahModel::updateOrCreate(['nasabah_id'=>$nasabah->uuid],[
                            'no_rekening' => $v[0],
                            'nasabah_id' => $nasabah->uuid,
                            'last_update' => date('Y-m-d H:i:s'),
                            'saldo' => $v[1],
                            'mengendap' => $v[2],
                            'updater' => Auth::user()->uuid,
                        ]);
                    } else {
                        $reknotfwnd[] = $v[0];
                    }
                }
                if (count($reknotfwnd) > 0) {
                    return redirect('/saldo')->with('info', 'Nomor rekening berikut tidak terdaftar dalam sistem: '. implode(', ', $reknotfwnd));
                }
                return redirect('/saldo')->with('success', 'Berhasil import saldo');
            }
        }
        return redirect('/saldo')->with('error', 'Gagal import saldo');
    }
}
