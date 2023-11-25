<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\AktivasiMail;
use App\Models\Public\NasabahModel;
use App\Models\Public\TokenSendEmailModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisternasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['nasabah'] = NasabahModel::leftJoin('master.jenis_tabungan', 'master.jenis_tabungan.uuid', '=', 'public.data_nasabah.tabungan_id')
            ->get(['master.jenis_tabungan.nama as tabungan', 'public.data_nasabah.*']);
        // return $data;
        return view('pages.register.register', $data);
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
            'type_nasabah' => 'required',
            'jenis_tabungan' => 'required',
            'nomor_rekening' => 'required',
            'nama' => 'required',
            'email' => 'required',
            'nomor_handphone' => 'required',
            'alamat_ktp' => 'required',
            'alamat_domisili' => 'required',
        ]);

        // response error validation
        if ($validator->fails()) {
            // return Redirect::back()->withErrors($validator)->withInput();
            return Response::json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        NasabahModel::updateOrCreate([
            'uuid' => $request->uuid,
        ], [
            'tabungan_id' => $request->jenis_tabungan,
            'norek' => $request->nomor_rekening,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->nomor_handphone,
            'type_nasabah' => $request->type_nasabah,
            'alamat_ktp' => $request->alamat_ktp,
            'alamat_domisili' => $request->alamat_domisili,
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Berhasil simpan data nasabah'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return NasabahModel::leftJoin('master.jenis_tabungan', 'master.jenis_tabungan.uuid', '=', 'public.data_nasabah.tabungan_id')
            ->where('public.data_nasabah.uuid', $id)
            ->first(['master.jenis_tabungan.nama as tabungan', 'public.data_nasabah.*']);
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
        NasabahModel::where('uuid', $id)->delete();
        return redirect('/register-nasabah');
    }


    public function kirimemailsekarang($id)
    {
        $nasabah = NasabahModel::where('uuid', $id)->get();
        $token = Str::random(255);
        $hashtoken = Hash::make($token);
        foreach ($nasabah as $key => $value) {
            $value->token = $token;
        }
        try {
            Mail::to($nasabah[0]->email)->send(new AktivasiMail($nasabah[0]));
            TokenSendEmailModel::create([
                'nasabah_id' => $nasabah[0]->uuid,
                'token' => $hashtoken,
                'hingga' => Carbon::now()->addDay()
            ]);

            return response()->json([
                'success' => true,
                'msg' => 'Berhasil kirim email'
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'success' => false,
                'errors' => 'Ups, email gagal terkirim',
            ], 400);
        }
    }
}
