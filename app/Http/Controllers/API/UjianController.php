<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Banksoal;
use App\JawabanPeserta;
use App\Jadwal;
use App\SiswaUjian;
use App\HasilUjian;

class UjianController extends Controller
{
    /**
     * Get soal by id
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getsoal($id)
    {
    	$all = Banksoal::with(['pertanyaans','pertanyaans.jawabans'])->where('id',$id)->first();

    	return response()->json(['data' => $all]);
    }

    /**
     * Store data ujian to table
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $find = JawabanPeserta::where([
            'id'            => $request->jawaban_id
        ])->first();

        $find->jawab = $request->jawab;
        $find->iscorrect = $request->correct;
        $find->save();

    	return response()->json(['data' => $find,'index' => $request->index]);
    	
    }

    /** 
     * Set ragu ragu in siswa
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function setRagu(Request $request) 
    {
        $find = JawabanPeserta::where([
            'id'            => $request->jawaban_id
        ])->first();

        $find->ragu_ragu = $request->ragu_ragu;
        $find->save();

        return response()->json(['data' => $find,'index' => $request->index]);
    }

    /**
     * Get jawaban peserta 
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
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

            $max_soal = $all->jumlah_soal;
            $i = 1;
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

                if ($i++ == $max_soal) break;
            }
            
            $detail = SiswaUjian::where([
                'jadwal_id'     => $jadwal_id,
                'peserta_id'    => $user_id
            ])->first();


            $find = JawabanPeserta::with([
                'soal','soal.jawabans'
            ])->where([
                'peserta_id'    => $user_id, 
                'jadwal_id'     => $jadwal_id,
            ])->get();
            
            return response()->json(['data' => $find, 'detail' => $detail]);
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

    public function selesai(Request $request)
    {
        $ujian = SiswaUjian::where([
            'jadwal_id'     => $request->jadwal_id, 
            'peserta_id'    => $request->peserta_id
        ])->first();

        $ujian->status_ujian = 1;
        $ujian->save();

        $salah = JawabanPeserta::where([
            'iscorrect'     => 0,
            'jadwal_id'     => $request->jadwal_id, 
            'peserta_id'    => $request->peserta_id
        ])->get();
        $benar = JawabanPeserta::where([
            'iscorrect'     => 1,
            'jadwal_id'     => $request->jadwal_id, 
            'peserta_id'    => $request->peserta_id
        ])->get();
        $jml = JawabanPeserta::where([
            'jadwal_id'     => $request->jadwal_id, 
            'peserta_id'    => $request->peserta_id
        ])->get();

        $hasil = (count($benar)/count($jml))*100;

        HasilUjian::create([
            'peserta_id'      => $request->peserta_id,
            'jadwal_id'       => $request->jadwal_id,
            'jumlah_salah'    => count($salah),
            'jumlah_benar'    => count($benar),
            'tidak_diisi'     => 0,
            'hasil'           => $hasil,
        ]);

        return response()->json(['status' => 'finished']);
    }

    public function cekToken(Request $request)
    {
        $jadwal = Jadwal::find($request->id);
        if($jadwal->token == $request->token) {
            return response()->json(['status' =>'success']);
        }
        return response()->json(['status' => 'error']);
    }
}
