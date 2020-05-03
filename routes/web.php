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
	Route::get('getDashboardUsuariosPorRol', 'Auth\RoleController@getUsuariosPorRol')->name('dashboard.users.role');


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
		Route::resource('operadores', 'OperadorController', ['parameters'=>['operadores'=>'operador'], 'except'=>['show']]);
		Route::group(['prefix'=>'operadores', 'as'=>'operadores.'], function() {
			Route::get('getData', 'OperadorController@getData')->name('getData');

			Route::put('restore/{operador}', 'OperadorController@restore')->name('restore');
			Route::group(['prefix'=>'trash', 'middleware'=>['permission:operador-restore']], function() {	
				Route::get('/', 'OperadorController@index')->defaults('trash', true)->name('trash');
				Route::delete('/{operador}', 'OperadorController@forceDelete')->name('forceDelete');
				Route::post('/', 'OperadorController@emptyTrash')->name('emptyTrash');
			});
		});

		Route::resource('certificados', 'CertificadoController', ['except'=>['show']]);
		Route::group(['prefix'=>'certificados', 'as'=>'certificados.'], function() {
			Route::get('getData', 'CertificadoController@getData')->name('getData');
			Route::get('filterAgencia', 'CertificadoController@filterAgencia')->name('filterAgencia');

			Route::put('restore/{certificado}', 'CertificadoController@restore')->name('restore');
			Route::group(['prefix'=>'trash', 'middleware'=>['permission:certificado-restore']], function() {	
				Route::get('/', 'CertificadoController@index')->defaults('trash', true)->name('trash');
				Route::delete('/{certificado}', 'CertificadoController@forceDelete')->name('forceDelete');
				Route::post('/', 'CertificadoController@emptyTrash')->name('emptyTrash');
			});

		});

		//Dashboard
		Route::get('getOperadoresPorRegional', 'OperadorController@getOperadoresPorRegional')->name('dashboard.operadores.regional');
		Route::get('getCertificadosPorRegional', 'CertificadoController@getCertificadosPorRegional')->name('dashboard.certificados.regional');


		//Route::post('createFromAjax', 'OperadorController@createFromAjax')->name('createFromAjax');
		//Route::get('export/{ESOP_id}','ExportarInfoController@exportOperadores');

		/*//Certificados
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