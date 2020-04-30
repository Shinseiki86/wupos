<?php
namespace App\Http\Controllers\Encuestas;

use App\Http\Controllers\Controller;
use DataTables;

use App\Models\Encuesta;
use App\Models\EncuestaEstado;

class EncuestaController extends Controller
{
	protected $route = 'encuestas';
	protected $class = Encuesta::class;

	public function __construct()
	{
		if( env('APP_MAINTENANCE_MODE', false) and Entrust::hasRole('admin') ){
			$time = \Carbon\Carbon::parse(env('APP_MAINTENANCE_DATEUP'));
			abort(503, 'Regresamos en '.$time->diffInMinutes().' minutos...');
		}

		$this->middleware('auth');
		$this->middleware('permission:encuesta-index',  ['only' => ['index', 'show']]);
		$this->middleware('permission:encuesta-create', ['only' => ['create', 'store', 'clone','duplicarDesdePlantilla']]);
		$this->middleware('permission:encuesta-edit',   ['only' => ['edit', 'update']]);
		$this->middleware('permission:encuesta-delete', ['only' => ['destroy']]);
		$this->middleware('permission:encuesta-restore',['only' => ['indexPapelera','restore']]);
		$this->middleware('permission:encuesta-publish',['only' => ['publicar']]);
		$this->middleware('permission:encuesta-close',  ['only' => ['cerrar']]);
	}


	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function index()
	{
		$strTitulo = 'Encuesta';

		//Se obtienen todas las encuestas disponibles para el usuario dependiendo del rol.
		$encuestas = Encuesta::getEncuestas();
		//Se carga la vista y se pasan los registros.
		return view($this->route.'.index', compact('encuestas', 'strTitulo'));
	}

	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function indexPlantillas()
	{
		$strTitulo = 'Plantilla';

		//Se obtienen las plantillas disponibles
		$encuestas = Encuesta::getPlantillas();

		//Se carga la vista y se pasan los registros.
		return view($this->route.'.index', compact('encuestas', 'strTitulo'));
	}

	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function indexPapelera()
	{

		//Se obtienen todas las encuestas borradas.
		$encuestas = Encuesta::onlyTrashed()->orderBy('ENCU_ID')
					//->join('ESTADOSENCUESTAS', 'ESTADOSENCUESTAS.ENES_ID', '=', 'ENCUESTAS.ENES_ID')
					->join('ESTADOSENCUESTAS', 'ESTADOSENCUESTAS.ENES_ID', '=', 'ENCUESTAS.ENES_ID_ANTESBORRAR')
					->get();

		//Se carga la vista y se pasan los registros.
		return view($this->route.'.papelera.index', compact('encuestas'));
	}


	/**
	 * Muestra información de un registro.
	 *
	 * @param  int  $encuesta
	 * @return Response
	 */
	public function show($encuesta)
	{
		// Se obtiene el registro
		$encuesta = Encuesta::withTrashed()->findOrFail($encuesta);
		$this->verificaPermisos($encuesta);

		$strTitulo = $encuesta->ENCU_PLANTILLA ? 'Plantilla' : 'Encuesta';

		// Muestra la vista y pasa el registro
		return view($this->route.'.show', compact('encuesta', 'strTitulo'));
	}

	/**
	 * Muestra el formulario para crear un nuevo registro.
	 *
	 * @return Response
	 */
	public function create()
	{
		$encuesta = new Encuesta;//compatibilidad con formulario.

		//Plantillas disponibles
		$plantillas = Encuesta::plantillas()->get();
		foreach ($plantillas as $plantilla) {
			//Se obtienen ids de encuestas que corresponden al rol del usuario.
			$plantilla->ENCU_ROLESIDS = $plantilla->dirigidaA()->allRelatedIds()->toJson();
		}
		$arrPlantillas = model_to_array($plantillas, 'ENCU_TITULO');

		//Se crea un array con los roles disponibles
		$arrRoles = model_to_array(Role::class, 'display_name', [['name','notIn',['owner','admin','editor']]]);

		// Carga el formulario para crear un nuevo registro (views/create.blade.php)
		return view($this->route.'.create', compact( 'encuesta','plantillas', 'arrPlantillas', 'arrRoles'));
	}

	/**
	 * Guarda el registro nuevo en la base de datos.
	 *
	 * @return Response
	 */
	public function store()
	{
		request()->request->add(['ENES_ID'=>EncuestaEstado::ABIERTA]);
		$encuesta = parent::storeModel($redirect=false);
		return redirect()->route($this->route.'.show', ['ENCU_ID'=>$encuesta->ENCU_ID])->send();
	}


	/**
	 * Muestra el formulario para editar un registro en particular.
	 *
	 * @param  int $ENCU_ID
	 * @return Response
	 */
	public function edit(Encuesta $encuesta)
	{
		$this->verificaPermisos($encuesta->load('dirigidaA'));
		$strTitulo = $encuesta->ENCU_PLANTILLA ? 'Plantilla' : 'Encuesta';

		//Se crea un array con los roles disponibles
		$arrRoles = model_to_array(Role::class, 'display_name', [['name','notIn',['owner','admin','editor']]]);

		// Muestra el formulario de edición y pasa el registro a editar
		return view($this->route.'.edit', compact('encuesta','arrRoles','strTitulo'));
	}


	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $encuesta
	 * @return Response
	 */
	public function update(Encuesta $encuesta)
	{
		$this->verificaPermisos($encuesta);

		request()->request->add([
			'ENCU_PARADOCENTE'     => request()->get('ENCU_PARADOCENTE') ? true : false,
			'ENCU_PLANTILLA'       => request()->get('ENCU_PLANTILLA') ? true : false,
			'ENCU_PLANTILLAPUBLICA'=> request()->get('ENCU_PLANTILLAPUBLICA') ? true : false,
		]);
		
		$encuesta = parent::updateModel($encuesta, $redirect=false);
		return redirect()->route($this->route.'.show', ['ENCU_ID'=>$encuesta->ENCU_ID])->send();
	}


	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int $ENCU_ID
	 * @return Response
	 */
	public function destroy(Encuesta $encuesta)
	{
		$this->verificaPermisos($encuesta);

		//Se guarda motivo del borrado y estado actual de la encuesta
		$encuesta->update([
			'ENCU_MOTIVOBORRADO' => request()->input('ENCU_MOTIVOBORRADO'),
			'ENES_ID_ANTESBORRAR' => $encuesta->ENES_ID,
			'ENES_ID' => EncuestaEstado::ELIMINANDO,
		]);

		//ini_set('max_execution_time', 300);
		//$encuesta->delete();
		//ini_set('max_execution_time', 60);
		/*// Se planeaba realizar el borrado de la encuesta y todos sus componentes (preguntas y respuestas) mediante JOBS, pero el tiempo de procesamiento en encuestas con mas de 10 preguntas y 100 respuestas superaba permitido por Apache. Se optó por sólo borrar la encuesta, y de esta forma el proceso se reduce.
		$job = (new BorrarEncuesta($encuesta))
                    ->onQueue('encuestas')
                    ->delay(1);
		$this->dispatch($job);
		*/

		//Si la eliminación es exitosa...
		if($encuesta->delete()){
			flash_alert( ($encuesta->ENCU_PLANTILLA ? 'Plantilla ' : 'Encuesta ').$encuesta->ENCU_ID.' borrada exitosamente.', 'success' );
		} else {
			flash_modal( 'Error al borrar la '.($encuesta->ENCU_PLANTILLA ? 'Plantilla ' : 'Encuesta ').$encuesta->ENCU_ID.'.', 'danger' );
		}
		// redirecciona al index de controlador
		return redirect()->back();
	}



	/**
	 * Restaura un registro eliminado de la base de datos.
	 *
	 * @param  int  $encuesta
	 * @return Response
	 */
	public function restore($encuesta)
	{
		//->with('preguntas.respuestas', 'preguntas.itemPregs')
		$encuesta = Encuesta::onlyTrashed()->findOrFail($encuesta);
		
		//Si la restauración es exitosa...
		if($encuesta->restore()){
			//Se restaura el estado anterior al borrado.
			Encuesta::findOrFail($encuesta->ENCU_ID)->update([
				'ENES_ID' => $encuesta->ENES_ID_ANTESBORRAR,
				'ENES_ID_ANTESBORRAR' => null,
			]);
			flash_alert( ($encuesta->ENCU_PLANTILLA ? 'Plantilla ' : 'Encuesta ').$encuesta->ENCU_ID.' restaurada exitosamente.', 'success' );
		} else {
			flash_modal( 'Error al restaurar la '.($encuesta->ENCU_PLANTILLA ? 'Plantilla ' : 'Encuesta ').$encuesta->ENCU_ID.'.', 'danger' );
		}

		// redirecciona al index de controlador
		return redirect()->back();
	}


	/**
	 * Libera la encuesta para que sea visualizada por los usuarios
	 *
	 * @param  int $ENCU_ID
	 * @return Response
	 */
	public function publicar($ENCU_ID)
	{
		$encuesta = Encuesta::findOrFail($ENCU_ID);
		$this->verificaPermisos($encuesta);

		//Si la fecha vigencia es mayor a la actual...
		$fechaActual = \Carbon\Carbon::now();
		if($encuesta->ENCU_FECHAVIGENCIA > $fechaActual){
			//Si no hay preguntas (count=0), no se publica la encuesta.
			if(count($encuesta->preguntas)){
				$encuesta->ENCU_FECHAPUBLICACION = $fechaActual;
				$encuesta->ENES_ID = EncuestaEstado::PUBLICADA;
				$encuesta->save();
				flash_alert( 'Encuesta publicada exitosamente.', 'success' );
			} else {
				flash_alert( 'Encuesta sin preguntas. No se publicó la encuesta.', 'danger' );
			}
		} else {
			flash_alert( 'Fecha vigencia inferior a la actual.', 'danger' );
		}

		// redirecciona al index de controlador
		return redirect()->to('encuestas/'.$encuesta->ENCU_ID);
	}

	/**
	 * Libera la encuesta para que sea visualizada por los usuarios
	 *
	 * @param  int $ENCU_ID
	 * @return Response
	 */
	public function cerrar($ENCU_ID)
	{
		$encuesta = Encuesta::findOrFail($ENCU_ID);
		$this->verificaPermisos($encuesta);

		$encuesta->update([
			'ENCU_MOTIVOCIERRE' => request()->get('ENCU_MOTIVOCIERRE'),
			'ENES_ID' => EncuestaEstado::CERRADA
		]);
		
		// redirecciona a reportes
		flash_alert( 'Encuesta cerrada exitosamente.', 'success' );
		return redirect()->to('encuestas/'.$encuesta->ENCU_ID.'/reportes');
	}

	/**
	 *  Duplica una encuesta, sus preguntas e items, pero no sus respuestas.
	 *
	 * @param  int $ENCU_ID
	 * @return Response
	 */
	public function clone($ENCU_ID, $request = null)
	{
		// Se obtiene el registro
		$encuesta = Encuesta::findOrFail($ENCU_ID);
		$this->verificaPermisos($encuesta);

		$newEncuesta = $encuesta->replicate();
		$newEncuesta->push();
		
		$preguntas = $encuesta->preguntas;
		foreach ($preguntas as $preg) {
			$newPreg = $preg->replicate();
			$newEncuesta->preguntas()->save($newPreg);
			foreach ($preg->itemPregs as $itemPreg) {
				$newItemPreg = $itemPreg->replicate();
				$newPreg->itemPregs()->save($newItemPreg);
			}
		}

		if($request !== null){
			$newEncuesta->ENCU_TITULO = $request->ENCU_TITULO;
			$newEncuesta->ENCU_DESCRIPCION = $request->ENCU_DESCRIPCION;

			$newEncuesta->ENCU_PARADOCENTE =  ($request->ENCU_PARADOCENTE == 1);
			$newEncuesta->ENCU_PLANTILLA =  ($request->ENCU_PLANTILLA == 1);
			$newEncuesta->ENCU_PLANTILLAPUBLICA =  ($request->ENCU_PLANTILLAPUBLICA == 1);

			$ENCU_FECHAVIGENCIA = $request->ENCU_FECHAVIGENCIA;
			$newEncuesta->ENCU_FECHAVIGENCIA = $ENCU_FECHAVIGENCIA;
			//Creando registros de relación entre ENCUESTAS Y ROLES 
			$newEncuesta->dirigidaA()->sync($request->ROLE_ID);
		} else {
			$newEncuesta->ENCU_TITULO = str_limit($newEncuesta->ENCU_TITULO, 42).' - cp';
			$newEncuesta->dirigidaA()->sync($encuesta->dirigidaA()->allRelatedIds()->toArray());
		}

		$newEncuesta->ENES_ID = EncuestaEstado::ABIERTA;
		$newEncuesta->ENCU_CREADOPOR = auth()->user()->username;
		$newEncuesta->save();

		if($request !== null){
			return $newEncuesta;
		} else {
			flash_alert( ($newEncuesta->ENCU_PLANTILLA ? 'Plantilla ' : 'Encuesta ').$encuesta->ENCU_ID.' duplicada con id '.$newEncuesta->ENCU_ID.'.', 'success' );
		}

		return redirect()->to('encuestas/'.$newEncuesta->ENCU_ID);
	}


	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int $ENCU_ID
	 * @return Response
	 */
	public function duplicarDesdePlantilla($ENCU_ID)
	{
		//Validación de datos
		$request = request();
		$this->validate($request, Encuesta::rules());

		$newEncuesta = $this->clone($ENCU_ID, $request);

		// redirecciona al index de controlador
		flash_alert( ($newEncuesta->ENCU_PLANTILLA ? 'Plantilla ' : 'Encuesta ').$ENCU_ID.' creada exitosamente desde plantilla.', 'success' );
		return redirect()->to(($newEncuesta->ENCU_PLANTILLA ? 'plantillas/' : 'encuestas/').$newEncuesta->ENCU_ID);

	}

	/**
	 * Valida que la encuesta se encuentre habilitada para cambios
	 *
	 * @param  Encuesta $encuesta
	 * @return bool
	 */
	protected function verificaPermisos(Encuesta $encuesta)
	{
		if(!\Entrust::hasRole('admin')){
			if($encuesta->ENCU_CREADOPOR != \Entrust::user()->username){
				abort(403, 'Usuario no tiene permisos!.');
				return false;
			}
		}
		return true;
	}



}

