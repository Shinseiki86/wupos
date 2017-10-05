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
Route::resource('usuarios', 'Auth\AuthController', [
	'parameters'=>['usuarios' => 'USER_id']
]);
Route::resource('roles', 'Auth\RolController', [
	'except' => ['show'],
	'parameters' => ['roles' => 'ROLE_id']
]);
Route::get('password/email/{USER_id}', 'Auth\PasswordController@sendEmail')->where('USER_id', '[0-9]+');
Route::get('password/reset/{USER_id}', 'Auth\PasswordController@showResetForm')->where('USER_id', '[0-9]+');

//Inicio
Route::get('/', 'HomeController@index')->name('home');

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
Route::resource('certificados', 'CertificadoController', [
	'parameters'=>['certificados' => 'CERT_id']
]);
Route::get('certificados/{CERT_id}/restore', 'CertificadoController@restore');
Route::get('certificados-borrados', 'CertificadoController@indexOnlyTrashed');
Route::delete('certificados-borrados/vaciarPapelera', 'CertificadoController@vaciarPapelera');

//Operadores
Route::resource('operadores', 'OperadorController', [
	'parameters'=>['operadores' => 'OPER_id']
]);
Route::delete('operadores/{OPER_id}/pendBorrar', 'OperadorController@cambiarEstado');
Route::get('operadores/{OPER_id}/restore', 'OperadorController@restore');
Route::get('operadores-borrados', 'OperadorController@indexOnlyTrashed');
Route::delete('operadores-borrados/vaciarPapelera', 'OperadorController@vaciarPapelera');

//Exportar a Excel
Route::get('certificados/export/{ext}','ExportarInfoController@exportCertificados');
Route::get('operadores/export/{ESOP_id}','ExportarInfoController@exportOperadores');

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