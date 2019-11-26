<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JawabanSoal extends Model
{
    protected $fillable = [
    	'soal_id','text_jawaban','correct'
    ];

    protected $hidden = [
    	'correct'
    ];
}
