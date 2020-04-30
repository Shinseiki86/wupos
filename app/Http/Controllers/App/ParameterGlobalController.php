<?php

namespace App\Http\Controllers\App;

use App\Http\Requests;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;

use App\Models\ParameterGlobal;

class ParameterGlobalController extends Controller
{
	protected $route = 'app.parametersglobal';
	protected $class = ParameterGlobal::class;

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:app-parameterglobal');
	}

	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Se obtienen todos los registros.
		$parametersglobal = ParameterGlobal::all();
		//Se carga la vista y se pasan los registros
		return view($this->route.'.index', compact('parametersglobal'));
	}

	/**
	 * Muestra el formulario para crear un nuevo registro.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view($this->route.'.create');
	}

	/**
	 * Guarda el registro nuevo en la base de datos.
	 *
	 * @return Response
	 */
	public function store()
	{
		parent::storeModel();
	}


	/**
	 * Muestra el formulario para editar un registro en particular.
	 *
	 * @param  int  $PGLO_ID
	 * @return Response
	 */
	public function edit($PGLO_ID)
	{
		// Se obtiene el registro
		$parameterglobal = ParameterGlobal::findOrFail($PGLO_ID);

		// Muestra el formulario de edición y pasa el registro a editar
		return view($this->route.'.edit', compact('parameterglobal'));
	}


	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $PGLO_ID
	 * @return Response
	 */
	public function update($PGLO_ID)
	{
		parent::updateModel($PGLO_ID);
	}

	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $PGLO_ID
	 * @return Response
	 */
	public function destroy($PGLO_ID)
	{
		parent::destroyModel($PGLO_ID);
	}
	
}
