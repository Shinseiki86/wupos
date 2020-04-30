<?php
namespace App\Http\Controllers\Encuestas;

use App\Http\Controllers\Controller;
//use DataTables;

use App\Models\Encuesta;
use App\Models\EncuestaEstado;
use App\Models\Pregunta;
use App\Models\PreguntaTipo;
use App\Models\ItemPreg;

class PreguntaController extends Controller
{
	protected $route = 'encuestas.preguntas';
	protected $class = Pregunta::class;

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:encuesta-create', ['only' => ['create', 'store']]);
		$this->middleware('permission:encuesta-edit',   ['only' => ['edit', 'update', 'destroy']]);
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


	/**
	 * Muestra el formulario para crear un nuevo registro.
	 *
	 * @return Response
	 */
	public function create(Encuesta $encuesta)
	{
		$this->verificaPermisos($encuesta);

		//Se crea un array con los tipos de pregunta disponibles
		$arrTiposPreguntas = model_to_array(PreguntaTipo::class, 'PRTI_DESCRIPCION');

		//Una pregunta nueva no tiene items
		$ENCU_ID = $encuesta->ENCU_ID;
		$itemsPreg = [];

		// Carga el formulario para crear un nuevo registro (views/create.blade.php)
		return view($this->route.'.create', compact('ENCU_ID', 'arrTiposPreguntas', 'itemsPreg'));
	}

	/**
	 * Guarda el registro nuevo en la base de datos.
	 *
	 * @return Response
	 */
	public function store(Encuesta $encuesta)
	{
		$this->verificaPermisos($encuesta);

		request()->request->add([
			'ENCU_ID'       => $encuesta->ENCU_ID,
			'PREG_POSICION' => $encuesta->pos_last_preg + 1,
		]);

		$preg = parent::storeModel($redirect=false, $showAlert=false);

		//si PRTI_ID es 3 (Escala), 4 (Elec única) o 5 (Elec múltiple)... 
		if(in_array($preg->PRTI_ID, ['3','4','5'])){

			//Se guardan opciones de preguntas multiples
			$itemPregsInput = request()
							->except([
								'_token',
								'_method',
								'ENCU_ID',
								'PREG_TITULO',
								'PREG_TEXTO',
								'PREG_POSICION',
								'PREG_REQUERIDO',
								'PRTI_ID',
								'cantOpciones',
							]);
			//Se separa el id de las preguntas del valor que se desea almacenar
			list($idPregsOpcsInput, $values) = array_divide($itemPregsInput);
			
			//Se guardan las opciones
			foreach($values as $index => $newItemPregInput){
				$itemPreg = [
					'pos'=>$index+1,
					'value'=>$newItemPregInput
				];
				(new ItemPregController)->store($preg, $itemPreg);
			}

		} else{
			//Sino entonces no se guardan items de pregunta.
			//(new ItemPregController)->store($preg, $preg->PREG_TEXTO);
		}


		flash_alert( 'Pregunta '.$preg->PREG_ID.' en encuesta '.$encuesta->ENCU_ID.' creada exitosamente.', 'success' );
		return redirect()->route('encuestas.show', ['ENCU_ID'=>$encuesta->ENCU_ID])->send();
	}


	/**
	 * Muestra el formulario para editar un registro en particular.
	 *
	 * @param  int  $ENCU_ID
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($encuesta, Pregunta $preg)
	{
		$preg->load('encuesta');
		$this->verificaPermisos($preg->encuesta);

		//Se crea un array con los tipos de pregunta disponibles
		$arrTiposPreguntas = model_to_array(PreguntaTipo::class, 'PRTI_DESCRIPCION');
		$ENCU_ID = $encuesta;
		$itemsPreg = $preg->itemPregs()->orderBy('ITPR_POSICION')->get();

		// Muestra el formulario de edición y pasa el registro a editar
		return view($this->route.'.edit', compact('ENCU_ID','preg', 'arrTiposPreguntas', 'itemsPreg'));
	}


	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $ENCU_ID
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Encuesta $encuesta, Pregunta $preg)
	{
		request()->request->add([
			'PREG_REQUERIDO' => request()->get('PREG_REQUERIDO') ? true : false,
		]);

		$preg = parent::updateModel($preg, $redirect=false, $showAlert=false);

		//Se guardan opciones de preguntas multiples.
		$itemPregsInput = request()
						->except([
							'_token',
							'_method',
							'PREG_TITULO',
							'PREG_TEXTO',
							'PREG_REQUERIDO',
							'PRTI_ID',
							'cantOpciones',
						]);
		//Se deben separar las opciones existentes (itemPregsOld) de las nuevas (itemPregsNew) en la base de datos.
		$idItemPregsOldInput = [];
        $itemPregsCurrent = $preg->itemPregs;
		$pos = 1;
		foreach ($itemPregsInput as $idItemPreg => $value){
			$valueItem = [ 'pos'=>$pos++, 'value'=>$value ];

			//Opciones nuevas
			if( str_contains($idItemPreg, 'opc_new_') ){
				(new ItemPregController)->store($preg, $valueItem);
			}
			//Opciones viejas para modificar
			elseif( str_contains($idItemPreg, 'opc_old_') ){
				$idItemPreg = str_replace('opc_old_','', $idItemPreg);
				(new ItemPregController)->update($idItemPreg, $valueItem);
				$idItemPregsOldInput[] = $idItemPreg;
			}
		}

		//Se eliminan las opciones que no fueron incluídas en el campo cant_opc
		if(count($itemPregsCurrent) > count($idItemPregsOldInput)){
			(new ItemPregController)->destroyArray($itemPregsCurrent, $idItemPregsOldInput);
		}

		// redirecciona al index de controlador
		flash_alert( 'Pregunta '.$preg->PREG_ID.' en encuesta '.$preg->ENCU_ID.' actualizada exitosamente.', 'success' );
		return redirect()->route('encuestas.show', ['ENCU_ID'=>$preg->ENCU_ID])->send();
	}

	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $ENCU_ID
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($encuesta, Pregunta $preg, $showMsg=True)
	{

		/*Al borrar (SoftDeletes) una pregunta, se borran los items.
        foreach($preg->itemPregs as $itemPreg){
            (new ItemPregController)->destroy($itemPreg);
        }*/

		// delete
		$preg->delete();

		//$this->ordenar($encuesta, false);

		// redirecciona al index de controlador
		if($showMsg){
			flash_alert( 'Pregunta '.$preg->PREG_ID.' en encuesta '.$preg->ENCU_ID.' borrada.', 'success' );
			return redirect()->route('encuestas.show', ['ENCU_ID'=>$preg->ENCU_ID])->send();
		}
	}

		/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $ENCU_ID
	 * @param  int  $id
	 * @return Response
	 */
	public function ordenar($ENCU_ID, $showMsg=True)
	{
		//Las preguntas pueden llegar desde otro controlador ($ENCU_ID) o desde una vista (JSON).
		$preguntas = request()->get('inputPreguntas');
		if(null !== $preguntas){
			$preguntas = json_decode($preguntas ,JSON_NUMERIC_CHECK);
		}
		else{
			$preguntas = Pregunta::where('ENCU_ID',$ENCU_ID)
							->orderby('PREG_POSICION')->get();
		}

		foreach ($preguntas as $pos => $pregArray) {
			$preg = Pregunta::findOrFail((int)$pregArray['PREG_ID']);
			if($preg->PREG_POSICION != ($pos+1)){
				$preg->PREG_POSICION = $pos + 1;
				$preg->save();
			}
		}

		// redirecciona al index de controlador
		if($showMsg){
			flash_alert( 'Preguntas ordenadas exitosamente.', 'success' );
		}
		return redirect()->to('encuestas/'.$ENCU_ID);
	}
}
