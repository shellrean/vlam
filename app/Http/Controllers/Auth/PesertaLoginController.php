<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PesertaLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/ujian';


    public function __construct()
    {
      $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'no_ujian'      => 'required|exists:pesertas,no_ujian',
            'password'      => 'required'
        ]);

        $auth = $request->all();
        if (Auth::guard('peserta')->attempt($auth)) {
            auth()->user()->update(['api_token' => Str::random(40)]);
            return response()->json(['status' => 'success', 'data' => auth()->user()->api_token],200);
        }

        return response()->json(['status' => 'failed']);
    }
    public function username()
    {
        return 'no_peserta';
    }
    protected function guard()
    {
        return Auth::guard('peserta');
    }
}
