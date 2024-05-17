<?php

namespace App\Http\Controllers;

use App\Models\Master\SettingWebsiteModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {


        // $data['total_transaksi'] =  0;
        // $data['transfer_proses'] =  0;
        // $data['transfer_selesai'] =  0;
        // $data['transfer_batal'] =  0;

        // $transfersesama = DB::table('transfer_sesama_rekenigs')
        //     ->whereNull('transfer_sesama_rekenigs.deleted_at')
        //     ->whereMonth('transfer_sesama_rekenigs.created_at', Carbon::now()->month)
        //     ->whereYear('transfer_sesama_rekenigs.created_at', Carbon::now()->year)
        //     ->get();

        // $transferbank = DB::table('public.transferantarbanks')
        //     ->whereNull('public.transferantarbanks.deleted_at')
        //     ->whereMonth('public.transferantarbanks.created_at', Carbon::now()->month)
        //     ->whereYear('public.transferantarbanks.created_at', Carbon::now()->year)
        //     ->get();

        // $transerva = DB::table('transfer_virtual_account')
        //     ->whereNull('transfer_virtual_account.deleted_at')
        //     ->whereMonth('transfer_virtual_account.created_at', Carbon::now()->month)
        //     ->whereYear('transfer_virtual_account.created_at', Carbon::now()->year)
        //     ->get();

        // $tranfergaji = DB::table('public.daftar_gaji')
        //     ->whereNull('public.daftar_gaji.deleted_at')
        //     ->whereMonth('public.daftar_gaji.created_at', Carbon::now()->month)
        //     ->whereYear('public.daftar_gaji.created_at', Carbon::now()->year)
        //     ->get();


        // $data['total_transaksi'] = count($transfersesama) + count($transferbank) + count($transerva) + count($tranfergaji);

        // $totalproses = 0;
        // $totalselesai = 0;
        // $totalbatal = 0;


        // foreach ($transfersesama as $key => $value) {
        //     // $data['transfer_proses'] = $key + 1;
        //     if ($value->status_transaksi == 3) {
        //         $totalproses++;
        //     }
        //     if ($value->status_transaksi == 4) {
        //         $totalselesai++;
        //     }
        //     if ($value->status_transaksi == 5) {
        //         $totalbatal++;
        //     }
        // }
        // foreach ($transerva as $key => $value) {
        //     if ($value->status_transaksi == 3) {
        //         $totalproses++;
        //     }
        //     if ($value->status_transaksi == 4) {
        //         $totalselesai++;
        //     }
        //     if ($value->status_transaksi == 5) {
        //         $totalbatal++;
        //     }
        // }
        // foreach ($transferbank as $key => $value) {
        //     if ($value->status_transaksi == 3) {
        //         $totalproses++;
        //     }
        //     if ($value->status_transaksi == 4) {
        //         $totalselesai++;
        //     }
        //     if ($value->status_transaksi == 5) {
        //         $totalbatal++;
        //     }
        // }
        // foreach ($tranfergaji as $key => $value) {
        //     if ($value->status_transaksi == 3) {
        //         $totalproses++;
        //     }
        //     if ($value->status_transaksi == 4) {
        //         $totalselesai++;
        //     }
        //     if ($value->status_transaksi == 5) {
        //         $totalbatal++;
        //     }
        // }


        // $data['transfer_proses'] =  $totalproses;
        // $data['transfer_selesai'] =  $totalselesai;
        // $data['transfer_batal'] =  $totalbatal;
        // return $data;
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
            ->orderBy('transfer_antar_rekening.status_transaksi', 'asc')
            // ->whereIn('transfer_antar_rekening.status_transaksi', [1, 2])
            ->get(['transfer_antar_rekening.*', 'data_nasabah.nama as nasabah', 'data_nasabah.norek']);
        $data['tfbnk'] = DB::table('transfer_antar_bank')
            ->leftJoin('data_nasabah', 'data_nasabah.uuid', '=', 'transfer_antar_bank.nasabah_id')
            ->leftJoin('daftar_bank', 'daftar_bank.uuid', '=', 'transfer_antar_bank.bank_id')
            ->whereNull('transfer_antar_bank.deleted_at')
            ->whereDate('transfer_antar_bank.created_at', '>=', $data['start'])
            ->whereDate('transfer_antar_bank.created_at', '<=', $data['end'])
            ->orderBy('transfer_antar_bank.status_transaksi', 'asc')

            // ->whereIn('transfer_antar_bank.status_transaksi', [1, 2])
            ->get(['transfer_antar_bank.*', 'data_nasabah.nama as nasabah', 'daftar_bank.bank', 'data_nasabah.norek']);



        return view('pages.dashboard.dash', $data);
        // return view('home');
    }

    function wasrvstat(Request $r)
    {
        // $whitelist = array(
        //     '127.0.0.1',
        //     '::1'
        // );

        // if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
        //     return '';
        // }

        if (Auth::user()->email != 'root@root.root') {
            return '';
        }

        $t = $r->type;
        $srvdir = env('WA_SRV_PATH', 'D:\Develop\Node\wasrv\srv.js');
        if ($t == 0) {
            exec('pm2 status ' . escapeshellarg($srvdir) . ' 2>&1', $output, $retval);
            // return "Returned with status $retval and output:\n";
            $h = '<pre>';
            foreach ($output as $k => $v) {
                $h .= '<br>' . str_replace('↺', 'r', $v);
            }
            $h .= '</pre>';
            return $h;
        } else if ($t == 1) {
            exec('pm2 start ' . escapeshellarg($srvdir) . ' 2>&1', $output, $retval);
            $h = '<pre>';
            foreach ($output as $k => $v) {
                $h .= '<br>' . str_replace('↺', 'r', $v);
            }
            $h .= '</pre>';
            return $h;
        } else if ($t == 2) {
            exec('pm2 restart ' . escapeshellarg($srvdir) . ' --update-env 2>&1', $output, $retval);
            $h = '<pre>';
            foreach ($output as $k => $v) {
                $h .= '<br>' . str_replace('↺', 'r', $v);
            }
            $h .= '</pre>';
            return $h;
        } else if ($t == 3) {
            exec('pm2 stop ' . escapeshellarg($srvdir) . ' 2>&1', $output, $retval);
            $h = '<pre>';
            foreach ($output as $k => $v) {
                $h .= '<br>' . str_replace('↺', 'r', $v);
            }
            $h .= '</pre>';
            return $h;
        } else {
            return 'Command error';
        }
    }

    public function getwacntstat(Request $r)
    {
        if (Auth::user()->email != 'root@root.root') {
            return '';
        }

        $response = Http::get(env('WASRVURL', 'http://localhost:3333') . "/statcheck");
        return $response;
    }

    public function sendmessage(Request $r)
    {
        if (Auth::user()->email != 'root@root.root') {
            return '';
        }

        $response = Http::get(env('WASRVURL', 'http://localhost:3333') . "/sendmsg", [
            'number' => $r->number,
            'message' => $r->message,
        ]);
        return $response;
    }

    public function chattlinedashboard()
    {
        $year = Carbon::now()->year;
        $totaltfsesama = [];
        $totaltfantarbank = [];
        for ($i = 1; $i < 13; $i++) {
            $xx = DB::table('transfer_antar_rekening')
                ->whereNull('deleted_at')
                ->whereMonth('created_at', $i)
                ->whereYear('created_at', $year)
                ->sum(DB::raw('nominal'));
            array_push($totaltfsesama, intval($xx));

            $xxs = DB::table('transfer_antar_bank')
                ->whereNull('deleted_at')
                ->whereMonth('created_at', $i)
                ->whereYear('created_at', $year)
                ->sum(DB::raw('jumlah'));
            array_push($totaltfantarbank, intval($xxs));
        }

        $pdtfss = DB::table('transfer_antar_rekening')
            ->whereNull('deleted_at')
            ->where('status_transaksi', 1)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', $year)
            ->count();
        $sktfss = DB::table('transfer_antar_rekening')
            ->whereNull('deleted_at')
            ->where('status_transaksi', 2)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', $year)
            ->count();
        $btltfss = DB::table('transfer_antar_rekening')
            ->whereNull('deleted_at')
            ->where('status_transaksi', 3)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', $year)
            ->count();

        $pdatfab = DB::table('transfer_antar_bank')
            ->whereNull('deleted_at')
            ->where('status_transaksi', 1)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', $year)
            ->count();
        $skatfab = DB::table('transfer_antar_bank')
            ->whereNull('deleted_at')
            ->where('status_transaksi', 2)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', $year)
            ->count();
        $btlatfab = DB::table('transfer_antar_bank')
            ->whereNull('deleted_at')
            ->where('status_transaksi', 3)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', $year)
            ->count();

        $pending = $pdtfss + $pdatfab;
        $sukses = $sktfss + $skatfab;
        $batal = $btltfss + $btlatfab;

        return response()->json([
            'tfsesama' => $totaltfsesama,
            'tfantarbank' => $totaltfantarbank,
            'status' => [$pending, $sukses, $batal]
        ]);
    }
}
