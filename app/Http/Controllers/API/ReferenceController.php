<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Setting;

class ReferenceController extends Controller
{
    public function setting()
    {
    	$setting = Setting::first();
    	return response()->json(['data' => $setting]);
    }

    public function storeSetting(Request $request)
    {
    	$this->validate($request, [
    		'periode'		=> 'required'
    	]);

    	try {
    		$setting = Setting::first();
    		$setting->update([
    			'periode'		=> $request->periode
    		]);

    		return response()->json(['status' => 'success']);
    	}
    	catch(\Exception $e) {
    		return response()->json(['status' => 'failed']);
    	}
    }
}
