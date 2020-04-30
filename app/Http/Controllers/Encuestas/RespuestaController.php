<?php

namespace App\Http\Controllers\Encuestas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Academusoft\SoapController;
use Illuminate\Support\Facades\Route;
use DataTables;

use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\ItemPreg;
use App\Models\Respuesta;
use App\Models\PreguntaTipo;
//use App\Models\EncuestaEstado;
use App\Models\DocenteAcademusoft;

class RespuestaController extends Controller
{
	protected $route = 'encuestas.respuestas';
	protected $class = Respuesta::class;

	public function __construct()
	{
		$this->middleware('auth');
	}



	private function validarRespDuplicada($ENCU_ID, $preview=false){

			// Valida si $ENCU_ID es un objeto Encuesta o el id de una encuesta
			$encuesta = isset($ENCU_ID->ENCU_ID) ? $ENCU_ID : Encuesta::findOrFail($ENCU_ID);

			//Se obtienen todas las preguntas asociadas a la encuesta.
			$preguntas = $encuesta->preguntas();
			//$preguntas = Pregunta::where('ENCU_ID', $encuesta->ENCU_ID);

			//Se obtiene un array con todos los id de pregunta asociados a la encuesta.
			$array_PREG_ID = $preguntas->get(['PREG_ID'])->toArray();

			$usuario = auth()->user();

			//Si no es modo preview y si no es invitado...
			if(!$preview && $usuario->username !== 'invitado'){
				// ...no se debe permitir ingreso si el rol no está en el ámbito de la encuesta.
				$rolesAmbito = $encuesta->dirigidaA->pluck('name')->toArray();

				if(!\Entrust::ability($rolesAmbito, null)){
					abort(403, 'Usuario no tiene permisos!.');
				}

				//Se obtienen todas las resps creadas por el usuario actual .
				$resps = Respuesta::where('RESP_CREADOPOR', '=', $usuario->username)
									->whereIn('PREG_ID', $array_PREG_ID)
									->get();

				foreach ($resps as $resp){
					/*//Si la encuesta es una evaluación a los docentes... 
					if($encuesta->ENCU_PARADOCENTE){
						//...
					}
					//Si el usuario ya ha resuelto la encuesta...
					else*/if($encuesta->ENCU_ID == $resp->pregunta->ENCU_ID){
						flash_modal( 'La encuesta ya fue resuelta el día '. $resp->RESP_FECHACREADO .'.', 'danger' );
						\Redirect::to('encuestas')->send();
					}
				}
			}

			return $preguntas->orderby('PREG_POSICION')->get();
	}

	private function obtenerDocentesSinResp($ENCU_ID, $preview=false){
		//Si la encuesta es una evaluación a los docentes... 
		//Se retornan los docentes que tiene asociado el usuario.
		$encuesta = Encuesta::findOrFail($ENCU_ID);
		$docentes = [];

		//Si la encuesta es una evaluación a los docentes... 
		if($encuesta->ENCU_PARADOCENTE){

			//Se obtiene un array con todos los id de pregunta asociados a la encuesta.
			$arr_PREG_ID = Pregunta::where('ENCU_ID', $ENCU_ID)
									->pluck('PREG_ID')
									->toArray();

			//Se obtienen todas las resps creadas por el usuario actual para la encuesta seleccionada
			$currentUser = auth()->user();
			$resps = Respuesta::where('RESP_CREADOPOR', $currentUser->username)
								->whereIn('PREG_ID', $arr_PREG_ID)
								->get();

			$docsConResps = $resps->pluck('DOAC_ID')->unique()->toArray();

			//Se obtienen todos los docentes asociados al usuario logueado.
			// $docsAcademusoft = (new SoapController)->getDocentes($currentUser->num_documento, get_current_period());
			$docsAcademusoft = (new SoapController)->getDocentes(1113513772, '2019 - 01');
			dump($docsAcademusoft);
			$allFacultades = (new SoapController)->getCarreras(115);
			dump($allFacultades);
			$allFacultades = (new SoapController)->getAllFacultades();
			dd($allFacultades);

			if( is_array($docsAcademusoft) and count($docsAcademusoft)>0 ){

				foreach ($docsAcademusoft as $key => $doc) {
					$doc = array_only((array)$doc, [
						'DOAC_NUM_DOCUMENTO',
						'DOAC_NOMBRE',
						'DOAC_cod_materia',
						'DOAC_materia',
						'DOAC_programa',
						'DOAC_grupo',
						'DOAC_per_matric',
						'DOAC_cod_prog',
					]);
					$doc = DocenteAcademusoft::firstOrCreate($doc);

					if(!in_array( $doc->DOAC_ID, $docsConResps)){
						$docentes[$doc->DOAC_ID] = $doc->DOAC_NOMBRE.' ('.$doc->DOAC_materia.' - '.$doc->DOAC_grupo.')';
					}
				}
			}

			if(empty($docentes) && !$preview){
				//Creando registros de relación entre ENCUESTAS Y USERS 
				$encuesta->usuarios()->sync([$currentUser->id], false);
				flash_alert( 'No quedan docentes por evaluar en la encuesta '. $ENCU_ID .'.', 'success' );
				return redirect('encuestas')->send();
			}
		}

		return $docentes;
	}

	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function index($ENCU_ID, $preview=false)
	{
		if(env('APP_MAINTENANCE_MODE', false) and (!\Entrust::hasRole('admin'))){
			$time = Carbon::parse(env('APP_MAINTENANCE_DATEUP'));
			abort(503, 'Regresamos en '.$time->diffInMinutes().' minutos...');
		}

		//Valida si la encuesta existe y si ya fue cerrada.
		$encuesta = Encuesta::existeEncuesta($ENCU_ID);
		//Si el nombre de la ruta es 'preview', define la variable como true.
		Route::currentRouteName() == 'encuestas.preview'
			? $preview=true
			: $preview=false;

		if(!$encuesta->isPublished() AND !$preview){
			flash_modal( 'Encuesta '.$ENCU_ID.' no se encuentra disponible.', 'danger' );
			\Redirect::to('/')->send();
		}

		//Se valida si la encuesta no ha sido resuelta por el usuario y retorna todas las preguntas asociadas a la encuesta.
		$preguntas = $this->validarRespDuplicada($encuesta, $preview);


		//Si no se encuentran preguntas, no se carga index y se regresa a la ruta anterior.
		if(count($preguntas) == 0){
			flash_alert( 'Encuesta no tiene preguntas.', 'warning' );
			return redirect()->back();
		}

		//Se almacena en $docentes los docentes asociados a la encuesta y que no tienen una respuesta.
		$docentes = $this->obtenerDocentesSinResp($ENCU_ID, $preview);

		//Se carga la vista y se pasan los registros
		if($preview){
			flash_alert( 'Modo vista previa', 'info' );
		}
		return view($this->route.'.index')
			->with(compact('preguntas', 'ENCU_ID', 'preview', 'docentes'));
	}


	/**
	 * Guarda el registro nuevo en la base de datos.
	 *
	 * @return Response
	 */
	public function store($ENCU_ID)
	{
		//Validación de datos
		$this->validate(request(), [
			'*' => ['max:550'],//En caso de que modifiquen el dom y aumenten el valor máx
		]);

		//Valida si la encuesta existe y si ya fue cerrada.
		$encuesta = Encuesta::existeEncuesta($ENCU_ID);

		if(isset($encuesta)){
		
			$this->validarRespDuplicada($encuesta);


			$respsInput = request()->except(['_token', 'DOAC_ID']);
			
			//Se obtienen los id's de las preguntas quitando el texto 'resp_preg_' del id de los radio.
			//Se deben separar las respuestas que se deben relacionar con un item de pregunta (id_itemPregs) de las respuestas a relacionar con una pregunta (id_pregs).
			$respsArray = [];
			foreach ($respsInput as $id_resp_preg => $value){
				$resp = [];
				if(str_contains($id_resp_preg, 'resp_pregitem_')){
					$id_resp_preg = str_replace('resp_pregitem_','', $id_resp_preg);

					$itemPreg = ItemPreg::findOrFail($id_resp_preg);
					$resp = [
						'PREG_ID' => $itemPreg->PREG_ID,
						'ITPR_ID' => $itemPreg->ITPR_ID,
						'RESP_VALOR_INT' => $value,
					];

				} elseif(str_contains($id_resp_preg, 'resp_preg_')){
					$id_resp_preg = str_replace('resp_preg_','', $id_resp_preg);

					$preg = Pregunta::findOrFail($id_resp_preg);
					$resp = [
						'PREG_ID' => $preg->PREG_ID,
					];

					
					switch ($preg->PRTI_ID) {
						case PreguntaTipo::ABIERTA:
							$resp = array_add($resp, 'RESP_VALOR_STR', $value);
							break;
						case PreguntaTipo::UNICA:
						case PreguntaTipo::MULTIPLE:
							$resp = array_add($resp, 'ITPR_ID', ItemPreg::find($value)->ITPR_ID);
						case PreguntaTipo::SINO:
							$resp = array_add($resp, 'RESP_VALOR_INT', $value);
							break;
						default:
							break;
					}

				}

				if($encuesta->ENCU_PARADOCENTE){
					$resp = array_add($resp, 'DOAC_ID', request()->get('DOAC_ID'));
				}
				
				$resp = array_add($resp, 'USER_ID', auth()->user()->id);

				$respsArray[] = $resp;
			}

			//$newResps = Respuesta::hydrate($respsArray);
			foreach ($respsArray as $resp) {
				Respuesta::create($resp);
			}

			// redirecciona al index de controlador
			flash_alert( 'Respuestas guardadas exitosamente (encuesta '.$ENCU_ID.').', 'success' );
			if($encuesta->ENCU_PARADOCENTE){
				return redirect()->back();
			} else {
				//Creando registros de relación entre ENCUESTAS Y USERS 
				$encuesta->usuarios()->sync([auth()->user()->id], false);
			}
		}
		else {
			flash_modal( 'Encuesta '.$ENCU_ID.' no existe.', 'danger' );
		}
		
		return redirect('encuestas')->send();
	}


	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $ENCU_ID
	 * @param  int  $RESP_ID
	 * @return Response
	 */
	public function destroy($RESP_ID)
	{
		isset($RESP_ID->RESP_ID) ? $resp = $RESP_ID : $resp = Respuesta::findOrFail($RESP_ID);
		if(isset($resp)){
			$resp->RESP_eliminadopor = auth()->user()->username;
			$resp->save();
			$resp->delete();
		}
	}

}
