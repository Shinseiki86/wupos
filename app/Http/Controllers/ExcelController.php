<?php

namespace Wupos\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller {


	/**
	 * Exporta a Excel XLS
	 *
	 * @return Response
	 */
	public function export($ENCU_id, $ext='xlsx')
	{

		$this->ENCU_id = $ENCU_id;

        Excel::create('Encuesta '.$ENCU_id, function($excel) {
			$this->encuesta = Encuesta::findOrFail((int)$this->ENCU_id);

			foreach ($this->encuesta->preguntas as $preg){
				$this->preg = $preg;
            	$excel->sheet('Pregunta '.$preg->PREG_posicion, function($sheet) {

	                $arrResps = $this->respPreg($this->preg);
	                $sheet->fromArray($arrResps);
					$sheet->freezeFirstRow();
					$sheet->setAutoFilter();
					
	            });
            }
    	})->export($ext);

		flash_alert( '¡Datos exportados exitosamente!', 'success' );
    	return redirect()->back()->with('error_code', 1);
	}

}