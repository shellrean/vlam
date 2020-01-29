<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
    	'banksoal_id','lama','token','status_ujian','tanggal','mulai','berakhir', 'jadwal_id'
    ];

    protected $hidden = [
    	'token','created_at','updated_at'
    ];

    public function banksoal() 
    {
    	return $this->hasOne('App\Banksoal','id','banksoal_id');
    }

}
