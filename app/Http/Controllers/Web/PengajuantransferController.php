<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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
            ->orderBy('public.transfer_antar_rekening.status_transaksi', 'ASC')
            // ->whereIn('public.transfer_antar_rekening.status_transaksi', [1, 2])
            ->get(['public.transfer_antar_rekening.*', 'public.data_nasabah.nama as nasabah', 'public.data_nasabah.norek']);

        // return $data;
        $data['tfbnk'] = DB::table('public.transfer_antar_bank')
            ->leftJoin('public.data_nasabah', 'public.data_nasabah.uuid', '=', 'public.transfer_antar_bank.nasabah_id')
            ->leftJoin('master.daftar_bank', 'master.daftar_bank.uuid', '=', 'public.transfer_antar_bank.bank_id')
            ->whereNull('public.transfer_antar_bank.deleted_at')
            ->whereDate('public.transfer_antar_bank.created_at', '>=', $data['start'])
            ->whereDate('public.transfer_antar_bank.created_at', '<=', $data['end'])
            ->orderBy('public.transfer_antar_bank.status_transaksi', 'ASC')
            // ->whereIn('public.transfer_antar_bank.status_transaksi', [1, 2])
            ->get(['public.transfer_antar_bank.*', 'public.data_nasabah.nama as nasabah', 'master.daftar_bank.bank', 'public.data_nasabah.norek']);

        // return $data;
        return view('pages.pengajuan.transfer', $data);
    }

    public function updatetransaksinasabah(Request $request)
    {
        if ($request->type == 0) {
            DB::table('public.transfer_antar_rekening')
                ->where('public.transfer_antar_rekening.uuid', $request->uuid)
                ->update([
                    'status_transaksi' => $request->status
                ]);

            return response()->json([
                'msg' => 'Data transaksi nasabah berhasil dibatalkan'
            ]);
        }
        if ($request->type == 1) {
            DB::table('public.transfer_antar_bank')
                ->where('public.transfer_antar_bank.uuid', $request->uuid)
                ->update([
                    'status_transaksi' => $request->status
                ]);

            return response()->json([
                'msg' => 'Data transaksi nasabah berhasil dibatalkan'
            ]);
        }
    }
}
