<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Peserta;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' 		=> 'Shellrean Co',
            'email' 	=> 'admin@shellrean.xyz',
            'email_verified_at' => now(),
            'password' 	=> bcrypt('secret'),
            'role' 		=> 0
        ]);

        Peserta::create([
            'no_ujian'  => 'K01040026',
            'nama'      => 'KUSWANDI',
            'password'  => '7813',
        ]);
    }
}
