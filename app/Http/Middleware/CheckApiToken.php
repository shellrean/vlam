<?php

namespace App\Http\Middleware;

use Closure;
use App\Peserta;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!empty(trim($request->input('api_token')))){

            $is_exists = Peserta::where('id' , Auth::guard('peserta')->id())->exists();
            if($is_exists){
                return $next($request);
            }
        }
        return response()->json('Invalid Token', 401);
    }
}
