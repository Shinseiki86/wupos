<?php

namespace App\Http\Controllers\Encuestas;

use App\Http\Controllers\Controller;
use DataTables;

use App\Models\Encuesta;
use App\Models\Pregunta;
use App\Models\ItemPreg;
use App\Models\PreguntaTipo;
use App\Models\DocenteAcademusoft;

class ReporteController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Genera reportes y gráficos de los resultados de la encuesta.
	 *
	 * @return Response
	 */
	public function loading($ENCU_ID)
	{
		return view('reportes/index-loading', compact('ENCU_ID'));
	}

	/**
	 * Genera reportes y gráficos de los resultados de la encuesta.
	 *
	 * @param  int  $ENCU_ID
	 * @return Response
	 */
	public function index(Encuesta $encuesta)
	{
		// Valida si $ENCU_ID es un objeto Encuesta o el id de una encuesta
		$ENCU_PARADOCENTE = $encuesta->ENCU_PARADOCENTE;

		// Se obtienen las preguntas asociadas a la encuesta
		$pregs = $encuesta->preguntasJoinTipoPreg;

		$arrCharts = [];
		foreach($pregs as $preg){

			//$tipo_chart define el tipo de gráfico que se creará con los datos suministrados.
			$tipo_chart = ''; 
			//Se definen los arreglos a utilizar
			$parameters = $resps_value = $labelsData = $labelsDataSet = $datosTabla = []; 


			$parameters = $this->parametersPreg($preg, $preg->PRTI_ID);


			$resps = $preg->respuestas()->select(['RESP_VALOR_INT'])->get();
			//Si hay datos en $resps_value...
			if(count($resps_value) > 0 ){
				$arrCharts[] = [
					'tipo_chart' => $tipo_chart,
					'PREG_POSICION' => $preg->PREG_POSICION,
					'PREG_TITULO' => str_limit($preg->PREG_TITULO,60),
					'PREG_TIPO' => $preg->PRTI_descripcion,
					'labelsData' => $labelsData,
					'labelsDataSet' => $labelsDataSet,
					'resps_value' => $resps_value,
					'datosTabla' => $datosTabla,

					'promedio' => $this->getPromedio($resps_value),
					'moda' => $this->getModa($resps, $resps_value, $preg->PRTI_ID),
					'mediana' => $this->getMediana($resps, $resps_value, $preg->PRTI_ID),
					//'desv' => stats_absolute_deviation($resps_value),
				];
			}
		} // Fin de foreach para $pregs

        //Se obtienen sólo los docentes del periodo al cual corresponde la encuesta.
        $fcha_encu = $encuesta->ENCU_FECHAPUBLICACION;
        $fcha_encu = $fcha_encu->year.' - 0'.ceil($fcha_encu->month/6);
		$programas = DocenteAcademusoft::where('DOAC_per_matric', $fcha_encu)
							->orderBy('DOAC_programa')
							->pluck('DOAC_programa', 'DOAC_cod_prog')
							->unique();
dd(compact('encuesta', 'ENCU_PARADOCENTE', 'programas', 'arrCharts'));
		//Se carga la vista y se pasan los registros.
		return view('reportes/index')
			->with(compact('encuesta', 'ENCU_PARADOCENTE', 'programas', 'arrCharts'));
	}

	/**
	 * Parámetros para construcción de gráfico
	 *
	 * @param  Pregunta  $preg
	 * @return array
	 */
	private function parametersPreg(Pregunta $preg, $tipo_preg){
		$resps = $this->getResps($preg, $preg->PRTI_ID);
		$labelsDataSet = $resps_value = $datosTabla = [];
		switch($tipo_preg){
			//No se realiza gráfico de las preguntas abiertas (PreguntaTipo::ABIERTA).
			case PreguntaTipo::SINO: //Pregunta Si/No
				$tipo_chart    = 'pie';
				$labelsData    = ['NO', 'SI'];
				$colors        = ['red', 'blue'];
				$resps         = $this->getResps($preg, $preg->PRTI_ID);
				list($resps_value, $datosTabla)  = $this->getRespValueBoolean($resps, $labelsData, $colors);
				break;
			case PreguntaTipo::ESCALA: //Escala de valores
				$tipo_chart  = 'bar2';
				$labelsData  = ['1', '2', '3', '4', '5'];
				$resps       = $this->getResps($preg, $preg->PRTI_ID);
				list($resps_value, $datosTabla) = $this->parametersPregLikert($preg, $resps, $labelsData);
				break;


			case PreguntaTipo::UNICA: //Selección Única
			case PreguntaTipo::MULTIPLE: //Selección Múltiple
				$tipo_chart = 'bar';
				//Se obtiene el conteo de respuestas, donde RESP_VALOR_INT corresponde al id del itempregunta
				//Se ordenan por RESP_VALOR_INT.
				$resps = $preg->respuestas()
						->select(['RESP_VALOR_INT', \DB::raw('COUNT("RESP_VALOR_INT") as count')])
						->orderBy('RESP_VALOR_INT')->groupBy('RESP_VALOR_INT')
						->get();

				//Se obtienen el ITPR_TEXTO de cada itempreguntas para extraer los labels. Se ordenan por ITPR_ID.
				$arrLabel = $preg->itemPregs()
					->select(['ITPR_ID', 'ITPR_TEXTO'])
					->orderBy('ITPR_ID')->groupBy('ITPR_ID')
					->get();
				
				$labelsData = array_column($arrLabel->toArray(), 'ITPR_TEXTO');

				foreach($arrLabel as $key => $label){
					$count = $resps->where('RESP_VALOR_INT',$label->ITPR_ID)->first();

					isset($count->count) ? $count = (int)$count->count : $count = 0;
					$resps_value[] = $count;
				}

				foreach ($labelsData as $key => $label) {
					$datosTabla[] = [
						'color'=>$key,
						'preg'=>$label,
						'resps'=>[$resps_value[$key]]
					];
				}

				break;

			default:
				break;
		}

		return compact('tipo_chart', 'labelsData', 'labelsDataSet','resps_value', 'datosTabla');
	}

	/**
	 * Parámetros para construcción de gráfico pregunta booleana
	 *
	 * @param  Pregunta  $preg
	 * @return array
	 */
	private function getResps(Pregunta $preg, $tipo_preg){
		$resps = [];
		switch($tipo_preg){
			case PreguntaTipo::SINO:
				$resps = $preg->respuestas()
					->select(['RESP_VALOR_INT', \DB::raw('COUNT("RESP_VALOR_INT") as count')])
					->orderBy('RESP_VALOR_INT')->groupBy('RESP_VALOR_INT')
					->get();
				break;
			case PreguntaTipo::ESCALA: //Escala de valores
				$resps = [];
				$itemPregs   = $preg->itemPregs;
				foreach ($itemPregs as $itemPreg) {
					$labelsDataSet[] = $itemPreg->ITPR_posicion.'. '.str_limit($itemPreg->ITPR_TEXTO,10);
					$ITPR_ID = $itemPreg->ITPR_ID;
					$resp = $itemPreg->respuestas()
							->select(['RESP_VALOR_INT', \DB::raw('COUNT("RESP_VALOR_INT") as count')])
							->orderBy('RESP_VALOR_INT')->groupBy('RESP_VALOR_INT')
							->get();
					$resps += [$ITPR_ID => $resp];
				}
				break;
			default:
				break;
		}

		return $resps;
	}


	/**
	 * Valores de respuestas de pregunta booleana
	 *
	 * @param  array  $labelsData
	 * @param  array  $colors
	 * @return array
	 */
	private function getRespValueBoolean(\Illuminate\Database\Eloquent\Collection $resps, array $labelsData, array $colors){
		for ($i=0; $i <= 1; $i++) {
			$count = $resps->where('RESP_VALOR_INT',$i)->first();
			isset($count->count) ? $count = (int)$count->count : $count = 0;
			$resps_value[] = $count;
		}

		foreach ($labelsData as $key => $label) {
			$datosTabla[] = [
				'color' => $colors[$key],
				'preg'  => $label,
				'resps' => [$resps_value[$key]]
			];
		}
		return compact('resps_value', 'datosTabla');
	}


	/**
	 * Parámetros para construcción de gráfico pregunta Likert (Escala)
	 *
	 * @param  Pregunta  $preg
	 * @return array
	 */
	private function parametersPregLikert(Pregunta $preg, array $resps, array $labelsData){

		$resps_value = $datosTabla = [];
		foreach (array_values($resps) as $resp) {
			$resps_value_item =  [];
			foreach($labelsData as $l){
				$count = $resp->where('RESP_VALOR_INT',(int)$l)->first();
				isset($count->count) ? $count = $count->count : $count = 0;
				$resps_value_item[] = $count;
			}
			$resps_value[] = $resps_value_item;
		}

		$pregs_TEXTO = array_pluck($preg->itemPregs->toArray(), 'ITPR_TEXTO');

		foreach ($pregs_TEXTO as $key=>$preg_TEXTO) {
			$datosTabla[] = [
				'color' => $key,
				'preg'  => $preg_TEXTO,
				'resps' => $resps_value[$key]
			];
		}

		return compact('resps_value', 'datosTabla');
	}



	/**
	 * Retorna el promedio de un array de valores numéricos.
	 *
	 * @param  int  $ENCU_ID
	 * @return float
	 */
	private function getPromedio(array $valores){
		$prom = 0;
		if(isset($valores[0]) && is_array($valores[0])){
			$prom = [];
			foreach ($valores as $key => $valor) {
				$promItem = $this->getPromedio(array_column($valores, $key));
				$prom = array_add($prom, $key, $promItem);
			}
		}
		elseif(count($valores) !== 0){
			round($prom = array_sum($valores)/count($valores), 2);
		}
		return $prom;
	}

	/**
	 * Retorna la mediana de una colección de respuestas de valores numéricos.
	 *
	 * @param  int  $ENCU_ID
	 * @return float
	 */
	private function getMediana(\Illuminate\Database\Eloquent\Collection $collectResps, array $arrayRespsAgrup, $PRTI_ID){
		if($collectResps->count() == 0){
			return 0;
		}

		$mediana = 'N/A';

		switch ($PRTI_ID) {
			case PreguntaTipo::SINO:
				break;
			
			case PreguntaTipo::ESCALA:
				//$mediana = [];
				//$mediana = str_replace(['+', '='], [' ', ' = '], http_build_query($moda, null, '; ') );
				break;

			case PreguntaTipo::UNICA:
			case PreguntaTipo::MULTIPLE:
				$mediana = $this->calculaMediana($collectResps->toArray());
				$itemPreg = ItemPreg::find($mediana);
				$mediana = $itemPreg->ITPR_TEXTO;
				break;
			default:
				break;
		}

		return $mediana;
	}

	/**
	 * Retorna la moda de una colección de respuestas de valores numéricos.
	 *
	 * @param  Collection $collectResps
	 * @param  array  $arrayRespsAgrup
	 * @param  int  $ENCU_ID
	 * @return Response
	 */
	private function getModa(\Illuminate\Database\Eloquent\Collection $collectResps, array $arrayRespsAgrup, $PRTI_ID){

		if($collectResps->count() == 0){
			return 0;
		}

		$moda = '';
		//if($valores instanceof \Illuminate\Database\Eloquent\Collection)

		//$valores = array_column($valores, 'RESP_VALOR_INT');

		switch ($PRTI_ID) {
			case PreguntaTipo::SINO:
				if($arrayRespsAgrup[0] > $arrayRespsAgrup[1]){
					$moda = 'NO';
				}
				elseif($arrayRespsAgrup[1] > $arrayRespsAgrup[0]){
					$moda = 'SI';
				}
				else{
					$moda = 'AMBOS';
				}
				break;
			
			case PreguntaTipo::ESCALA:
				$moda = [];
				foreach ($arrayRespsAgrup as $key => $resps) {
					$moda['Pregunta '.($key+1)] = array_keys($resps, max($resps))[0]+1;
				}
				$moda = str_replace(['+', '='], [' ', ' = '], http_build_query($moda, null, '; ') );
				break;

			case PreguntaTipo::UNICA:
			case PreguntaTipo::MULTIPLE:
				$moda = $this->calculaModa($collectResps->toArray());
				$itemPregModa = ItemPreg::find($moda);
				$moda = $itemPregModa->ITPR_TEXTO;
				break;
			default:
				break;
		}

		return $moda;
	}

	protected function calculaModa(array $valores)
	{
		$valores = array_pluck($valores, 'RESP_VALOR_INT');
		$moda = array_count_values($valores);
		arsort($moda);
		return key($moda);
	}

	protected function calculaMediana(array $valores)
	{
		$valores = array_pluck($valores, 'RESP_VALOR_INT');
		sort($valores);
		$cantidad = count($valores);

		$posMediana = ($cantidad + 1) / 2;
		if($posMediana>0){
			$mediana = $valores[$posMediana-1];
		}
		return $mediana;
	}

}
