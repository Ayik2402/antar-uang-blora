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
        $data['tfsesama'] = DB::table('transfer_antar_rekening')
            ->leftJoin('data_nasabah', 'data_nasabah.uuid', '=', 'transfer_antar_rekening.nasabah_id')
            ->whereNull('transfer_antar_rekening.deleted_at')
            ->whereDate('transfer_antar_rekening.created_at', '>=', $data['start'])
            ->whereDate('transfer_antar_rekening.created_at', '<=', $data['end'])
            ->orderBy('transfer_antar_rekening.status_transaksi', 'ASC')
            // ->whereIn('transfer_antar_rekening.status_transaksi', [1, 2])
            ->get(['transfer_antar_rekening.*', 'data_nasabah.nama as nasabah', 'data_nasabah.norek']);

        // return $data;
        $data['tfbnk'] = DB::table('transfer_antar_bank')
            ->leftJoin('data_nasabah', 'data_nasabah.uuid', '=', 'transfer_antar_bank.nasabah_id')
            ->leftJoin('daftar_bank', 'daftar_bank.uuid', '=', 'transfer_antar_bank.bank_id')
            ->whereNull('transfer_antar_bank.deleted_at')
            ->whereDate('transfer_antar_bank.created_at', '>=', $data['start'])
            ->whereDate('transfer_antar_bank.created_at', '<=', $data['end'])
            ->orderBy('transfer_antar_bank.status_transaksi', 'ASC')
            // ->whereIn('transfer_antar_bank.status_transaksi', [1, 2])
            ->get(['transfer_antar_bank.*', 'data_nasabah.nama as nasabah', 'daftar_bank.bank', 'data_nasabah.norek']);

        // return $data;
        return view('pages.pengajuan.transfer', $data);
    }

    public function updatetransaksinasabah(Request $request)
    {
        if ($request->status == 2) {
            if ($request->type == 0) {
                $nsb = DB::table('transfer_antar_rekening')
                    ->where('transfer_antar_rekening.uuid', $request->uuid)->first();
            }
            if ($request->type == 1) {
                $nsb = DB::table('transfer_antar_bank')
                    ->where('transfer_antar_bank.uuid', $request->uuid)->first();
            }
            if ($nsb) {
                $sld = SaldoNasabahModel::where('nasabah_id', $nsb->nasabah_id)->first();
                $trf = $nsb->nominal;
                if ($request->type == 1) {
                    $trf = $nsb->jumlah;
                }
                if ($sld->saldo < $trf) {
                    return response()->json([
                        'msg' => 'Saldo tidak mencukupi'
                    ]);
                } else {
                    SaldoNasabahModel::where('nasabah_id', $nsb->nasabah_id)->update(['saldo' => ($sld->saldo - $trf)]);
                }
            }
        }
        if ($request->type == 0) {
            DB::table('transfer_antar_rekening')
                ->where('transfer_antar_rekening.uuid', $request->uuid)
                ->update([
                    'status_transaksi' => $request->status
                ]);

            return response()->json([
                'msg' => 'Data transaksi nasabah berhasil'
            ]);
        }
        if ($request->type == 1) {
            DB::table('transfer_antar_bank')
                ->where('transfer_antar_bank.uuid', $request->uuid)
                ->update([
                    'status_transaksi' => $request->status
                ]);

            return response()->json([
                'msg' => 'Data transaksi nasabah berhasil'
            ]);
        }
    }
}
