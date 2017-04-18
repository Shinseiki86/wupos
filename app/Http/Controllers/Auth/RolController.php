<?php

namespace Wupos\Http\Controllers\Auth;

use Wupos\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;

use Wupos\Rol;

class RolController extends Controller
{
	public function __construct(Redirector $redirect=null)
	{
		//Requiere que el usuario inicie sesión.
		$this->middleware('auth');
		
		if(!auth()->guest() && isset($redirect)){
			$action = Route::currentRouteAction();
			$role = isset(auth()->user()->rol->ROLE_rol) ? auth()->user()->rol->ROLE_rol : 'user';

			//Lista de acciones que solo puede realizar los administradores o los editores
			$arrActionsAdmin = array('index', 'create', 'edit', 'store', 'show', 'destroy');

			if(in_array(explode("@", $action)[1], $arrActionsAdmin))//Si la acción del controlador se encuentra en la lista de acciones de admin...
			{
				if( ! in_array($role , ['admin']))//Si el rol no es admin, se niega el acceso.
				{
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
		$roles = Rol::orderBy('ROLE_id')->get();
		//Se carga la vista y se pasan los registros
		return view('auth/roles/index', compact('roles'));
	}

	/**
	 * Muestra el formulario para crear un nuevo registro.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('auth/roles/create');
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
			'ROLE_rol' => 'required|max:15|unique:ROLES',
			'ROLE_descripcion' => ['required', 'max:255'],
		]);

		//Permite seleccionar los datos que se desean guardar.
		$rol = new Rol;
		$rol->ROLE_rol = Input::get('ROLE_rol');
		$rol->ROLE_descripcion = Input::get('ROLE_descripcion');
        $rol->ROLE_creadopor = auth()->user()->username;
        //Se guarda modelo
		$rol->save();

		// redirecciona al index de controlador
		flash_alert( 'Rol '.$rol->ROLE_descripcion.' creado exitosamente!', 'success' );
		return redirect()->to('roles');
	}


	/**
	 * Muestra el formulario para editar un registro en particular.
	 *
	 * @param  int  $ROLE_id
	 * @return Response
	 */
	public function edit($ROLE_id)
	{
		// Se obtiene el registro
		$rol = Rol::findOrFail($ROLE_id);

		// Muestra el formulario de edición y pasa el registro a editar
		return view('auth/roles/edit', compact('rol'));
	}


	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $ROLE_id
	 * @return Response
	 */
	public function update($ROLE_id)
	{
		//Validación de datos
		$this->validate(request(), [
			'ROLE_rol' => 'required|max:15|unique:ROLES',
			'ROLE_descripcion' => ['required', 'max:300'],
		]);

		// Se obtiene el registro
		$rol = Rol::findOrFail($ROLE_id);

		$rol->ROLE_rol = Input::get('ROLE_rol');
		$rol->ROLE_descripcion = Input::get('ROLE_descripcion');
        $rol->ROLE_modificadopor = auth()->user()->username;
        //Se guarda modelo
		$rol->save();

		// redirecciona al index de controlador
		flash_alert( 'Rol '.$rol->ROLE_descripcion.' modificado exitosamente!', 'success' );
		return redirect()->to('roles');
	}

	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $ROLE_id
	 * @return Response
	 */
	public function destroy($ROLE_id, $showMsg=True)
	{
		$rol = Rol::findOrFail($ROLE_id);

		//Si la encuesta fue creada por SYSTEM, no se puede borrar.
		if($rol->ROLE_creadopor == 'SYSTEM'){
			flash_modal( 'Rol '.$rol->ROLE_descripcion.' no se puede borrar!', 'danger' );
			return redirect()->to('roles');
	    } else {

	        $rol->ROLE_eliminadopor = auth()->user()->username;
			$rol->save();
			$rol->delete();

			// redirecciona al index de controlador
			if($showMsg){
				flash_alert( 'Rol '.$rol->ROLE_descripcion.' eliminado exitosamente!', 'success' );
				return redirect()->to('roles');
			}
		}
	}


}

