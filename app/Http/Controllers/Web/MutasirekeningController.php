<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Imports\MutasiImport;
use App\Models\Public\MutasirekeningModel;
use App\Models\Public\NasabahModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class MutasirekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['mutasi'] = MutasirekeningModel::select('mutasi_rekening.*', 'data_nasabah.nama', 'data_nasabah.norek')
            ->leftJoin('data_nasabah', 'data_nasabah.uuid', '=', 'mutasi_rekening.nasabah_id')
            ->orderBy('mutasi_rekening.tanggal', 'desc')
            ->paginate(10);

        $data['datamutasi'] = json_encode($data['mutasi']->items());

        // return $data['datamutasi'];
        return view('pages.mutasi.mutasirekening', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->hasFile('import_file')) {
            $reqarr = Excel::toCollection(new MutasiImport, $request->file('import_file'));

            // return $reqarr;
            foreach ($reqarr as $key => $value) {
                foreach ($value as $j => $val) {
                    if ($j > 0) {
                        // return  \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($val[1]));
                        $nasabah = NasabahModel::where('norek', $val[0])->first();
                        if ($nasabah) {
                            MutasirekeningModel::create([
                                'nasabah_id' => $nasabah['uuid'],
                                'tanggal' =>  \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($val[1])),
                                'kode' => $val[2],
                                'debit' => $val[3],
                                'kredit' => $val[4],
                                'saldo' => $val[5],
                                'keterangan' => $val[6],
                                'uuid' => Str::uuid()
                            ]);
                        } else {
                            return redirect('/mutasi-rekening')->with('info', 'Nomor rekening nasabah tidak ditemukan');
                        }
                    }
                }
            }
            return redirect('/mutasi-rekening')->with('success', 'Berhasil import mutasi rekening nasabah');
        } else {
            return redirect('/mutasi-rekening')->with('info', 'File import mutasi rekening tidak ditemukan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function hapussemuamutasi(Request $request)
    {
        if (!$request->mutasiid) {
            return redirect('/mutasi-rekening')->with('info', 'Tidak ada data mutasi yang dipilih');
        }
        $expl = Explode(',', $request->mutasiid);
        MutasirekeningModel::whereIn('uuid', $expl)->delete();
        return redirect('/mutasi-rekening')->with('success', 'Berhasil hapus data mutasi yang dipilih');
        // return $expl;
    }
}
