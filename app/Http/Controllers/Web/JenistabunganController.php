<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Master\JenistabunganModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JenistabunganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['tab'] = JenistabunganModel::get();
        return view('pages.master.jenistabungan', $data);
    }

    public function getjenistabungan(Request $request)
    {
        if (!$request->search) {
            return JenistabunganModel::get();
        }
        return JenistabunganModel::where('nama', 'ILIKE', '%' . $request->search . '%')->get();
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
            'tabungan' => 'required',
        ]);

        // response error validation
        if ($validator->fails()) {
            // return Redirect::back()->withErrors($validator)->withInput();
            return Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),

            ], 400);
        }

        JenistabunganModel::updateOrCreate([
            'uuid' => $request->uuid,
        ], [
            'nama' => $request->tabungan,
            'uuid' => Str::uuid(),
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Berhasil simpan jenis tabungan'
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
        JenistabunganModel::where('uuid', $id)->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Berhasil update status jenis tabungan'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        JenistabunganModel::where('uuid', $id)->delete();
        return redirect('/jenis-tabungan');
    }
}
