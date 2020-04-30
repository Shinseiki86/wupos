<?php

namespace App\Http\Controllers\Gyf;

use App\Http\Controllers\Controller;
use DataTables;

use App\Models\Agencia;
use App\Models\Regional;

class AgenciaController extends Controller
{
	protected $route = 'gyf.agencias';
	protected $class = Agencia::class;

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
		$query = Agencia::join('REGIONALES', 'REGIONALES.REGI_ID', '=', 'AGENCIAS.REGI_ID')
				->select([
					'AGEN_ID',
					'AGEN_CODIGO',
					'AGEN_NOMBRE',
					'AGEN_DESCRIPCION',
					'AGEN_CUENTAWU',
					'AGEN_ACTIVA',
					'REGI_CODIGO',
					'REGI_NOMBRE',
					'AGEN_CREADOPOR',
				]);

		return Datatables::eloquent($query)
			->addColumn('action', function($row) use ($model) {
				return parent::buttonEdit($row, $model).
					parent::buttonDelete($row, $model, 'AGEN_NOMBRE');
			}, false)->make(true);
	}


	/**
	 * Contruye arrays para usarlos en los selects
	 *
	 * @return array
	 */
	private function getArrays()
	{
		//Se crea un array con los países disponibles
		$arrRegionales = model_to_array(Regional::class, 'REGI_NOMBRE');
		return compact('arrRegionales');
	}

	/**
	 * Muestra el formulario para crear un nuevo registro.
	 *
	 * @return Response
	 */
	public function create()
	{

		return view($this->route.'.create', $this->getArrays());
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
	 * @param  int  $AGEN_ID
	 * @return Response
	 */
	public function edit($AGEN_ID)
	{
		// Se obtiene el registro
		$model = Agencia::findOrFail($AGEN_ID);

		// Muestra el formulario de edición y pasa el registro a editar
		return view($this->route.'.edit', compact('model') + $this->getArrays());
	}

	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $AGEN_ID
	 * @return Response
	 */
	public function update($AGEN_ID)
	{
		parent::updateModel($AGEN_ID);
	}

	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $AGEN_ID
	 * @return Response
	 */
	public function destroy($AGEN_ID)
	{
		parent::destroyModel($AGEN_ID);
	}

}
