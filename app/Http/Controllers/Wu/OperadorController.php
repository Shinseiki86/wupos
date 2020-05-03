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
	public function index($trash=false)
	{
		return view($this->route.'.index', compact('trash'));
	}


	/**
	 * Retorna json para Datatable.
	 *
	 * @return json
	 */
	public function getData()
	{
		$trash = request()->get('trash') ? true : false;
		$model = new $this->class;

		$OPER_NOMBRECOMPLETO = expression_concat([
			'OPER_NOMBRE',
			'OPER_APELLIDO'
		], 'OPER_NOMBRECOMPLETO', 'OPERADORES');

		$query = Operador::join('REGIONALES', 'REGIONALES.REGI_ID', '=', 'OPERADORES.REGI_ID')
				->join('ESTADOSOPERADORES', 'ESTADOSOPERADORES.ESOP_ID', '=', 'OPERADORES.ESOP_ID')
				->select([
					'OPER_ID',
					'OPER_CODIGO',
					'OPER_CEDULA',
					$OPER_NOMBRECOMPLETO,
					'REGIONALES.REGI_NOMBRE',
					'ESTADOSOPERADORES.ESOP_DESCRIPCION',
					'OPER_CREADOPOR',
					'OPER_FECHACREADO',
					'OPER_MODIFICADOPOR',
					'OPER_FECHAMODIFICADO',
					'OPER_ELIMINADOPOR',
					'OPER_FECHAELIMINADO',
				]);

		if($trash){
			$query = $query->onlyTrashed();
		}

		return Datatables::eloquent($query)
			->addColumn('action', function($row) use ($model,$trash) {
				return ( $trash ? parent::buttonRestore($row, $model) :  parent::buttonEdit($row, $model) ) .
						parent::buttonDelete( $row, 'OPER_NOMBRECOMPLETO', !$trash);
			}, false)
			->filterColumn('OPER_NOMBRECOMPLETO', function($query, $keyword) {

				$OPER_NOMBRECOMPLETO = expression_concat([
					'OPER_NOMBRE',
					'OPER_APELLIDO'
				], null, 'OPERADORES');

				$sql = $OPER_NOMBRECOMPLETO." like ?";
				$query->whereRaw($sql, ["%{$keyword}%"]);
			})
			->make(true);
	}


	/**
	 * Contruye arrays para usarlos en los selects
	 *
	 * @return array
	 */
	private function getArrays()
	{
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


	/**
	 * Dashboard: Cantidad de operadores activos por Regional.
	 *
	 * @return json
	 */
	public function getOperadoresPorRegional()
	{
		$data = Operador::join('REGIONALES', 'REGIONALES.REGI_ID', '=', 'OPERADORES.REGI_ID')
						//->join('ESTADOSOPERADORES', 'ESTADOSOPERADORES.ESOP_ID', '=', 'OPERADORES.ESOP_ID')
						->where('ESOP_ID', EstadoOperador::CREADO)
						->select([
							'REGI_NOMBRE as Regional',
							\DB::raw('COUNT(1) as count')
						])
						->groupBy('REGI_NOMBRE')
						->orderBy('count', 'desc')
						->get();
		return $data->toJson();
	}

}
