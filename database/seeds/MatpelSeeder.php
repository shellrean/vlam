<?php

use Illuminate\Database\Seeder;

use App\Matpel;

class MatpelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Matpel::create([
        	'kode_mapel'	=> 'KM001K',
        	'nama'			=> 'Bahasa Indonesia'
        ]);
    }
}
