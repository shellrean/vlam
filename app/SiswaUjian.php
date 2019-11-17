<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiswaUjian extends Model
{
    protected $fillable = [
    	'peserta_id','jadwal_id','mulai_ujian','sisa_waktu','status_ujian'
    ];


}
