<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Banksoal;
use App\JawabanPeserta;
use App\Jadwal;
use App\SiswaUjian;

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
            'peserta_id'    => $request->peserta_id,
            'jadwal_id'     => $request->jadwal_id,
            'banksoal_id'   => $request->banksoal_id
        ])->first();

        $find->jawab = $request->jawab;
        $find->save();

    	return response()->json(['data' => $find,'index' => $request->index]);
    	
    }

    public function setRagu(Request $request) 
    {
        $find = JawabanPeserta::where([
            'soal_id'       => $request->soal_id,
            'peserta_id'    => $request->peserta_id,
            'jadwal_id'     => $request->jadwal_id,
            'banksoal_id'   => $request->banksoal
        ])->first();

        $find->ragu_ragu = $request->ragu_ragu;
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

    /**
     * Store or get the JawabanPeserta table
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filled(Request $request)
    {
        $id = $request->banksoal;
        $jadwal_id = $request->jadwal_id;
        $user_id = $request->peserta_id;

        
        $find = JawabanPeserta::with([
            'soal','soal.jawabans'
        ])->where([
            'peserta_id'    => $user_id,
            'jadwal_id'     => $jadwal_id,
        ])->get();

        if ($find->count() < 1 ) {
            $all = Banksoal::with(['pertanyaans','pertanyaans.jawabans'])->where('id',$id)->first();
            $collection = new Collection($all->pertanyaans);
            $perta = $collection->shuffle();
            
            foreach($perta as $p) {
                JawabanPeserta::create([
                    'peserta_id'    => $user_id, 
                    'banksoal_id'   => $id, 
                    'soal_id'       => $p->id, 
                    'jawab'         => 0, 
                    'iscorrect'     => 0,
                    'jadwal_id'     => $jadwal_id,
                    'ragu_ragu'     => 0
                ]);
            }

            $find = JawabanPeserta::with(['soal','soal.jawabans'])->where([
                'peserta_id'    => $user_id, 
                'jadwal_id'     => $jadwal_id,
            ])->get();
            
            return response()->json(['data' => $all]);
        }
        
        $detail = SiswaUjian::where([
            'jadwal_id'     => $jadwal_id,
            'peserta_id'    => $user_id
        ])->first();

        return response()->json(['data' => $find, 'detail' => $detail]);
    }

    public function sisaWaktu(Request $request)
    {
        $detail = SiswaUjian::where([
            'jadwal_id'     => $request->jadwal_id,
            'peserta_id'    => $request->peserta_id
        ])->first();
        $detail->sisa_waktu = $request->sisa_waktu;
        $detail->save();
        return response()->json(['data' => 'updated']);
    }

    public function detUjian(Request $request) 
    {
        $ujian = SiswaUjian::where([
            'jadwal_id'     => $request->jadwal_id, 
            'peserta_id'    => $request->peserta_id
        ])->first();

        if(!$ujian) {
            $data = [
                'jadwal_id'     => $request->jadwal_id,
                'peserta_id'    => $request->peserta_id,
                'mulai_ujian'   => now()->format('H:i:s'),
                'sisa_waktu'    => $request->lama,
                'status_ujian'  => 0
            ];

            $data = SiswaUjian::create($data);

            return response()->json(['data' => $data]);
        }

        return response()->json(['data' => $ujian]);
    }
}
