<?php

use Illuminate\Database\Seeder;

use App\Banksoal;

class BanksoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
  		Banksoal::create([
	    	'kode_banksoal'		=> 'KBS-001',
	    	'matpel_id'			=> 1,
	    	'author'			=> 1,
	    ]);
    }
}
