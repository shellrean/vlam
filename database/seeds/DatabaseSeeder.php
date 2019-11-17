<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(MatpelSeeder::class);
        $this->call(BanksoalSeeder::class);
        $this->call(SoalSeeder::class);
        $this->call(PilihanSeeder::class);
    }
}
