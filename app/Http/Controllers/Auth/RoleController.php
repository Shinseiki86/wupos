<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\Role;

class RoleController extends Controller
{
	protected $route = 'auth.roles';
	protected $class = Role::class;

	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Se obtienen todos los registros.
		$roles = Role::with('permissions')->get();
		//Se carga la vista y se pasan los registros
		return view($this->route.'.index', compact('roles'));
	}


	private function getPermissions()
	{
		$arrPermGroups = [];
		foreach( model_to_array(Permission::class, ['name','display_name']) as $i => $value ){
			$key = explode('-', $value['name']);
			$arrPermGroups[$key[0]][$i] = $value['display_name'];
		}
		return $arrPermGroups;
	}


	/**
	 * Muestra el formulario para crear un nuevo registro.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Se crea un array con los Permission disponibles
		$arrPermGroups = $this->getPermissions();
		return view($this->route.'.create', compact('arrPermGroups'));
	}


	/**
	 * Guarda el registro nuevo en la base de datos.
	 *
	 * @return Response
	 */
	public function store()
	{
		parent::storeModel(['permissions'=>'permisos_ids']);
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
		$rol = Role::findOrFail($id);

		//Se crea un array con los Permission disponibles
		$arrPermGroups = $this->getPermissions();
		$permisos_ids = $rol->permissions->pluck('id')->toJson();

		// Muestra el formulario de edición y pasa el registro a editar
		return view($this->route.'.edit', compact('rol', 'arrPermGroups', 'permisos_ids'));
	}


	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		parent::updateModel($id, ['permissions'=>'permisos_ids']);
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
	
	/**
	 * Dashboard: Cantidad de usuarios activos asignados a un rol.
	 *
	 * @return json
	 */
	public function getUsuariosPorRol()
	{
		$data = Role::join('role_user', 'role_user.user_id', '=', 'roles.id')
			->select([
				'display_name as Rol',
				\DB::raw('COUNT("user_id") as count')
			])
			->groupBy('display_name')
			//->orderBy('count', 'desc')
			->get();
		return $data->toJson();
	}

}
