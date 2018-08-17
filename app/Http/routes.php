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

Route::resource('regionales', 'RegionalController');
Route::resource('agencias', 'AgenciaController');

//Certificados
Route::resource('certificados', 'CertificadoController', ['parameters'=>['certificados' => 'CERT_id']]);
Route::group(['as' => 'certificados.', 'prefix' => 'certificados'], function () {
	Route::get('{CERT_id}/restore', 'CertificadoController@restore');
	Route::get('papelera', 'CertificadoController@indexOnlyTrashed');
	Route::delete('papelera/vaciar', 'CertificadoController@vaciarPapelera');
	Route::get('export/{ext}','ExportarInfoController@exportCertificados');
});

//Operadores
Route::resource('operadores', 'OperadorController', ['parameters'=>['operadores' => 'OPER_id']]);
Route::group(['as' => 'operadores.', 'prefix' => 'operadores'], function () {
	Route::delete('{OPER_id}/pendBorrar', 'OperadorController@cambiarEstado');
	Route::get('{OPER_id}/restore', 'OperadorController@restore');
	Route::delete('papelera/vaciar', 'OperadorController@vaciarPapelera');
	Route::get('papelera', 'OperadorController@indexOnlyTrashed')->name('trash');
	Route::post('createFromAjax', 'OperadorController@createFromAjax')->name('createFromAjax');
	Route::get('export/{ESOP_id}','ExportarInfoController@exportOperadores');
});


//Zabbix
Route::group(['as' => 'zabbix.', 'prefix' => 'zabbix'], function () {
	Route::get('servers', 'ZabbixController@indexServers')->name('servers');
	Route::get('redes', 'ZabbixController@indexRedes')->name('redes');
});


//https://laravel.com/docs/5.3/routing#route-group-prefixes
Route::group(['prefix' => 'admin'], function () {
	Route::get('users', function ()    {
		// Matches The "/admin/users" URL
	});
});