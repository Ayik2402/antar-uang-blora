<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Public\SaldoNasabahModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuantransferController extends Controller
{
    public function datapengajuantramsfer(Request $request)
    {
        $data['start'] = $request->start;
        $data['end'] = $request->end;

        if (!$request->start) {
            $data['start'] = Carbon::now()->subDays(7)->format('Y-m-d');
        }
        if (!$request->end) {
            $data['end'] = Carbon::now()->format('Y-m-d');
        }
        $data['tfsesama'] = DB::table('public.transfer_antar_rekening')
            ->leftJoin('public.data_nasabah', 'public.data_nasabah.uuid', '=', 'public.transfer_antar_rekening.nasabah_id')
            ->whereNull('public.transfer_antar_rekening.deleted_at')
            ->whereDate('public.transfer_antar_rekening.created_at', '>=', $data['start'])
            ->whereDate('public.transfer_antar_rekening.created_at', '<=', $data['end'])
            // ->whereIn('public.transfer_antar_rekening.status_transaksi', [1, 2])
            ->get(['public.transfer_antar_rekening.*', 'public.data_nasabah.nama as nasabah', 'public.data_nasabah.norek']);
        $data['tfbnk'] = DB::table('public.transfer_antar_bank')
            ->leftJoin('public.data_nasabah', 'public.data_nasabah.uuid', '=', 'public.transfer_antar_bank.nasabah_id')
            ->leftJoin('master.daftar_bank', 'master.daftar_bank.uuid', '=', 'public.transfer_antar_bank.bank_id')
            ->whereNull('public.transfer_antar_bank.deleted_at')
            ->whereDate('public.transfer_antar_bank.created_at', '>=', $data['start'])
            ->whereDate('public.transfer_antar_bank.created_at', '<=', $data['end'])

            // ->whereIn('public.transfer_antar_bank.status_transaksi', [1, 2])
            ->get(['public.transfer_antar_bank.*', 'public.data_nasabah.nama as nasabah', 'master.daftar_bank.bank', 'public.data_nasabah.norek']);

        // return $data;
        return view('pages.pengajuan.transfer', $data);
    }

    public function updatetransaksinasabah(Request $request)
    {
        if ($request->status == 2) {
            if ($request->type == 0) {
                $nsb = DB::table('public.transfer_antar_rekening')
                    ->where('public.transfer_antar_rekening.uuid', $request->uuid)->first();
            }
            if ($request->type == 1) {
                $nsb = DB::table('public.transfer_antar_bank')
                    ->where('public.transfer_antar_bank.uuid', $request->uuid)->first();
            }
            if ($nsb) {
                $sld = SaldoNasabahModel::where('nasabah_id', $nsb->nasabah_id)->first();
                $trf = $nsb->nominal;
                if ($request->type == 1) {$trf = $nsb->jumlah;}
                if ($sld->saldo<$trf) {
                    return response()->json([
                        'msg' => 'Saldo tidak mencukupi'
                    ]);
                } else {
                    SaldoNasabahModel::where('nasabah_id', $nsb->nasabah_id)->update(['saldo'=>($sld->saldo-$trf)]);
                }
            }
        }
        if ($request->type == 0) {
            DB::table('public.transfer_antar_rekening')
                ->where('public.transfer_antar_rekening.uuid', $request->uuid)
                ->update([
                    'status_transaksi' => $request->status
                ]);

            return response()->json([
                'msg' => 'Data transaksi nasabah berhasil'
            ]);
        }
        if ($request->type == 1) {
            DB::table('public.transfer_antar_bank')
                ->where('public.transfer_antar_bank.uuid', $request->uuid)
                ->update([
                    'status_transaksi' => $request->status
                ]);

            return response()->json([
                'msg' => 'Data transaksi nasabah berhasil'
            ]);
        }
    }
}
