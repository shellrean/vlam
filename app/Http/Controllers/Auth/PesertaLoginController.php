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


        $peserta = Peserta::where(['no_ujian' => $request->no_ujian,'password' => $request->password])->first();
        $aktif = UjianAktif::first();
        
        if($peserta) {
            if($peserta->api_token != '') {
                return response()->json(['status' => 'loggedin']);
            }
            if($aktif->kelompok != $peserta->sesi) {
                return response()->json(['status' => 'non-sesi']);
            }
            $peserta->update(['api_token' => Str::random(80)]);
            return response()->json(['status' => 'success', 'data' => $peserta],200);
        }       

        return response()->json(['status' => 'error']); 
    }

    public function logout(Request $request) 
    {
        $peserta = Peserta::where(['no_ujian' => $request->no_ujian])->first();
        $peserta->api_token = '';
        $peserta->save();

        return response()->json(['status' => 'success']);
    }
}
