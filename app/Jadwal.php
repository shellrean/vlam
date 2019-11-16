<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
	protected $appends = ['status'];

    protected $fillable = [
    	'banksoal_id','lama','token','status_ujian','tanggal','mulai','berakhir'
    ];

    public function banksoal() 
    {
    	return $this->hasOne('App\Banksoal','id','banksoal_id');
    }

    public function getStatusAttribute() 
    {
    	if($this->berakhir < now()->format('H:i:s') || $this->mulai > now()->format('H:i:s')) {
    		$stat = 0;
    	}
    	else {
    		$stat = 1;
    	}
    	return $stat;
    }
}
