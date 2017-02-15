<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Autenticación
Route::auth();
Route::resource('usuarios', 'Auth\AuthController');
Route::resource('roles', 'Auth\RolController');
Route::get('password/email/{USER_id}', 'Auth\PasswordController@sendEmail');
Route::get('password/reset/{USER_id}', 'Auth\PasswordController@showResetForm');

//Inicio
Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index');

//Ayuda
Route::get('/help', function(){
	return View::make('help');
});

//upload
Route::get('upload', 'UploadController@index');
Route::post('upload', 'UploadController@upload');

//Parametrizaciones
//Route::resource('estadosencuesta', 'EstadoEncuestaController');
//Route::resource('tipospregunta', 'TipoPreguntaController');

//Regionales
Route::resource('regionales', 'RegionalController');

//Agencias
Route::resource('agencias', 'AgenciaController');

//Certificados
Route::resource('certificados', 'CertificadoController');
Route::resource('certificados-borrados', 'CertificadoController@indexOnlyTrashed');

//Operadores
Route::resource('operadores', 'OperadorController');

//Exportar a Excel
Route::get('certificados/export/{ext}','ExportarInfoController@export');

/*

//Pregunta
Route::resource('encuestas/{ENCU_id}/pregs', 'PreguntaController');
Route::resource('encuestas/{ENCU_id}/pregs/ordenar', 'PreguntaController@ordenar');

//Respuesta
Route::resource('encuestas/{ENCU_id}/resps', 'RespuestaController');
Route::get('encuestas/{ENCU_id}/preview', 'RespuestaController@index')->name('preview');


//Menu
Route::get('menu', 'MenuController@index');


//https://laravel.com/docs/5.3/routing#route-group-prefixes
Route::group(['prefix' => 'admin'], function () {
	Route::get('users', function ()    {
		// Matches The "/admin/users" URL
	});
});
*/