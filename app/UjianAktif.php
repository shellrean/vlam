<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UjianAktif extends Model
{
    protected $table = 'ujian_aktif';

    public function jadwal()
    {
    	return $this->belongsTo('App\Jadwal','ujian_id','id');
    }
}
