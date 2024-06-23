<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Public\PermohonanRekeningTransferModel;
use Illuminate\Http\Request;

class PermohonanRekeningTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['apr'] = PermohonanRekeningTransferModel::leftJoin('daftar_bank', 'daftar_bank.uuid', '=', 'permohonan_rekening_transfer.bank_id')
            ->leftJoin('users_client', 'users_client.uuid', '=', 'permohonan_rekening_transfer.user_id')
            ->get(['permohonan_rekening_transfer.*', 'daftar_bank.bank', 'users_client.name']);

        // return $data;
        return view('pages.rekening.listrekening', $data);
    }

    public function terimastatus($id, $sts)
    {
        PermohonanRekeningTransferModel::where('uuid', $id)->update([
            'status' => $sts
        ]);

        return redirect('/permohonan-rekening-transfer')->with('success', 'Berhasil simpan data');
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
        //
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
}
