<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Peserta;
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

        if($peserta) {
            $peserta->update(['api_token' => Str::random(80)]);
            return response()->json(['status' => 'success', 'data' => $peserta],200);
        }       

        return response()->json(['status' => 'error']); 
    }
}
