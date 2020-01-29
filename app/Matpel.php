<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matpel extends Model
{
    protected $fillable = [
    	'kode_mapel','nama'
    ];

   	protected $hidden = [
   		'created_at','updated_at'
   	];
}
