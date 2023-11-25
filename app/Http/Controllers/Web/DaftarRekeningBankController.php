<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Master\DaftarRekeningBprModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class DaftarRekeningBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['rekening'] = DaftarRekeningBprModel::get();
        return view('pages.master.daftarrekening', $data);
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
            'norek' => 'required',
            'atas_nama' => 'required',
        ]);

        // response error validation
        if ($validator->fails()) {
            // return Redirect::back()->withErrors($validator)->withInput();
            return Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),

            ], 400);
        }

        DaftarRekeningBprModel::updateOrCreate([
            'uuid' => $request->uuid,
        ], [
            // 'nominal' => $request->nominal,
            // 'bayar' => $request->nominal,
            // 'provider' => $request->provider
            'bank' => $request->bank,
            'norek' => $request->norek,
            'atas_nama' => $request->atas_nama,
            'status' => 1
        ]);


        return response()->json([
            'success' => true,
            'msg' => 'Berhasil simpan daftar rekening'
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
        DaftarRekeningBprModel::where('uuid', $id)->update([
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
        DaftarRekeningBprModel::where('uuid', $id)->delete();
        return Redirect('/daftar-rekening');
    }
}
