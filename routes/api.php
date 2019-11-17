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

Route::group(['middleare' => 'peserta'], function() {

	Route::get('/jadwal/getday', 'API\JadwalController@getday');

	Route::get('/ujian/{id}','API\UjianController@getsoal');
	Route::post('/ujian','API\UjianController@store');
	Route::get('/ujian/jawaban/{id}', 'API\UjianController@getJawabanPeserta');
	Route::post('/ujian/filled', 'API\UjianController@filled');

});

Route::group(['middleware' => 'auth:api'], function() {
	Route::get('/settings', 'API\ReferenceController@setting');
	Route::post('/settings', 'API\ReferenceController@storeSetting');

	Route::resource('/banksoals', 'API\BanksoalController');
	Route::get('/banksoals/{id}', 'API\SoalController@showByBanksoal');

	
	Route::post('/ujian/daftar', 'API\UjianController@getListUjian');

	Route::resource('/matpel', 'API\MatpelController');

	Route::resource('/kelas', 'API\KelasController');

	Route::resource('/jadwal', 'API\JadwalController');
});
