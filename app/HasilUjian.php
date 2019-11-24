<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    protected $fillable = [
    	'peserta_id','jadwal_id','jumlah_salah','jumlah_benar','tidak_diisi','hasil'
    ];
}
