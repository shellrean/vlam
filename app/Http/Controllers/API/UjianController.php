<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Banksoal;
use App\JawabanPeserta;

class UjianController extends Controller
{
    public function getsoal($id)
    {
    	$all = Banksoal::with(['pertanyaans','pertanyaans.jawabans'])->where('id',$id)->first();
    	return response()->json(['data' => $all]);
    }

    public function store(Request $request)
    {
    	$req = $request->all()['data'];
    	$data = [
    		'banksoal_id'		=> $req['banksoal_id'],
    		'soal_id'			=> $req['soal_id'],
    		'jawab'				=> $req['jawab'],
    		'iscorrect'			=> $req['correct']
    	];

    	$find = JawabanPeserta::where(['banksoal_id' => $req['soal_id'] ])->first();
    	if($find) {
    		$find->update($data);

    		return response()->json('updated');
    	}

    	$peserta = JawabanPeserta::create($data);
    	return response()->json('submited');
    }

    public function getJawabanPeserta($id)
    {
        $data = JawabanPeserta::where(['soal_id' => $id])->first();
        return response()->json(['data' => $data]);
    }

    public function getListUjian()
    {
        
    }
}
