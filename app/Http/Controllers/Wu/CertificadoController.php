<?php

namespace App\Http\Controllers\Wu;

use App\Http\Controllers\Controller;
use DataTables;

use App\Models\Agencia;
use App\Models\Regional;
use App\Models\Certificado;

class CertificadoController extends Controller
{
	protected $route = 'wu.certificados';
	protected $class = Certificado::class;

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
		$query = Certificado::join('AGENCIAS', 'AGENCIAS.AGEN_ID', '=', 'CERTIFICADOS.AGEN_ID')
						->join('REGIONALES', 'REGIONALES.REGI_ID', '=', 'AGENCIAS.REGI_ID')
				->select([
					'CERT_ID',
					'CERT_CODIGO',
					'CERT_EQUIPO',
					'AGENCIAS.AGEN_CODIGO',
					'AGENCIAS.AGEN_NOMBRE',
					'AGENCIAS.AGEN_CUENTAWU',
					'REGIONALES.REGI_CODIGO',
					'REGIONALES.REGI_NOMBRE',
					'CERT_CREADOPOR',
					'CERT_FECHACREADO',
					'CERT_MODIFICADOPOR',
					'CERT_FECHAMODIFICADO',
				]);

		return Datatables::eloquent($query)
			->addColumn('action', function($row) use ($model) {
				return parent::buttonEdit($row, $model).
					parent::buttonDelete($row, 'CERT_CODIGO');
			}, false)->make(true);
	}


	/**
	 * Contruye arrays para usarlos en los selects
	 *
	 * @return array
	 */
	private function getArrays()
	{
		$arrAgencias   = model_to_array(Agencia::class, 'AGEN_NOMBRE');
		$arrRegionales = model_to_array(Regional::class, 'REGI_NOMBRE');
		return compact('arrAgencias','arrRegionales');
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
	 * @param  int  $CERT_ID
	 * @return Response
	 */
	public function edit($CERT_ID)
	{
		// Se obtiene el registro
		$model = Certificado::findOrFail($CERT_ID);

		// Muestra el formulario de edición y pasa el registro a editar
		return view($this->route.'.edit', compact('model') + $this->getArrays());
	}

	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $CERT_ID
	 * @return Response
	 */
	public function update($CERT_ID)
	{
		parent::updateModel($CERT_ID);
	}

	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $CERT_ID
	 * @return Response
	 */
	public function destroy($CERT_ID)
	{
		parent::destroyModel($CERT_ID);
	}



	public function filterAgencia(){
		$regional = Regional::findOrFail(request()->get('id'));

		return response()->json($regional->agencias);
	}
}
