<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Master\BiayatransferModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class BiayatransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['biaya'] = BiayatransferModel::get();
        return view('pages.master.biayatf', $data);
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
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'nominal' => 'required',
        ]);

        // response error validation
        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),

            ], 400);
        }

        BiayatransferModel::updateOrCreate([
            'uuid' => $request->uuid,
        ], [
            'uuid' => Str::uuid(),
            'nominal' => $request->nominal,
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Berhasil simpan biaya transfer'
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        BiayatransferModel::where('uuid', $id)->delete();
        return redirect('/biaya-transfer');
    }
}
