<?php

namespace Wupos\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;

use Wupos\Operador;
use Wupos\Regional;
use Wupos\EstadoOperador;

class OperadorController extends Controller
{
	public function __construct(Redirector $redirect=null)
	{
		//Requiere que el usuario inicie sesión.
		$this->middleware('auth');
		if(!auth()->guest() && isset($redirect)){

			$action = Route::currentRouteAction();
			$role = isset(auth()->user()->rol->ROLE_rol) ? auth()->user()->rol->ROLE_rol : 'user';

			//Lista de acciones que solo puede realizar los administradores o los editores
			$arrActionsAdmin = [ 'create', 'edit', 'store', 'update', 'destroy' ];

			if(in_array(explode("@", $action)[1], $arrActionsAdmin))//Si la acción del controlador se encuentra en la lista de acciones de admin...
			{
				if( ! in_array($role , ['admin','editor']))//Si el rol no es admin o editor, se niega el acceso.
				{
					Session::flash('alert-danger', '¡Usuario no tiene permisos!');
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
		$operadores = Operador::orderBy('OPER_id')
						->join('REGIONALES', 'REGIONALES.REGI_id', '=', 'OPERADORES.REGI_id')
						->get();

		//Se crea un array con los estados disponibles
		$arrRegionales = model_to_array(Regional::class, 'REGI_nombre');

		//Se crea un array con los estados disponibles
		$arrEstados = model_to_array(EstadoOperador::class, 'ESOP_descripcion');

		//Se carga la vista y se pasan los registros
		return view('operadores/index', compact('operadores', 'arrRegionales', 'arrEstados'));
	}

	/**
	 * Muestra el formulario para crear un nuevo registro.
	 *
	 * @return Response
	 */
	public function create()
	{

		//Se crea un array con los estados disponibles
		$arrRegionales = model_to_array(Regional::class, 'REGI_nombre');

		//Se crea un array con los estados disponibles
		$arrEstados = model_to_array(EstadoOperador::class, 'ESOP_descripcion');

		return view('operadores/create', compact('arrRegionales', 'arrEstados'));
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
			'OPER_codigo' => ['required', 'numeric', 'digits_between:1,3'],
			'OPER_cedula' => ['required', 'numeric', 'digits_between:1,15'],
			'OPER_nombre' => ['required', 'string', 'max:100'],
			'OPER_apellido' => ['required', 'string', 'max:100'],
			'REGI_id' => ['required', 'numeric'],
			'ESOP_id' => ['required', 'numeric'],
		]);


		//Permite seleccionar los datos que se desean guardar.
		$operador = Operador::create(
			array_merge(
				request()->except(['_token']) ,
				['OPER_creadopor' => auth()->user()->username]
			)
		);


		// redirecciona al index de controlador
		Session::flash('alert-success', 'Operador '.$operador->OPER_codigo.' creado exitosamente!');
		return redirect()->to('operadores');
	}


	/**
	 * Muestra información de un registro.
	 *
	 * @param  int  $OPER_id
	 * @return Response
	 */
	public function show($OPER_id)
	{
		// Se obtiene el registro
		$operador = Operador::findOrFail($OPER_id);

		// Muestra la vista y pasa el registro
		return view('operadores/show', compact('operador'));
	}


	/**
	 * Muestra el formulario para editar un registro en particular.
	 *
	 * @param  int  $OPER_id
	 * @return Response
	 */
	public function edit($OPER_id)
	{
		// Se obtiene el registro
		$operador = Operador::findOrFail($OPER_id);

		//Se crea un array con los estados disponibles
		$arrRegionales = model_to_array(Regional::class, 'REGI_nombre');

		//Se crea un array con los estados disponibles
		$arrEstados = model_to_array(EstadoOperador::class, 'ESOP_descripcion');

		// Muestra el formulario de edición y pasa el registro a editar
		return view('operadores/edit', compact('operador', 'arrRegionales', 'arrEstados'));
	}


	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $OPER_id
	 * @return Response
	 */
	public function update($OPER_id)
	{
		//Validación de datos
		$this->validate(request(), [
			'OPER_codigo' => ['required', 'numeric', 'digits_between:1,3'],
			'OPER_cedula' => ['required', 'numeric', 'digits_between:1,15'],
			'OPER_nombre' => ['required', 'string', 'max:100'],
			'OPER_apellido' => ['required', 'string', 'max:100'],
			'REGI_id' => ['required', 'numeric'],
			'ESOP_id' => ['required', 'numeric'],
		]);

		// Se obtiene el registro
		$operador = Operador::findOrFail($OPER_id);

		//Se asignan valores del request al modelo encontrado
		$operador->fill(
			array_merge(
				request()->except(['_token']) ,
				['OPER_modificadopor' => auth()->user()->username]
			)
		);

		//Se guarda modelo
		$operador->save();

		// redirecciona al index de controlador
		Session::flash('alert-success', 'Operador '.$operador->OPER_codigo.' modificado exitosamente!');
		return redirect()->to('operadores');
	}

	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $OPER_id
	 * @return Response
	 */
	public function destroy($OPER_id, $showMsg=True)
	{
		$operador = Operador::findOrFail($OPER_id);

		// delete
		$operador->OPER_eliminadopor = auth()->user()->username;
		$operador->save();
		$operador->delete();

		// redirecciona al index de controlador
		if($showMsg){
			Session::flash('alert-success', 'Operador '.$operador->OPER_codigo.' eliminado exitosamente!');
			return redirect()->to('operadores');
		}
	}


}

