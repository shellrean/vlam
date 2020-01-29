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
use App\JawabanSoal;
use App\UjianAktif;
use App\Peserta;
use App\Matpel;

use Carbon\Carbon;

use DB;
use Illuminate\Support\Str;

class UjianController extends Controller
{
    /**
     * Get soal by id
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getsoal(Request $request)
    {
        if($request->banksoal != 0) {
            $all = Banksoal::with(['pertanyaans','pertanyaans.jawabans'])->where('id',$id)->first();
        }
        else {
            $peserta = Peserta::find(auth()->guard('peserta-api')->user()->id);
            $jursan = $peserta->jurusan_id;
            $banksols = DB::table('banksoals')
                ->join('matpels', function($q) {
                    $q->on('matpels.id','=','banksoals.matpel_id');
                })
                ->select('banksoals.id')
                ->where('matpels.jurusan_id', '=', $jursan)
                ->first();
                $all = Banksoal::with(['pertanyaans','pertanyaans.jawabans'])->where('id', $banksols->id)->first();
        }

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

        $kj = JawabanSoal::find($request->jawab);

        if($request->essy) {
            $find->jawab_essy = $request->essy;
            $find->save();

            return response()->json(['data' => $find,'index' => $request->index]);
        }
        $find->jawab = $request->jawab;
        $find->iscorrect = $kj->correct;
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
        $user_id = auth()->guard('peserta-api')->user()->id;

        
        $find = JawabanPeserta::with([
            'soal','soal.jawabans' => function($q) {
                $q->inRandomOrder();
            }
        ])->where([
            'peserta_id'    => $user_id,
            'jadwal_id'     => $jadwal_id,
        ])->get();

        if ($find->count() < 1 ) {
            if($id == 0) {
                $peserta = Peserta::find($user_id);
                $jursan = $peserta->jurusan_id;
                $banksols = DB::table('banksoals')
                ->join('matpels', function($q) {
                    $q->on('matpels.id','=','banksoals.matpel_id');
                })
                ->select('banksoals.id')
                ->where('matpels.jurusan_id', '=', $jursan)
                ->first();
                $all = Banksoal::with(['pertanyaans','pertanyaans.jawabans'])->where('id', $banksols->id)->first();
            }
            else {
                $all = Banksoal::with(['pertanyaans','pertanyaans.jawabans'])->where('id',$id)->first();
            }

            $max_soal = $all->jumlah_soal;
            $max_essay = $all->jumlah_soal_esay;
            $i = 1;
            $collection = new Collection($all->pertanyaans);
            $perta = $collection->shuffle();
            
            foreach($perta as $p) {
                if($p->tipe_soal != 1) {
                    continue;
                }
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

            $i = 1;
            if ($max_essay != null && $max_essay > 0) {
                foreach($perta as $p) {
                    if($p->tipe_soal != 2) {
                        continue;
                    }
                    
                    JawabanPeserta::create([
                        'peserta_id'    => $user_id, 
                        'banksoal_id'   => $id, 
                        'soal_id'       => $p->id, 
                        'jawab'         => 0, 
                        'iscorrect'     => 0,
                        'jadwal_id'     => $jadwal_id,
                        'ragu_ragu'     => 0
                    ]);
    
                    if ($i++ == $max_essay) break;
                }
            }
            
            $detail = SiswaUjian::where([
                'jadwal_id'     => $jadwal_id,
                'peserta_id'    => $user_id
            ])->first();


            $find = JawabanPeserta::with([
                'soal','soal.jawabans' => function($q) {
                    $q->inRandomOrder();
                }
            ])->where([
                'peserta_id'    => $user_id, 
                'jadwal_id'     => $jadwal_id,
            ])->get();
    
            return response()->json(['data' => $find, 'detail' => $detail]);
        }
        
        $ujian = SiswaUjian::where([
            'jadwal_id'     => $jadwal_id,
            'peserta_id'    => $user_id
        ])->first();

        $deUjian = Jadwal::find($request->jadwal_id);

        $start = Carbon::createFromFormat('H:i:s', $ujian->mulai_ujian);
        $now = Carbon::createFromFormat('H:i:s', Carbon::now()->format('H:i:s'));

        $diff_in_minutes = $start->diffInSeconds($now);

        if($diff_in_minutes > $deUjian->lama) {
            return response()->json(['data' => $find, 'detail' => $ujian]);
        }
        
        $ujian->sisa_waktu = $deUjian->lama-$diff_in_minutes;
        $ujian->save();

        return response()->json(['data' => $find, 'detail' => $ujian]);
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
                'mulai_ujian'   => '',
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
            'peserta_id'    => $request->peserta_id,
            'jawab_essy'    => null
        ])->get()->count();

        $benar = JawabanPeserta::where([
            'iscorrect'     => 1,
            'jadwal_id'     => $request->jadwal_id, 
            'peserta_id'    => $request->peserta_id
        ])->get()->count();
        
        $jml = JawabanPeserta::where([
            'jadwal_id'     => $request->jadwal_id, 
            'peserta_id'    => $request->peserta_id
        ])->get()->count();

        $hasil = ($benar/$jml)*100;

        HasilUjian::create([
            'peserta_id'      => $request->peserta_id,
            'jadwal_id'       => $request->jadwal_id,
            'jumlah_salah'    => $salah,
            'jumlah_benar'    => $benar,
            'tidak_diisi'     => 0,
            'hasil'           => $hasil,
        ]);

        return response()->json(['status' => 'finished']);
    }

    public function cekToken(Request $request)
    {
        $jadwal = UjianAktif::first();
        if($jadwal) {
            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', now());
            $from = $jadwal['updated_at']->format('Y-m-d H:i:s');
            $differ = $to->diffInSeconds($from);

            if($differ > 900) {
                $jadwal->token = strtoupper(Str::random(6));
                $jadwal->status_token = 0;
                $jadwal->save();
            }  
        }
        if($jadwal->token == $request->token) {
            if($jadwal->status_token != 1) {
                return response()->json(['status' => 'invalid']);
            }
            return response()->json(['status' =>'success']);
        }
        return response()->json(['status' => 'error']);
    }

    public function getUjianAktif()
    {
        $jadwal = UjianAktif::with(['jadwal','jadwal.banksoal'])
        ->select('ujian_id')->first();

        if($jadwal->jadwal->banksoal_id == 0) {
            $matpel = Matpel::where('jurusan_id', '=', auth()->guard('peserta-api')->user()->jurusan_id)->first();
        }
        else {
            $matpel = Matpel::find($jadwal->jadwal->banksoal->matpel_id);
        }

        return response()->json(['data' => $jadwal, 'matpel' => $matpel]);
    }

    public function mulaiPeserta(Request $request)
    {
        $peserta = SiswaUjian::where(['peserta_id' => $request->peserta_id])->first();
        $peserta->mulai_ujian = now()->format('H:i:s');
        $peserta->status_ujian = 3;
        $peserta->save();

        return response()->json(['status' => 'save']);
    }
}
