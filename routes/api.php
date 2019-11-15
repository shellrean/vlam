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

Route::group(['middleware' => 'auth:api'], function() {
	Route::get('/settings', 'API\ReferenceController@setting');
	Route::post('/settings', 'API\ReferenceController@storeSetting');

	Route::resource('/banksoals', 'API\BanksoalController');
});