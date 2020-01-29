<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Peserta extends Authenticatable
{
	use Notifiable;

    protected $fillable = [
    	'nama','no_ujian','password','api_token'
    ];

    public function username()
    {
    	return 'no_ujian';
    }
}
