<?php

namespace reservas\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;

use reservas\Unidad;
use reservas\TipoUnidad;

class UnidadController extends Controller
{
	public function __construct(Redirector $redirect=null)
	{
		//Requiere que el usuario inicie sesión.
		$this->middleware('auth');
		if(isset($redirect)){

			$action = Route::currentRouteAction();
			$role = isset(auth()->user()->rol->ROLE_rol) ? auth()->user()->rol->ROLE_rol : 'user';

			//Lista de acciones que solo puede realizar los administradores o los editores
			$arrActionsAdmin = array('index', 'create', 'edit', 'store', 'show', 'destroy');

			if(in_array(explode("@", $action)[1], $arrActionsAdmin))//Si la acción del controlador se encuentra en la lista de acciones de admin...
			{
				if( ! in_array($role , ['admin','editor']))//Si el rol no es admin o editor, se niega el acceso.
				{
					Session::flash('error', '¡Usuario no tiene permisos!');
					abort(403, '¡Usuario no tiene permisos!.');
				}
			}
		}
	}

	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Se obtienen todos los registros.
		$unidades = Unidad::all();

		//Se carga la vista y se pasan los registros
		return view('unidad/index', compact('unidades'));
	}

	/**
	 * Muestra el formulario para crear un nuevo registro.
	 *
	 * @return Response
	 */
	public function create()
	{

		$tiposUnidades = TipoUnidad::all();
		$arrTiposUnidades = [];
		foreach ($tiposUnidades as $tipos) {
			$arrTiposUnidades = array_add(
				$arrTiposUnidades,
				$tipos->TIUN_id,
				$tipos->TIUN_descripcion
			);
		}

		return view('unidad/create', compact('arrTiposUnidades'));
	}

	/**
	 * Guarda el registro nuevo en la base de datos.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validación de datos
		$this->validate(request(), [
			'UNID_NOMBRE' => ['required', 'max:100'],
			'UNID_CODIGO' => ['required', 'max:40'],
			'UNID_TELEFONO' => ['required', 'max:30'],
			'UNID_EXTTELEFONO' => ['required', 'max:5'],
			'UNID_EMAIL' => ['required', 'email', 'max:100'],
			'UNID_UBICACION' => ['required', 'max:50'],
			'UNID_NIVEL' => ['required', 'max:10'],
			'UNID_ASOCIAPROGRAMADIRECTA' => ['boolean'],
			'UNID_ASOCIAMATERIADIRECTA' => ['boolean'],
			'UNID_REGIONAL' => ['boolean'],

			'TIUN_id' => ['required'],
		]);

		//Permite seleccionar los datos que se desean guardar.
		$unidad = new Unidad;
		$unidad->UNID_NOMBRE = Input::get('UNID_NOMBRE');
		$unidad->UNID_CODIGO = Input::get('UNID_CODIGO');
		$unidad->UNID_TELEFONO = Input::get('UNID_TELEFONO');
		$unidad->UNID_EXTTELEFONO = Input::get('UNID_EXTTELEFONO');
		$unidad->UNID_EMAIL = Input::get('UNID_EMAIL');
		$unidad->UNID_UBICACION = Input::get('UNID_UBICACION');
		$unidad->UNID_NIVEL = Input::get('UNID_NIVEL');

		$unidad->UNID_ASOCIAPROGRAMADIRECTA =  (Input::get('UNID_ASOCIAPROGRAMADIRECTA')) ? true : false;
		$unidad->UNID_ASOCIAMATERIADIRECTA =  (Input::get('UNID_ASOCIAMATERIADIRECTA')) ? true : false;
		$unidad->UNID_REGIONAL =  (Input::get('UNID_REGIONAL')) ? true : false;

		$unidad->TIUN_id = Input::get('TIUN_id'); //Relación con TipoUnidad
		$unidad->UNID_creadopor = auth()->user()->username;
		//Se guarda modelo
		$unidad->save();

		// redirecciona al index de controlador
		Session::flash('message', 'Unidad '.$unidad->UNID_id.' creada exitosamente!');
		return redirect()->to('unidad');
	}


	/**
	 * Muestra información de un registro.
	 *
	 * @param  int  $UNID_id
	 * @return Response
	 */
	public function show($UNID_id)
	{
		// Se obtiene el registro
		$unidad = Unidad::findOrFail($UNID_id);

		// Muestra la vista y pasa el registro
		return view('unidad/show', compact('unidad'));
	}


	/**
	 * Muestra el formulario para editar un registro en particular.
	 *
	 * @param  int  $UNID_id
	 * @return Response
	 */
	public function edit($UNID_id)
	{
		// Se obtiene el registro
		$unidad = Unidad::findOrFail($UNID_id);

		$tiposUnidades = TipoUnidad::all();
		$arrTiposUnidades = [];
		foreach ($tiposUnidades as $tipos) {
			$arrTiposUnidades = array_add(
				$arrTiposUnidades,
				$tipos->TIUN_id,
				$tipos->TIUN_descripcion
			);
		}

		// Muestra el formulario de edición y pasa el registro a editar
		return view('unidad/edit', compact('unidad', 'arrTiposUnidades'));
	}


	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $UNID_id
	 * @return Response
	 */
	public function update($UNID_id)
	{
		//Validación de datos
		$this->validate(request(), [
			'UNID_NOMBRE' => ['required', 'max:100'],
			'UNID_CODIGO' => ['required', 'max:40'],
			'UNID_TELEFONO' => ['required', 'max:30'],
			'UNID_EXTTELEFONO' => ['required', 'max:5'],
			'UNID_EMAIL' => ['required', 'email', 'max:100'],
			'UNID_UBICACION' => ['required', 'max:50'],
			'UNID_NIVEL' => ['required', 'max:10'],
			'UNID_ASOCIAPROGRAMADIRECTA' => ['boolean'],
			'UNID_ASOCIAMATERIADIRECTA' => ['boolean'],
			'UNID_REGIONAL' => ['boolean'],

			'TIUN_id' => ['required'],
		]);

		// Se obtiene el registro
		$unidad = Unidad::findOrFail($UNID_id);

		$unidad->UNID_NOMBRE = Input::get('UNID_NOMBRE');
		$unidad->UNID_CODIGO = Input::get('UNID_CODIGO');
		$unidad->UNID_TELEFONO = Input::get('UNID_TELEFONO');
		$unidad->UNID_EXTTELEFONO = Input::get('UNID_EXTTELEFONO');
		$unidad->UNID_EMAIL = Input::get('UNID_EMAIL');
		$unidad->UNID_UBICACION = Input::get('UNID_UBICACION');
		$unidad->UNID_NIVEL = Input::get('UNID_NIVEL');

		$unidad->UNID_ASOCIAPROGRAMADIRECTA =  (Input::get('UNID_ASOCIAPROGRAMADIRECTA')) ? true : false;
		$unidad->UNID_ASOCIAMATERIADIRECTA =  (Input::get('UNID_ASOCIAMATERIADIRECTA')) ? true : false;
		$unidad->UNID_REGIONAL =  (Input::get('UNID_REGIONAL')) ? true : false;

		$unidad->TIUN_id = Input::get('TIUN_id'); //Relación con TipoUnidad
		$unidad->UNID_modificadopor = auth()->user()->username;
		//Se guarda modelo
		$unidad->save();

		// redirecciona al index de controlador
		Session::flash('message', 'Unidad '.$unidad->UNID_id.' modificada exitosamente!');
		return redirect()->to('unidad');
	}

	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $UNID_id
	 * @return Response
	 */
	public function destroy($UNID_id, $showMsg=True)
	{
		$unidad = Unidad::findOrFail($UNID_id);

		// delete
		$unidad->UNID_eliminadopor = auth()->user()->username;
		$unidad->save();
		$unidad->delete();

		// redirecciona al index de controlador
		if($showMsg){
			Session::flash('message', 'Unidad '.$unidad->UNID_id.' eliminada exitosamente!');
			return redirect()->to('unidad');
		}
	}


}

