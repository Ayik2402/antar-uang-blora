<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Imports\DaftarBankImport;
use App\Models\Master\DaftarBankModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class DaftarBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['bank'] = DaftarBankModel::get();
        return view('pages.master.daftarbank', $data);
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
        $validator = Validator::make($request->all(), [
            'bank' => 'required',
        ]);

        // response error validation
        if ($validator->fails()) {
            // return Redirect::back()->withErrors($validator)->withInput();
            return Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),

            ], 400);
        }

        DaftarBankModel::updateOrCreate([
            'uuid' => $request->uuid,
        ], [
            'bank' => $request->bank,
            'uuid' => Str::uuid()
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Berhasil simpan daftar bank'
        ]);
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
        DaftarBankModel::where('uuid', $id)->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Berhasil update status'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DaftarBankModel::where('uuid', $id)->delete();
        return redirect('/daftar-bank');
    }

    public function importfiledaftarbank(Request $request)
    {
        // return $request->all();

        if ($request->hasFile('import_file')) {
            $reqarr = Excel::toCollection(new DaftarBankImport, $request->file('import_file'));

            // return $reqarr;
            foreach ($reqarr as $key => $value) {
                foreach ($value as $j => $val) {
                    if ($j > 0) {
                        DaftarBankModel::create([
                            'uuid' => Str::uuid(),
                            'bank' => $val[0],
                            'status' => 1
                        ]);
                    }
                }
            }
            return redirect('/daftar-bank')->with('success', 'Berhasil import daftar bank');
        } else {
            return redirect('/daftar-bank')->with('info', 'File import daftar bank tidak ditemukan');
        }
    }
}
