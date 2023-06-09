<?php

namespace Wupos\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;
use Maatwebsite\Excel\Facades\Excel;

use Wupos\Operador;
use Wupos\EstadoOperador;
use Wupos\Certificado;


class ExportarInfoController extends Controller {


	public function __construct(Redirector $redirect=null)
	{
		//Requiere que el usuario inicie sesión.
		$this->middleware('auth');
		if(!auth()->guest() && isset($redirect)){

			$action = Route::currentRouteAction();
			$role = isset(auth()->user()->rol->ROLE_rol) ? auth()->user()->rol->ROLE_rol : 'user';

			//Lista de acciones que solo puede realizar los administradores o los editores
			$arrActionsAdmin = [ 'exportOperadores' ];

			if(in_array(explode("@", $action)[1], $arrActionsAdmin))//Si la acción del controlador se encuentra en la lista de acciones de admin...
			{
				if( ! in_array($role , ['admin','editor']))//Si el rol no es admin o editor, se niega el acceso.
				{
					abort(403, '¡Usuario no tiene permisos!.');
				}
			}
		}
	}


	/**
	 * Exportar Certificados a Excel XLS
	 *
	 * @return Response
	 */
	public function exportCertificados($ext='xlsx')
	{


		$papelera = Input::get('_papelera');
		$nombreArchivo = 'CertificadosWU' . ($papelera ? '_Eliminados' : '');

		Excel::create($nombreArchivo, function($excel) {
			$excel->sheet('CertWU', function($sheet) {

				$columnas = [
					'CERT_codigo',
					'CERT_equipo',
					'AGEN_codigo',
					'AGEN_nombre',
					'AGEN_cuentawu',
					'AGEN_activa',
					'REGI_codigo',
					'REGI_nombre',
					'CERT_creadopor',
					'CERT_fechacreado',
					'CERT_modificadopor',
					'CERT_fechamodificado',
				];

				//Se obtienen todos los registros.
				$certificados = (Input::get('_papelera')) ? Certificado::onlyTrashed() : new Certificado;

				$certificados = $certificados->orderBy('CERT_codigo')
							->join('AGENCIAS', 'AGENCIAS.AGEN_id', '=', 'CERTIFICADOS.AGEN_id')
							->join('REGIONALES', 'REGIONALES.REGI_id', '=', 'AGENCIAS.REGI_id')
							->get($columnas);

				$sheet->fromArray($certificados->toArray());
				$sheet->freezeFirstRow();
				$sheet->setAutoFilter();

			});
		})->export($ext);

		flash_alert( '¡Datos exportados exitosamente!', 'success' );
		return redirect()->refresh()->with('error_code', 1)->send();
	}


	/**
	 * Exportar Certificados a Excel XLS
	 *
	 * @return Response
	 */
	public function exportOperadores($ESOP_id, $cambiar_estado = true, $ext='xlsx')
	{

		$this->ESOP_id = $ESOP_id;
		$this->cambiar_estado = $cambiar_estado;

		$papelera = Input::get('_papelera');
		$nombreArchivo = 'Operadores';

		Excel::create($nombreArchivo, function($excel) {
			$excel->sheet('Operadores', function($sheet) {

				$columnas = [
					'OPER_id',
					'AGEN_cuentawu',
					'OPER_codigo',
					'OPER_cedula',
					'OPER_apellido',
					'OPER_nombre',
					'REGI_nombre',
					'AGEN_nombre',
					'ESOP_descripcion',
					'OPER_creadopor',
					'OPER_fechacreado',
					'OPER_modificadopor',
					'OPER_fechamodificado',
				];

				//Se obtienen todos los registros.
				//$operadores = (Input::get('_papelera')) ? \Wupos\Operador::onlyTrashed() : new \Wupos\Operador;

				$operExport = Operador::join('ESTADOSOPERADORES', 'ESTADOSOPERADORES.ESOP_id', '=', 'OPERADORES.ESOP_id')
							->join('REGIONALES', 'REGIONALES.REGI_id', '=', 'OPERADORES.REGI_id')
							->join('AGENCIAS', 'AGENCIAS.REGI_id', '=', 'REGIONALES.REGI_id')
							->where('OPERADORES.ESOP_id', $this->ESOP_id)
							->where('AGENCIAS.AGEN_activa', true)
							->where('AGENCIAS.AGEN_cuentawu', '!=', null)
							->orderBy('REGI_nombre')
							->orderBy('OPER_codigo')
							->orderBy('AGEN_cuentawu')
							->whereNull('OPER_fechaeliminado')
							->get($columnas);

				if($operExport->count()==0){
					$msg = $this->ESOP_id == EstadoOperador::PEND_CREAR ? 'crear' : 'eliminar';
					flash_alert( '¡No hay registros pendientes por '.$msg.'!', 'danger' );
					return redirect()->back()->send();
				}

				$operArray = $operExport->map(function ($operador) {
				    return collect($operador)->except('OPER_id')->toArray();
				})->all();
				$sheet->fromArray($operArray);
				$sheet->freezeFirstRow();
				$sheet->setAutoFilter();

				if($this->cambiar_estado){
					foreach($operExport as $operador){
						if($this->ESOP_id == EstadoOperador::PEND_CREAR){
							$operador->update( ['ESOP_id' => EstadoOperador::CREADO] );
						} else if($this->ESOP_id == EstadoOperador::PEND_ELIMINAR){
							$operador->delete();
						}
					}
				}
			});
		})->export($ext);

		//flash_alert( '¡Datos exportados exitosamente!', 'success' );
		//return redirect()->refresh()->with('error_code', 1)->send();
	}


}