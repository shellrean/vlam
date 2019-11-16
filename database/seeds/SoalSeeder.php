<?php

use Illuminate\Database\Seeder;

use App\Soal;

class SoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Soal::create([
        	'banksoal_id'		=> 1,
        	'pertanyaan'		=> "Peristiwa Rengasdengklok merupakan peristiwa penculikan Soekarno dan Bung Hatta ke Rengasdengklok yang terjadi pada tanggal 16 Agustus 1945. Penculikan tersebut dilakukan oleh kalangan pemuda dalam rangka mempercepat pelaksanaan proklamasi kemerdekaan Indonesia. Peristiwa ini dilatarbelakangi adanya perbedaan sikap antara kalangan tua dan pemuda tentang kapan proklamasi dilaksanakan. Tujuan dari peristiwa teresebut adalah untuk mengamankan Soekarno-Hatta agar tidak terpengaruh oleh Jepang dan proklamasi kemerdekaan segera dilakanakan. Dari deskripsi tersebut dapat disimpulkan bahwa sejarah menunjukkan sejarah sebagai peristiwa yang telah terjadi pada lampau, karena ....",
        ]);

        Soal::create([
        	'banksoal_id'		=> 1,
        	'pertanyaan'		=> "Ilmu sejarah merupakan suatu ilmu yang memiliki hubungan erat dengan kehidupan manusia. Setiap kehidupan manusia terdapat berbagai peristiwa. Oleh karena itu jika seorang sejarawan akan menulis kembali peristiwa tersebut terdapat beberpa konsep berfikir yang harus diterapkan. Salah satu konsep berfikir yang digunakan seorang sejarawan sinkronik, yaitu ....",
        ]);

        Soal::create([
        	'banksoal_id'		=> 1,
        	'pertanyaan'		=> "Proses masuk dan berkembangnya agama Islam di Indonesia telah membawa perubahan besar di dalam struktur sosial masyarakat Indonesia yang sebelumnya berkarakteristik Hindu-Buddha. Kehadiran agama Islam dapat diterima baik oleh sebagian besar masyarakat Indonesia. Faktor penyebab Islam berkembang pesat di Indonesia adalah ....",
        ]);

        Soal::create([
        	'banksoal_id'		=> 1,
        	'pertanyaan'		=> "Peninggalan kebudayaan manusia pra aksara seperti gerabah dan tembikar masih ada hingga sekarang, contohnya gentong, ulekan, dan kendi. Alasan kuat yang menyebabkan benda- benda tersebut masih digunakan hingga sekarang adalah….",
        ]);

        Soal::create([
        	'banksoal_id'		=> 1,
        	'pertanyaan'		=> "Berdasarkan tulisan-tilisan yang terdapat pada prasasti diketahui bahwa raja yang pernah memerintah di Tarumanegara adalah Raja Purnawarwan. Raja Purnawarwan merupakan raja besar yang telah berhasil meningkatkan kehidupan rakyatnya. Disebutkan bahwa kehidupan ekonomi kerajaan Tarumanegara telah teratur. Bukti dari penjelasanya tersebut adalah ...",
        ]);
    }
}
