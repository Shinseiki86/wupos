<?php

namespace Wupos\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;

use Wupos\Agencia;
use Wupos\Regional;

class AgenciaController extends Controller
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
		$agencias = Agencia::orderBy('AGEN_id')->get();

		//Se carga la vista y se pasan los registros
		return view('agencias/index', compact('agencias'));
	}

	/**
	 * Muestra el formulario para crear un nuevo registro.
	 *
	 * @return Response
	 */
	public function create()
	{

		$regionales = Regional::orderBy('REGI_id')
								->select('REGI_id', 'REGI_nombre')
								->get();

		$arrRegionales = [];
		foreach ($regionales as $reg) {
			$arrRegionales = array_add(
				$arrRegionales,
				$reg->REGI_id,
				$reg->REGI_nombre
			);
		}

		return view('agencias/create', compact('arrRegionales'));
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
			'AGEN_codigo' => ['required', 'numeric', 'unique:AGENCIAS'],
			'AGEN_nombre' => ['required', 'max:100'],
			'AGEN_descripcion' => ['max:250'],
			'REGI_id' => ['required', 'numeric'],
		]);

		//Permite seleccionar los datos que se desean guardar.
		$agencia = new Agencia;
		$agencia->AGEN_codigo = Input::get('AGEN_codigo');
		$agencia->AGEN_nombre = Input::get('AGEN_nombre');
		$agencia->AGEN_descripcion = Input::get('AGEN_descripcion');
		$agencia->AGEN_cuentawu = Input::get('AGEN_cuentawu');
		$agencia->AGEN_activa =  (Input::get('AGEN_activa')) ? true : false;
		$agencia->REGI_id = Input::get('REGI_id'); //Relación con Regional
		$agencia->AGEN_creadopor = auth()->user()->username;

		//Se guarda modelo
		$agencia->save();

		// redirecciona al index de controlador
		Session::flash('message', 'Agencia '.$agencia->AGEN_id.' creada exitosamente!');
		return redirect()->to('agencias');
	}


	/**
	 * Muestra información de un registro.
	 *
	 * @param  int  $AGEN_id
	 * @return Response
	 */
	public function show($AGEN_id)
	{
		// Se obtiene el registro
		$agencia = Agencia::findOrFail($AGEN_id);

		// Muestra la vista y pasa el registro
		return view('agencias/show', compact('agencia'));
	}


	/**
	 * Muestra el formulario para editar un registro en particular.
	 *
	 * @param  int  $AGEN_id
	 * @return Response
	 */
	public function edit($AGEN_id)
	{
		// Se obtiene el registro
		$agencia = Agencia::findOrFail($AGEN_id);

		$regionales = Regional::all();
		$arrRegionales = [];
		foreach ($regionales as $reg) {
			$arrRegionales = array_add(
				$arrRegionales,
				$reg->REGI_id,
				$reg->REGI_nombre
			);
		}

		// Muestra el formulario de edición y pasa el registro a editar
		return view('agencias/edit', compact('agencia', 'arrRegionales'));
	}


	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $AGEN_id
	 * @return Response
	 */
	public function update($AGEN_id)
	{
		//Validación de datos
		$this->validate(request(), [
			'AGEN_codigo' => ['required', 'numeric'],
			'AGEN_nombre' => ['required', 'max:100'],
			'AGEN_descripcion' => ['max:250'],
			'REGI_id' => ['required'],
		]);

		// Se obtiene el registro
		$agencia = Agencia::findOrFail($AGEN_id);
		$agencia->AGEN_codigo = Input::get('AGEN_codigo');
		$agencia->AGEN_nombre = Input::get('AGEN_nombre');
		$agencia->AGEN_descripcion = Input::get('AGEN_descripcion');
		$agencia->AGEN_cuentawu = Input::get('AGEN_cuentawu');
		$agencia->AGEN_activa =  (Input::get('AGEN_activa')) ? true : false;
		$agencia->REGI_id = Input::get('REGI_id'); //Relación con Regional

		$agencia->AGEN_modificadopor = auth()->user()->username;
		//Se guarda modelo
		$agencia->save();

		// redirecciona al index de controlador
		Session::flash('message', 'Agencia '.$agencia->AGEN_id.' modificada exitosamente!');
		return redirect()->to('agencias');
	}

	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $AGEN_id
	 * @return Response
	 */
	public function destroy($AGEN_id, $showMsg=True)
	{
		$agencia = Agencia::findOrFail($AGEN_id);

		// delete
		$agencia->AGEN_eliminadopor = auth()->user()->username;
		$agencia->save();
		$agencia->delete();

		// redirecciona al index de controlador
		if($showMsg){
			Session::flash('message', 'Agencia '.$agencia->AGEN_id.' eliminada exitosamente!');
			return redirect()->to('agencias');
		}
	}


}

