<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\Permission;

class PermissionController extends Controller
{
	protected $route = 'auth.permisos';
	protected $class = Permission::class;


	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Se obtienen todos los registros.
		$permisos = Permission::with('roles')->get();
		//Se carga la vista y se pasan los registros
		return view($this->route.'.index', compact('permisos'));
	}

	/**
	 * Muestra el formulario para crear un nuevo registro.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Se crea un array con los Role disponibles
		$arrRoles = model_to_array(Role::class, 'display_name');

		return view($this->route.'.create', compact('arrRoles'));
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
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		// Se obtiene el registro
		$permiso = Permission::findOrFail($id);

		//Se crea un array con los Role disponibles
		$arrRoles = model_to_array(Role::class, 'display_name');
		$roles_IDs = $permiso->roles->pluck('id')->toJson();

		// Muestra el formulario de edición y pasa el registro a editar
		return view($this->route.'.edit', compact('permiso', 'arrRoles', 'roles_IDs'));
	}


	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		parent::updateModel($id);
	}

	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		parent::destroyModel($id);
	}
	
}
