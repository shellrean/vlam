<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', 'Auth\LoginController@login');
Route::post('/logedin','Auth\PesertaLoginController@login');

Route::group(['middlewarde' => 'peserta'], function() {
	Route::post('/logout','Auth\PesertaLoginController@logout');

	Route::get('/jadwal/getday', 'API\JadwalController@getday');
	Route::get('/jadwal/aktif', 'API\UjianController@getUjianAktif');

	Route::get('/ujian/{id}','API\UjianController@getsoal');
	Route::post('/ujian','API\UjianController@store');
	Route::get('/ujian/jawaban/{id}', 'API\UjianController@getJawabanPeserta');
	Route::post('/ujian/filled', 'API\UjianController@filled');
	Route::post('/ujian/sisa-waktu', 'API\UjianController@sisaWaktu');
	Route::post('/ujian/ujian-siswa-det', 'API\UjianController@detUjian');
	Route::post('/ujian/ragu-ragu', 'API\UjianController@setRagu');
	Route::post('/ujian/selesai', 'API\UjianController@selesai');
	Route::post('/ujian/cektoken','API\UjianController@cekToken');

	Route::post('/ujian/mulai-peserta', 'API\UjianController@mulaiPeserta');
});