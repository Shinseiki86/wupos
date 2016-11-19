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

//Inicio
Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index');

//Ayuda
Route::get('/help', function(){
	return View::make('help');
});


//Parametrizaciones
//Route::resource('estadosencuesta', 'EstadoEncuestaController');
//Route::resource('tipospregunta', 'TipoPreguntaController');


//Regionales
Route::resource('regionales', 'RegionalController');

//Agencias
Route::resource('agencias', 'AgenciaController');



/*

//Pregunta
Route::resource('encuestas/{ENCU_id}/pregs', 'PreguntaController');
Route::resource('encuestas/{ENCU_id}/pregs/ordenar', 'PreguntaController@ordenar');

//Respuesta
Route::resource('encuestas/{ENCU_id}/resps', 'RespuestaController');
Route::get('encuestas/{ENCU_id}/preview', 'RespuestaController@index')->name('preview');

//Exportar a Excel
Route::get('encuestas/{ENCU_id}/excel','ExportarInfoController@exportXLS');
//Exportar a CSV
Route::get('encuestas/{ENCU_id}/csv','ExportarInfoController@exportCSV');
//Exportar a PDF
Route::get('encuestas/{ENCU_id}/pdf','ExportarInfoController@exportPDF');


//Menu
Route::get('menu', 'MenuController@index');


//https://laravel.com/docs/5.3/routing#route-group-prefixes
Route::group(['prefix' => 'admin'], function () {
	Route::get('users', function ()    {
		// Matches The "/admin/users" URL
	});
});
*/