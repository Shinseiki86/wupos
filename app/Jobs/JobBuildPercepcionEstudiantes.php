<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use PDF;
use Log;
use Carbon\Carbon;
use Chumper\Zipper\Zipper;

use App\Models\Encuesta;
use App\Models\DocenteAcademusoft;
use App\Models\DescargaPercepcionEstudiantil;

class JobBuildPercepcionEstudiantes extends Job implements ShouldQueue
{
	use InteractsWithQueue, SerializesModels;

	public $dwnPercepcion = null;
	private $encuesta = null;
	private $docentes = null;
	private $itemPregs = null;
	private $pregs_TEXTO = null;
	private $storage = null;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($ENCU_ID, $programa)
	{
		$this->dwnPercepcion = DescargaPercepcionEstudiantil::create([
			'ENCU_ID' => $ENCU_ID,
			'DOWN_PROGRAMA' => $programa,
			'DOWN_ESTADO' => 'Queue',
		]);
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{

		$programa = $this->dwnPercepcion->DOWN_PROGRAMA;
		$this->encuesta = Encuesta::with('preguntas.itemPregs')
								->where('ENCU_PARADOCENTE', true)
								->findOrFail($this->dwnPercepcion->ENCU_ID);

		if ($this->encuesta->count_resps == 0){
			$this->dwnPercepcion->update(['DOWN_ESTADO' => 'Empty']);
			return true;
		}

        //Se obtienen sólo los docentes del periodo al cual corresponde la encuesta.
        $fcha_encu = new \Carbon\Carbon($this->encuesta->ENCU_FECHAPUBLICACION);

        $periodo_matricula = $fcha_encu->year.' - 0'.ceil($fcha_encu->month/6);

		$this->docentes = DocenteAcademusoft::where('DOAC_cod_prog', $programa)
						->where('DOAC_per_matric', $periodo_matricula)
						->get();

		$countPDF = count($this->docentes);
		$this->dwnPercepcion->update(['DOWN_TOTALARCHIVOS' => $countPDF]);
		//En promedio, cada pdf se genera entre 8 y 15 seg. Teniendo en cuenta el tiempo de compresión zip y aumentos de procesamiento en el servidor, se establece a 30 seg por pdf.
		//ini_set('max_execution_time', $countPDF * 30);

		try{
			$this->downloadZIP();
		} catch(\Exception $e){
			$this->LogError($e);
		}

	}

	/**
	 * Handle a job failure.
	 *
	 * @return void
	 */
	public function failed()
	{
		$this->dwnPercepcion->update(['DOWN_ESTADO' => 'Error']);
		$zip = $this->dwnPercepcion->DOWN_pathzip;
		if(isset($zip) and file_exists($zip)){
			unlink($zip);
		}

		delete_tree($this->storage);
	}

	private function createStorage(){
		$rand = mt_rand( 1000, 9999 );
		$name = 'Encuesta_'.$this->encuesta->ENCU_ID.'_Programa_'.$this->dwnPercepcion->DOWN_PROGRAMA.'_'.$rand;
		$this->storage = storage_path('pdf').'\\'.$name;

		//Se crea la carpeta donde se almacenarán temporalmente los pdf generados.
		delete_tree($this->storage);
		mkdir($this->storage, 0777, true);
	}

	public function downloadZIP( )
	{
		$this->createStorage();

		$this->itemPregs = $this->encuesta->preguntas
							->where('PRTI_ID', \App\PreguntaTipo::ESCALA)
							->lists('itemPregs')
							->collapse()->unique();
		$this->pregs_TEXTO = array_pluck($this->itemPregs, 'ITPR_TEXTO');


		//Se genera un pdf por cada docente.
		$this->dwnPercepcion->update([
			'DOWN_ARCHIVOSPROCESADOS' => 0,
			'DOWN_ESTADO' => 'Processing',
			'DOWN_pathzip' => $this->storage,
		]);
		foreach ($this->docentes as $docente){

			$job = \DB::table('jobs')->where('id', $this->dwnPercepcion->DOWN_JOB)->get();
			if( count($job) == 0 /*and config('queue.default')=='database'*/){
				Log::alert('Job eliminado');
				$this->dwnPercepcion->update(['DOWN_ESTADO' => 'Err:?']);
				return false;
			}// else {
				//SYNC
				/*$job = \DB::table('jobs')->insertGetId(['queue'=>'sync','payload'=>'1','attempts'=>'1','reserved'=>'1','reserved_at'=>'1','available_at'=>'1','created_at'=>'1']);
				$this->dwnPercepcion->DOWN_JOB = $job;
				$this->dwnPercepcion->save();*/
			//}

			$this->savePDF($docente);
		}

		//Se comprimen todos los pdf generados en un archivo zip.
		$archivos = glob($this->storage.'/*.pdf');

		if($archivos){
			$zipper = new Zipper;
			$pathZip = $this->storage.'.zip';
			$zipper->make($pathZip)->add($archivos)->close();

			$this->dwnPercepcion->update(['DOWN_pathzip' => $pathZip]);
			//Se borra la carpeta temporal.
			delete_tree($this->storage);
			$this->dwnPercepcion->update(['DOWN_ESTADO' => 'Finish']);
		} else {
			$this->dwnPercepcion->update(['DOWN_ESTADO' => 'ErrorZip']);
		}

	}

	public function savePDF($docente)
	{
		$pdf = $this->makePDF($docente);

		if($pdf['pdf'] != null){
			$count_pdf_process = $this->dwnPercepcion->DOWN_ARCHIVOSPROCESADOS + 1;
			$pdf['pdf']->save($this->storage.'/'.$pdf['namePDF']);
			$this->dwnPercepcion->update([
				'DOWN_ARCHIVOSPROCESADOS' => $count_pdf_process
			]);
		}
	}

	/**
	 * Genera PDF con el view 'reportes/layouts.docentes'.
	 *
	 * @return pdf
	 */
	protected function makePDF($docente)
	{
		$parametros = $this->getParametros($docente);

		if (!isset($parametros)){
			return abort(404, 'No hay datos para mostrar');
		}
		
		$this->docente = $parametros['docente'];
		$namePDF = mb_strtoupper(
					$this->docente->DOAC_nombre.' - '.
					$this->docente->DOAC_cod_materia.
					' ('.$this->docente->DOAC_grupo.')'
				);
		$pdf = null;

		//Log::info($parametros);
		try{
			if($parametros['ttlResps'] > 0){
				$pdf = PDF::loadView('reportes/layouts.docentes', $parametros)
							->setPaper('letter', 'landscape');

				$pdf->output();
				$dom_pdf = $pdf->getDomPDF();

				$canvas = $dom_pdf ->get_canvas();
				$canvas->page_text(720, 560, "Pág {PAGE_NUM} de {PAGE_COUNT}", null, 10, [0, 0, 0]);
				$namePDF .= '.pdf';
			} else {
				$this->appendLog($namePDF.' sin respuestas.');
			}
		} catch(\Exception $e){
			$this->LogError($e);
		}

		//dump(Carbon::now()->toTimeString(), '**************');

		return compact('pdf', 'namePDF');
	}

	protected function getParametros($docente)
	{
		$datosInforme = null;
		$resps = [];

		$count = 0;
		foreach ($this->itemPregs as $itemPreg) {
			$nombreGrupo = $itemPreg->pregunta->PREG_TITULO;

			/* $resp_agrup => Colección para obtener los datos agrupados */
			$resp_agrup = $itemPreg->respuestas()
					->where('DOAC_ID',$docente->DOAC_ID)
					->select(['RESP_VALOR_INT', \DB::raw('COUNT("RESP_VALOR_INT") as count')])
					->orderBy('RESP_VALOR_INT')->groupBy('RESP_VALOR_INT');

			$resp_agrup = $resp_agrup->get();

			/* $resp_all => Datos no agrupados para hallar la mediana.*/
			$resp_item_all = $itemPreg->respuestas()
					->where('DOAC_ID',$docente->DOAC_ID)
					->select(['RESP_VALOR_INT'])
					->get()->toArray();
			$resp_item_all = array_column($resp_item_all, 'RESP_VALOR_INT');

			$resps += [$itemPreg->ITPR_ID => compact('resp_item_all', 'resp_agrup', 'nombreGrupo')];
		}

		//Se obtiene el total de respuestas que tiene el docente para la encuesta actual. 
		$ttlResps = count(array_first($resps)['resp_item_all']);

		Log::info(
			'Encuesta: '.$this->encuesta->ENCU_ID.
			'; programa: '.$this->dwnPercepcion->DOWN_PROGRAMA.
			'; docente: '.$docente->DOAC_ID.
			'; ttlResps: '.$ttlResps
		);

		//Si hay respuestas, se puede generar reporte
		if($ttlResps > 0){

			/*Respuestas agrupadas por 'grupo'.*/
			$grupos = array_column($resps, 'nombreGrupo');
			$resp_item_all = array_column($resps, 'resp_item_all');
			$resp_grupo = [];

			foreach ($resp_item_all as $key => $resp) {
				if(isset($resp_grupo[$grupos[$key]])){
					$resp_grupo[$grupos[$key]] = array_merge($resp_grupo[$grupos[$key]], $resp);
				}
				else{
					$resp_grupo = array_add($resp_grupo, $grupos[$key], $resp);
				}
			}

			/* Media y desviación estandar general */
			$resp_encu_all = call_user_func_array('array_merge', $resp_grupo);
			$media_general = $this->getMedia($resp_encu_all);
			$desv_estandar_general = $this->getDesvEstandar($resp_encu_all);

			$resp_grupo_media = [];
			foreach ($resp_grupo as $grupo => $values) {
				$resp_grupo_media = array_add($resp_grupo_media, $grupo, $this->getMedia($values));
			}

			$resps_value = [];
			$escalas =  [1, 2, 3, 4, 5];
			foreach ($resps as $key => $resp) {

				$resps_value_item =  [];
				foreach($escalas as $esc){
					$count = $resp['resp_agrup']->where('RESP_VALOR_INT', $esc)->first();
					isset($count->count) ? $count = $count->count : $count = 0;
					$resps_value_item[] = $count;
				}

				$resps_value[] = [
					'grupo' => $resp['nombreGrupo'],
					'resps' => $resps_value_item,
					'estadist' => [
						'media'    => $this->getMedia($resp['resp_item_all']),
						'mediana'  => $this->getMediana($resp['resp_item_all']),
						'desv_estandar'  => $this->getDesvEstandar($resp['resp_item_all'])
					]
				];

			}
			$resumenResps = array_combine($this->pregs_TEXTO, $resps_value);
			$observaciones = $this->getObservaciones($docente);
		}
		else { //No hay respuestas...
			$resumenResps = $observaciones =  [];
			$media_general = $desv_estandar_general = $resp_grupo_media = [];
		}


		$datosInforme = compact('docente', 'resumenResps', 'ttlResps', 'observaciones', 'media_general', 'desv_estandar_general', 'resp_grupo_media');
		return $datosInforme;
	}

	protected function getMediaDatosAgrupados($resps_value)
	{
		/*  valoración promedio para datos agrupados:
			w = ponderación de la opción de respuesta
			x = conteo de respuestas para la opción de la respuesta
			(x1w1 + x2w2 + x3w3 ... xnwn) / Total
		*/
		$promedio = 0;
		$countResps = array_sum($resps_value);
		if($countResps > 0 ){
			$promedio = (1*$resps_value[0] + 2*$resps_value[1] + 3*$resps_value[2] + 4*$resps_value[3]  + 5*$resps_value[4]) / $countResps;
		}

		return $promedio;
	}

	protected function getMedia($resps_all)
	{
		/* Promedio o media para datos no agrupados
		*/
		$promedio = 0;
		$countResps = count($resps_all);
		if($countResps > 0 ){
			$promedio = array_sum($resps_all) / $countResps;
		}

		return $promedio;
	}

	protected function getMediana($resps_all)
	{
		/*Para datos NO agrupados...*/
		//Organiza las llaves del array. Inicialmente el array empieza en la llave = 0, al final el array comienza con la llave 1.
		sort($resps_all);
		array_unshift($resps_all,0);
		unset($resps_all[0]);

		$countResps = count($resps_all);

		$par1 = $countResps/2;
		$par2 = ($countResps/2)+1;
		$impar = ($countResps+1)/2;

		$mediana = 0;
		if($countResps > 0){
			if($countResps % 2 != 0){
				$mediana = $resps_all[$impar];
			}else{
				$mediana = ( $resps_all[$par1] + $resps_all[$par2] ) / 2;
			}
		}
		
		return $mediana;
	}

	protected function getVarianza($resps_all)
	{
		/*Para datos NO agrupados...*/
		//Organiza las llaves del array. Inicialmente el array empieza en la llave = 0, al final el array comienza con la llave 1.
		sort($resps_all);
		array_unshift($resps_all,0);
		unset($resps_all[0]);

		$countResps = count($resps_all);
		$varianza = 0;
		if($countResps > 0){
			$media = array_sum($resps_all)/$countResps;

			foreach ($resps_all as $key => &$resp) {
				$resp = pow($resp - $media, 2);
			}

			//$varianza = array_sum($resps_all) / ($countResps - 1);
			$varianza = array_sum($resps_all) / $countResps;
		}

		return $varianza;
	}

	protected function getDesvEstandar($resps_all)
	{
		$varianza = $this->getVarianza($resps_all);

		$desv_estandar = sqrt($varianza);
		return $desv_estandar;
	}

	protected function getObservaciones($docente)
	{
		// Se obtienen las preguntas asociadas a la encuesta
		$pregsAbiertas = $this->encuesta->preguntasJoinTipoPreg()
						->where('PREGUNTAS.PRTI_ID',1) //Preg abierta
						->get();

		$obs = [];
		foreach ($pregsAbiertas as $key => $preg) {
			$strObs = $preg->respuestas()
							->where('DOAC_ID',$docente->DOAC_ID)
							->get()->toArray();
			$obs += array_column($strObs, 'RESP_VALOR_STR');
		}

		return $obs;
	}


	protected function appendLog($log)
	{
		if(isset($this->dwnPercepcion->DOWN_LOG)){
			$log = $this->dwnPercepcion->DOWN_LOG.'<br>'.(string)$log;
		}
		$this->dwnPercepcion->update(['DOWN_LOG' => $log]);
	}

	private function LogError($e)
	{
		Log::error($e);
		if($e instanceof \Exception){
			$errorFile = last(explode('\\', $e->getFile()));
			$errorMsg = $errorFile.' (Línea '.$e->getLine().'): Code'.$e->getCode().', '.$e->getMessage();
			$this->appendLog('Err:'.$errorMsg);
			$this->dwnPercepcion->update(['DOWN_ESTADO' => 'Err:'.$e->getCode()]);
		}
	}


}
