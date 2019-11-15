<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $fillable = [
    	'nama','no_ujian','password','api_token'
    ];
}
