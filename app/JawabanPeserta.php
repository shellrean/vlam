<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JawabanPeserta extends Model
{
    protected $fillable = [
    	'banksoal_id','soal_id','jawab','iscorrect','peserta_id','jadwal_id','ragu_ragu'
    ];

    protected $hidden = [
    	'iscorrect','created_at','updated_at'
    ];

    public function soal()
    {
    	return $this->belongsTo('App\Soal','soal_id');
    }
}
