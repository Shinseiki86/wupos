<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*************  Routes del sistema  *************/
// Authentication Routes...
	Auth::routes();
	Route::get('password/email/{id}', 'Auth\ForgotPasswordController@sendEmail');
	Route::get('password/reset/{id}', 'Auth\ForgotPasswordController@showResetForm');

	Route::group(['prefix'=>'auth', 'as'=>'auth.', 'namespace'=>'Auth'], function() {
		Route::resource('usuarios', 'RegisterController');
		Route::resource('roles', 'RoleController');
		Route::resource('permisos', 'PermissionController');
	});

	//Dashboard
	Route::get('getDashboardUsuariosPorRol', 'Auth\RoleController@getUsuariosPorRol');


	//Página principal. Si el usuario es admin, se muestra el dashboard.
	Route::group(['middleware'=>'auth'], function() {
		Route::get('/', function(){
			if(Entrust::hasRole(['owner','admin','gesthum']))
				return view('dashboard/charts');
			return view('layouts.menu');
		});
		Route::get('getArrModel', 'Controller@ajax');
	});

	//Admn App
	Route::group(['prefix'=>'app', 'as'=>'app.', 'namespace'=>'App'], function() {
		Route::resource('menu', 'MenuController', ['parameters'=>['menu'=>'MENU_ID']]);
		Route::resource('parametersglobal', 'ParameterGlobalController', ['parameters'=>['parametersglobal'=>'PGLO_ID']]);
		Route::post('menu/reorder', 'MenuController@reorder')->name('menu.reorder');
		Route::get('upload', 'UploadDataController@index')->name('upload.index');
		Route::post('upload', 'UploadDataController@upload')->name('upload');

		//Route::get('createFromAjax/{model}', 'ModelController@createFromAjax')->name('createFromAjax');
	});

	//Reportes
	Route::group(['prefix'=>'reports', 'as'=>'reports.', 'namespace'=>'Report'], function() {
		Route::get('/', 'ReportController@index')->name('index');
		Route::get('/viewForm', 'ReportController@viewForm')->name('viewForm');
		Route::post('getData/{controller}/{action}', 'ReportController@getData')->name('getData');
	});

/*************  Fin Routes del sistema  *************/


//Gyf
	Route::group(['prefix'=>'gyf', 'as'=>'gyf.', 'namespace'=>'Gyf'], function() {
		//Parametrizaciones
		Route::resource('regionales', 'RegionalController');
		Route::get('regionales.getData', 'RegionalController@getData')->name('regionales.getData');
		Route::resource('agencias', 'AgenciaController');
		Route::get('agencias.getData', 'AgenciaController@getData')->name('agencias.getData');

	});

//WU
	Route::group(['prefix'=>'wu', 'as'=>'wu.', 'namespace'=>'Wu'], function() {
		//Operadores
		Route::resource('operadores', 'OperadorController', ['parameters'=>['operadores'=>'operador']]);
		Route::get('operadores.getData', 'OperadorController@getData')->name('operadores.getData');

		//Route::delete('{OPER_id}/pendBorrar', 'OperadorController@cambiarEstado');
		//Route::get('{OPER_id}/restore', 'OperadorController@restore');
		//Route::delete('papelera/vaciar', 'OperadorController@vaciarPapelera');
		//Route::get('papelera', 'OperadorController@indexOnlyTrashed')->name('trash');
		//Route::post('createFromAjax', 'OperadorController@createFromAjax')->name('createFromAjax');
		//Route::get('export/{ESOP_id}','ExportarInfoController@exportOperadores');

		/*//Certificados
		Route::resource('certificados', 'CertificadoController', ['parameters'=>['certificados' => 'CERT_id']]);
		Route::group(['as' => 'certificados.', 'prefix' => 'certificados'], function () {
			Route::get('{CERT_id}/restore', 'CertificadoController@restore');
			Route::get('papelera', 'CertificadoController@indexOnlyTrashed');
			Route::delete('papelera/vaciar', 'CertificadoController@vaciarPapelera');
			Route::get('export/{ext}','ExportarInfoController@exportCertificados');
		});*/

	});

/*//Zabbix
	Route::group(['as' => 'zabbix.', 'prefix' => 'zabbix'], function () {
		Route::get('servers', 'ZabbixController@indexServers')->name('servers');
		Route::get('redes', 'ZabbixController@indexRedes')->name('redes');
	});
*/