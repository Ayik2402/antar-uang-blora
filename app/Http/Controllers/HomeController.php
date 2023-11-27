<?php

namespace App\Http\Controllers;

use App\Models\Master\SettingWebsiteModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function index()
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

        return view('pages.dashboard.dash');
        // return view('home');
    }

    function wasrvstat(Request $r) {
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );

        if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
            return '';
        }

        $t = $r->type;
        $srvdir = env('WA_SRV_PATH','D:\Develop\Node\wasrv\srv.js');
        if ($t==0) {
            exec('pm2 status ./srv.js', $output, $retval);
            // return "Returned with status $retval and output:\n";
            $h = '<pre>';
            foreach ($output as $k => $v) {
                $h .= '<br>'.str_replace('↺', 'r', $v);
            }
            $h .= '</pre>';
            return $h;
        } else if ($t==1) {
            exec('pm2 start '.escapeshellarg($srvdir).'', $output, $retval);
            $h = '<pre>';
            foreach ($output as $k => $v) {
                $h .= '<br>'.str_replace('↺', 'r', $v);
            }
            $h .= '</pre>';
            return $h;
        } else if ($t==2) {
            exec('pm2 restart '.escapeshellarg($srvdir).' --update-env', $output, $retval);
            $h = '<pre>';
            foreach ($output as $k => $v) {
                $h .= '<br>'.str_replace('↺', 'r', $v);
            }
            $h .= '</pre>';
            return $h;
        } else if ($t==3) {
            exec('pm2 stop '.escapeshellarg($srvdir).'', $output, $retval);
            $h = '<pre>';
            foreach ($output as $k => $v) {
                $h .= '<br>'.str_replace('↺', 'r', $v);
            }
            $h .= '</pre>';
            return $h;
        } else {
            return 'Command error';
        }
    }
}
