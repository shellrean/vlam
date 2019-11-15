<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JawabanPeserta extends Model
{
    protected $fillable = [
    	'banksoal_id','soal_id','jawab','iscorrect'
    ];
}
