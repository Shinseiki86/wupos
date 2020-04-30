<?php

namespace App\Http\Controllers\Wu;

use App\Http\Controllers\Controller;
use DataTables;

use App\Models\Operador;
use App\Models\Regional;
use App\Models\EstadoOperador;

class OperadorController extends Controller
{
	protected $route = 'wu.operadores';
	protected $class = Operador::class;

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
		$query = Operador::with('regional','estado')
				->join('REGIONALES', 'REGIONALES.REGI_ID', '=', 'OPERADORES.REGI_ID')
				->join('ESTADOSOPERADORES', 'ESTADOSOPERADORES.ESOP_ID', '=', 'OPERADORES.ESOP_ID')
				->select([
					'OPER_ID',
					'OPER_CODIGO',
					'OPER_CEDULA',
					'OPER_NOMBRE',
					'OPER_APELLIDO',
					'REGI_CODIGO',
					'ESOP_DESCRIPCION',
				]);
				dd($query->get()->first()->regional);

		return Datatables::eloquent($query)
			->addColumn('action', function($row) use ($model) {
				return parent::buttonEdit($row, $model).
					parent::buttonDelete($row, $model, 'OPER_CEDULA');
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
		$arrEstados = model_to_array(EstadoOperador::class, 'ESOP_DESCRIPCION');
		return compact('arrRegionales','arrEstados');
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
	 * {@inheritdoc}
	 */
	protected function getRequest()
	{
		$data = parent::getRequest();
		$codigoLibre = $this->getCodigoOperadorDisp($data['REGI_ID']);

		if(!isset($codigoLibre))
			flash_modal( '¡No hay códigos disponibles! Elimine operadores para liberar códigos.', 'danger' );
		
		return ['OPER_CODIGO' => $codigoLibre] + $data;
	}


	protected function getCodigoOperadorDisp($REGI_ID){
		$allCodigos = range(1, 999);

		$asingCodigos = array_column(
			Operador::orderBy('OPER_CODIGO')
				->select(['OPER_CODIGO', 'REGI_ID'])
				->where('REGI_ID', $REGI_ID)
				->distinct()->get()->toArray(),
			'OPER_CODIGO'
		);

		return array_first(array_diff($allCodigos, $asingCodigos));
	}


	/**
	 * Muestra el formulario para editar un registro en particular.
	 *
	 * @param  int  $OPER_ID
	 * @return Response
	 */
	public function edit($OPER_ID)
	{
		// Se obtiene el registro
		$model = Operador::findOrFail($OPER_ID);

		// Muestra el formulario de edición y pasa el registro a editar
		return view($this->route.'.edit', compact('model') + $this->getArrays());
	}

	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $OPER_ID
	 * @return Response
	 */
	public function update($OPER_ID)
	{
		parent::updateModel($OPER_ID);
	}

	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $OPER_ID
	 * @return Response
	 */
	public function destroy($OPER_ID)
	{
		parent::destroyModel($OPER_ID);
	}




}
