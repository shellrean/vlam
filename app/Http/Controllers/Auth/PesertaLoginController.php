<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Peserta;
use App\UjianAktif;
use Illuminate\Support\Facades\Validator;

class PesertaLoginController extends Controller
{

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'no_ujian'      => 'required|exists:pesertas,no_ujian',
            'password'      => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()],422);
        }


        // $peserta = Peserta::where(['no_ujian' => $request->no_ujian,'password' => $request->password])->first();

        $aktif = UjianAktif::first();
        $credentials = $request->only('no_ujian','password');
        
        if(auth()->guard('peserta')->attempt($credentials)) {
            if(auth()->guard('peserta')->user()->api_token != '') {
                return response()->json(['status' => 'loggedin']);
            }
            if($aktif->kelompok != auth()->guard('peserta')->user()->sesi) {
                return response()->json(['status' => 'non-sesi']);
            }
            $peserta = Peserta::find(auth()->guard('peserta')->user()->id);
            $peserta->api_token = Str::random(80);
            $peserta->save();

            return response()->json(['status' => 'success', 'data' => $peserta],200);
        }       

        return response()->json(['status' => 'error']); 
    }

    public function logout(Request $request) 
    {
        $peserta = Peserta::find(auth()->guard('peserta-api')->user()->id);
        $peserta->api_token = '';
        $peserta->save();

        return response()->json(['status' => 'success']);
    }

    public function profile()
    {
        $profile = auth()->guard('peserta-api')->user();
        if(!isset($profile)) {
            return response()->json(['data' => []]);
        }
        $data = [
            'id'        =>  $profile->id,
            'nama'      => $profile->nama,
            'no_ujian' => $profile->no_ujian
        ];

        return response()->json(['data' => $data]);
    }
}
