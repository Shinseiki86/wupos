<?php

namespace App\Http\Controllers\Gyf;

use App\Http\Controllers\Controller;
use DataTables;

use App\Models\Regional;

class RegionalController extends Controller
{
	protected $route = 'gyf.regionales';
	protected $class = Regional::class;

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view($this->route.'.index');
	}

	/**
	 * Retorna json para Datatable.
	 *
	 * @return json
	 */
	public function getData()
	{
		$model = new $this->class;
		$query = Regional::select([
			'REGI_ID',
			'REGI_CODIGO',
			'REGI_NOMBRE',
			'REGI_CREADOPOR'
		]);

		return Datatables::eloquent($query)
			->addColumn('action', function($row) use ($model) {
				return parent::buttonEdit($row, $model).
					parent::buttonDelete($row, $model, 'REGI_nombre');
			}, false)->make(true);
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
	 * @param  int  $REGI_ID
	 * @return Response
	 */
	public function edit($REGI_ID)
	{
		// Se obtiene el registro
		$model = Regional::findOrFail($REGI_ID);

		// Muestra el formulario de edición y pasa el registro a editar
		return view($this->route.'.edit', compact('model'));
	}

	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $REGI_ID
	 * @return Response
	 */
	public function update($REGI_ID)
	{
		parent::updateModel($REGI_ID);
	}

	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $REGI_ID
	 * @return Response
	 */
	public function destroy($REGI_ID)
	{
		parent::destroyModel($REGI_ID);
	}

}
