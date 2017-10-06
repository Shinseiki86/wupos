<?php

namespace Wupos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use Wupos\Operador;
use Wupos\Regional;
use Wupos\EstadoOperador;

class OperadorController extends Controller
{
	protected $route = 'operadores';
	protected $class = Operador::class;

	public function __construct(Redirector $redirect=null)
	{
		//Requiere que el usuario inicie sesión.
		$this->middleware('auth');
		if(!auth()->guest() && isset($redirect)){

			$action = Route::currentRouteAction();
			$role = isset(auth()->user()->rol->ROLE_rol) ? auth()->user()->rol->ROLE_rol : 'user';

			//Lista de acciones que solo puede realizar los administradores o los editores
			$arrActionsAdmin = [ 'create', 'edit', 'store', 'update', 'destroy' ];

			if(in_array(explode('@', $action)[1], $arrActionsAdmin))//Si la acción del controlador se encuentra en la lista de acciones de admin...
			{
				if( ! in_array($role , ['admin','editor']))//Si el rol no es admin o editor, se niega el acceso.
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
		$operadores = Operador::orderBy('OPER_codigo')
						->join('REGIONALES', 'REGIONALES.REGI_id', '=', 'OPERADORES.REGI_id')
						->join('ESTADOSOPERADORES', 'ESTADOSOPERADORES.ESOP_id', '=', 'OPERADORES.ESOP_id')
						->get();

		//Se crea un array con los estados disponibles
		$arrRegionales = model_to_array(Regional::class, 'REGI_nombre');

		//Se crea un array con los estados disponibles
		$arrEstados = model_to_array(EstadoOperador::class, 'ESOP_descripcion');

		//Se carga la vista y se pasan los registros
		return view('operadores/index', compact('operadores', 'arrRegionales', 'arrEstados'))
				->with('papelera', $papelera = false);
	}

	/**
	 * Muestra una lista de los registros ordenados según los criterios suministrados.
	 *
	 * @return Response
	 */
	public function cambiarEstado($OPER_id)
	{
		// Se obtiene el registro
		$operador = Operador::findOrFail($OPER_id);
		switch ($operador->ESOP_id) {
			case EstadoOperador::PEND_CREAR:
				$operador->ESOP_id = EstadoOperador::CREADO;
				break;
			case EstadoOperador::CREADO:
				$operador->ESOP_id = EstadoOperador::PEND_ELIMINAR;
				break;
		}
		$operador->save();

		// redirecciona al index de controlador
		flash_alert( 'Operador '.$operador->OPER_codigo.' en estado '.$operador->estado->ESOP_descripcion, 'success' );
		return redirect()->to('operadores');

	}	

	/**
	 * Muestra una lista de los registros eliminados.
	 *
	 * @return Response
	 */
	public function indexOnlyTrashed()
	{
		//Se obtienen todos los registros.
		$operadores = Operador::onlyTrashed()
						->orderBy('OPER_codigo')
						->join('REGIONALES', 'REGIONALES.REGI_id', '=', 'OPERADORES.REGI_id')
						->join('ESTADOSOPERADORES', 'ESTADOSOPERADORES.ESOP_id', '=', 'OPERADORES.ESOP_id')
						->get();

		//Se crea un array con los estados disponibles
		$arrRegionales = model_to_array(Regional::class, 'REGI_nombre');

		//Se crea un array con los estados disponibles
		$arrEstados = model_to_array(EstadoOperador::class, 'ESOP_descripcion');

		//Se carga la vista y se pasan los registros
		return view('operadores/index', compact('operadores', 'arrRegionales', 'arrEstados'))
				->with('papelera', $papelera = true);
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
		array_forget($arrEstados, EstadoOperador::ELIMINADO);

		return view('operadores/create', compact('arrRegionales', 'arrEstados'));
	}

	/**
	 * Guarda el registro nuevo en la base de datos.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Datos recibidos desde la vista.
		$data = parent::getRequest();

		//Validación de datos
		$validator = $this->validateRules($data);

		if($validator->passes()){
			$result = $this->storeOperador($data);
			flash_alert($result['msg'] , $result['class'] );
			return redirect()->to('operadores');
		} else {
			return redirect()->back()->withErrors($validator)->withInput()->send();
		}
	}

	private function storeOperador(array $data)
	{
		$codigoLibre = $this->getCodigoOperadorDisp($data['REGI_id']);
		if(!isset($codigoLibre)){
			return [
				'msg'  => '¡No hay códigos disponibles! Elimine operadores para liberar códigos.',
				'class'=>'danger'
			];
		} else {
			$operador = Operador::create(['OPER_codigo' => $codigoLibre] + $data);
			return [
				'msg' => 'Operador '.$operador->OPER_codigo.' creado exitosamente!',
				'class'=>'success'
			];
		}
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
		array_forget($arrEstados, EstadoOperador::ELIMINADO);

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
		//Datos recibidos desde la vista.
		$data = $this->getRequest();

		//Validación de datos
		$validator = $this->validateRules($data, $OPER_id);

		if($validator->passes()){

			// Se obtiene el registro
			$operador = Operador::findOrFail($OPER_id);

			//Se guardan los valores del request al modelo encontrado
			$operador->update(request()->except(['_token']));

			// redirecciona al index de controlador
			flash_alert( '¡Operador '.$operador->OPER_codigo.' modificado exitosamente!', 'success' );
			return redirect()->to('operadores');
		} else {
			return redirect()->back()->withErrors($validator)->withInput()->send();
		}
	}

	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $OPER_id
	 * @return Response
	 */
	public function destroy($OPER_id, $showMsg=True)
	{
		$operador = Operador::withTrashed()->findOrFail($OPER_id);

		$modoBorrado = Input::get('_modoBorrado');
		
		if($modoBorrado === 'softDelete')
			$operador->delete();
		elseif($modoBorrado === 'forceDelete')
			$operador->forceDelete();

		// redirecciona al index de controlador
		if($showMsg){
			flash_alert( 'Operador '.$operador->OPER_codigo.' eliminado exitosamente!', 'success' );
			return redirect()->back();
		}
	}

	protected function getCodigoOperadorDisp($REGI_id){
		$allCodigos = range(0, 999);

		$asingCodigos = array_column(
			Operador::orderBy('OPER_codigo')
				->select(['OPER_codigo', 'REGI_id'])
				->where('REGI_id', $REGI_id)
				->distinct()->get()->toArray(),
			'OPER_codigo'
		);

		return array_first(array_diff($allCodigos, $asingCodigos));
	}


	/**
	 * Elimina todos los registros borrados de la base de datos.
	 *
	 * @return Response
	 */
	public function vaciarPapelera($showMsg=True)
	{
		$operadores = Operador::onlyTrashed();
		$count = $operadores->get()->count();
		$operadores->forceDelete();

		// redirecciona al index de controlador
		if($showMsg){
			flash_alert( '¡'.$count.' operadores(s) eliminados exitosamente!', 'success' );
			return redirect()->back();
		}
	}


	/**
	 * Restaura un registro eliminado de la base de datos.
	 *
	 * @param  int  $OPER_id
	 * @return Response
	 */
	public function restore($OPER_id)
	{
		$operador = Operador::onlyTrashed()->findOrFail($OPER_id);
		$operador->ESOP_id = EstadoOperador::PEND_ELIMINAR;
		$operador->restore();

		flash_alert( 'Operador '.$operador->OPER_codigo.' restaurado con estado "Pendiente Eliminar" exitosamente!', 'success' );
		return redirect()->back();
	}


	/**
	 * Crea operadores por ajax cargados desde un archivo de excel.
	 *
	 */
	public function createFromAjax(Request $request)
	{
		$REGI_nombre = Input::get('regional');
		if(!isset($REGI_nombre))
			return response()->json([
				'status' => 'ERR',
				'msg' => 'Regional no definida.',
				'csrfToken' => csrf_token(),
			]);

		$regional = Regional::where('REGI_nombre' , $REGI_nombre)->get()->first();
		if(!isset($regional))
			return response()->json([
				'status' => 'ERR',
				'msg' => 'Regional '.$REGI_nombre.' no existe.',
				'csrfToken' => csrf_token(),
			]);

		$data = [
			'OPER_cedula'  => Input::get('cedula'),
			'OPER_nombre'     => Input::get('nombre'),
			'OPER_apellido' => Input::get('apellido'),
			'REGI_id'  => $regional->REGI_id,
			'ESOP_id'  => EstadoOperador::PEND_CREAR,
		];

		//Se busca el usuario entre los eliminados.
		$operador = Operador::onlyTrashed()
						->where('OPER_cedula', $data['OPER_cedula'])
						->get()->first();

		$OPER_id = isset($operador) ? $operador->OPER_id : 0;
		$validator = $this->validateRules($data, $OPER_id);

		if($validator->passes()){
			$msg = '';
			$status = 'OK';
			//Si el usuario existen en los eliminados...
			if( isset($operador) ){
				//Se restaura operador y se actualiza
				//$operador->restore();
				$msg = 'Operador '.$operador->OPER_cedula.' se encuentra eliminado con código '.$operador->OPER_codigo.'.';
				$status = 'ERR';
			} else {
				//Sino, se crea 
				$msg = $this->storeOperador($data)['msg'];
			}

			return response()->json([
						'status' => $status,
						'msg' => $msg,
						'csrfToken' => csrf_token(),
					]);
		} else {
			return response()->json([
				'status' => 'ERR',
				'msg' => json_encode($validator->errors()->all(), JSON_UNESCAPED_UNICODE),
				'csrfToken' => csrf_token(),
			]);
		}
	}



}

