<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banksoal extends Model
{
	protected $fillable = [
		'kode_banksoal','kelas_id','author','matpel_id'
	];

    public function pertanyaans()
    {
    	return $this->hasMany('App\Soal', 'banksoal_id','id');
    }

    public function matpel()
    {
    	return $this->belongsTo('App\Matpel','matpel_id');
    }
}
