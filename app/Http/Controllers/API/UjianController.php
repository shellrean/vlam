<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Banksoal;
use App\JawabanPeserta;
use App\Jadwal;

class UjianController extends Controller
{
    public function getsoal($id)
    {
    	$all = Banksoal::with(['pertanyaans','pertanyaans.jawabans'])->where('id',$id)->first();

    	return response()->json(['data' => $all]);
    }

    public function store(Request $request)
    {

        $find = JawabanPeserta::where([
            'soal_id'       => $request->soal_id,
            'peserta_id'    => $request->peserta_id
        ])->first();

        $find->jawab = $request->jawab;
        $find->save();

    	return response()->json(['data' => $find,'index' => $request->index]);
    	
    }

    public function getJawabanPeserta($id)
    {
        $data = JawabanPeserta::where(['soal_id' => $id])->first();
        return response()->json(['data' => $data]);
    }

    public function getListUjian()
    {
        $data = Jadwal::with('banksoal')->where(['tanggal' => now()->format('Y-m-d')])->get();
        
        return response()->json(['data' => $data]);
    }

    public function filled(Request $request)
    {
        $id = $request->banksoal;
        $user_id = $request->peserta_id;

        
        $find = JawabanPeserta::with(['soal','soal.jawabans'])->where(['peserta_id' => $user_id,'banksoal_id' => $id])->get();


        if ($find->count() < 1 ) {
            $all = Banksoal::with(['pertanyaans','pertanyaans.jawabans'])->where('id',$id)->first();
            $collection = new Collection($all->pertanyaans);
            $perta = $collection->shuffle();
            
            foreach($perta as $p) {
                JawabanPeserta::create(['peserta_id' => $user_id, 'banksoal_id' => $id, 'soal_id' => $p->id, 'jawab' => 0, 'iscorrect' => 0]);
            }

            $find = JawabanPeserta::with(['soal','soal.jawabans'])->where(['peserta_id' => $user_id, 'banksoal_id' => $id])->get();
            return response()->json(['data' => $all]);
        }

        return response()->json(['data' => $find]);
    }
}
