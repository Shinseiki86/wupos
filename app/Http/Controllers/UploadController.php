<?php

namespace Wupos\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Routing\Redirector;

use Wupos\Agencia;
use Wupos\Regional;

class UploadController extends Controller
{

	/**
	 * Muestra formulario para carga de archivo al servidor.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('upload');
	}



	/**
	 * Muestra formulario para carga de archivo al servidor.
	 *
	 * @return Response
	 */
	public function upload()
	{
		$this->validate(request(), [
			'archivo' => ['required', 'file'],
			'clase' => ['required'],
		]);

		$className = '\\Wupos\\' . ucwords(strtolower(Input::get('clase')));


// $archivo->getClientOriginalName();

		if (Input::file('archivo')->isValid()) {
		//if($archivo->getClientMimeType()=='application/vnd.ms-excel'){

			$archivo = Input::file('archivo');
			$path = $archivo->getRealPath();
			$data = Excel::load($path, function($reader) {
			})->get();

			if(!empty($data) && $data->count()){
				foreach ($data as $row) {

					$modelo = new $className;

					foreach ($row as $key => $value) {
						if(!empty($key)){
							$key = strtoupper(substr($key, 0, 5)) . strtolower(substr($key, 5));
							$modelo->$key = $value;
						}
					}
					$creadopor = strtoupper(substr(Input::get('clase'), 0, 4)).'_creadopor';
					$modelo->$creadopor = auth()->user()->username;

					//Se guarda modelo
					try{
						$modelo->save();
					}
					catch (\Illuminate\Database\QueryException $e){
		            	echo 'PDOException: ';
		                dump($e->getMessage());
		            }
		            catch (PDOException $e) {
		            	echo 'PDOException: ';
		                dump($e->getMessage());
		            }   
				}

			}
		}
		echo "Finalizado!";
		//return back();
	}

}