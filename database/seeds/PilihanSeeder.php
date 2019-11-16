<?php

use Illuminate\Database\Seeder;

use App\JawabanSoal;

class PilihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JawabanSoal::create([
        	'soal_id'		=> 1,
        	'text_jawaban'  => "peristiwa sejarah ditempatkan sebagai fakta, kejadian dan kenytaan yang benar-benar terjadi pada masa lampau",
        	'correct'		=> 1
        ]);

        JawabanSoal::create([
        	'soal_id'		=> 1,
        	'text_jawaban'  => "peristiwa merupakan rekonstruksi peristiwa sejarah yang dialami bangsa Indonesia untuk bangkit dari penjajah",
        	'correct'		=> 0
        ]);

        JawabanSoal::create([
        	'soal_id'		=> 2,
        	'text_jawaban'  => "mengutamakan urutan terjadi peristiwa-peristiwa sejarah",
        	'correct'		=> 0
        ]);

        JawabanSoal::create([
        	'soal_id'		=> 2,
        	'text_jawaban'  => "mengkaji peristiwa sejarah yang terjadi pada masa tertentu",
        	'correct'		=> 1
        ]);


        JawabanSoal::create([
        	'soal_id'		=> 3,
        	'text_jawaban'  => "penyebaran agama Islam di masyarakt dilakukan secara damai",
        	'correct'		=> 0
        ]);


        JawabanSoal::create([
        	'soal_id'		=> 3,
        	'text_jawaban'  => "ajaran agama Islam mudah dipelajari oleh bangsa Indonesia",
        	'correct'		=> 0
        ]);


        JawabanSoal::create([
        	'soal_id'		=> 4,
        	'text_jawaban'  => "benda-benda tersebut merupakan barang antik",
        	'correct'		=> 0
        ]);


        JawabanSoal::create([
        	'soal_id'		=> 4,
        	'text_jawaban'  => "benda-benda tersebut masih dimanfaatkan oleh manusia ",
        	'correct'		=> 1
        ]);


        JawabanSoal::create([
        	'soal_id'		=> 5,
        	'text_jawaban'  => "wilayah kekuasaan kerajaan Tarumanegara meliputi seluruh Jawa bagian barat dan pantai utara Jawa",
        	'correct'		=> 1
        ]);


        JawabanSoal::create([
        	'soal_id'		=> 5,
        	'text_jawaban'  => "dibangunya terusan sepanjang 6122 tombak sebagai sarana mencegah banjir dan pelayaran",
        	'correct'		=> 0
        ]);


    }
}
