<?php

namespace Wupos\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Redirector;

use Wupos\Certificado;
use Wupos\Agencia;
use Wupos\Regional;

class CertificadoController extends Controller
{
	public function __construct(Redirector $redirect=null)
	{
		//Requiere que el usuario inicie sesión.
		$this->middleware('auth');
		if(isset($redirect)){

			$action = Route::currentRouteAction();
			$role = isset(auth()->user()->rol->ROLE_rol) ? auth()->user()->rol->ROLE_rol : 'user';

			//Lista de acciones que solo puede realizar los administradores o los editores
			$arrActionsAdmin = [ 'create', 'edit', 'store', 'update', 'destroy' ];

			if(in_array(explode("@", $action)[1], $arrActionsAdmin))//Si la acción del controlador se encuentra en la lista de acciones de admin...
			{
				if( ! in_array($role , ['admin','editor']))//Si el rol no es admin o editor, se niega el acceso.
				{
					Session::flash('error', '¡Usuario no tiene permisos!');
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
		$certificados = Certificado::orderBy('CERT_id')
						->join('AGENCIAS', 'AGENCIAS.AGEN_id', '=', 'CERTIFICADOS.AGEN_id')
						->join('REGIONALES', 'REGIONALES.REGI_id', '=', 'AGENCIAS.REGI_id')
						->get();

		$arrAgencias = Agencia::getAgencias();
		$arrRegionales = Regional::getRegionales();

		//Se carga la vista y se pasan los registros
		return view('certificados/index', compact('certificados', 'arrAgencias', 'arrRegionales'))
				->with('papelera', $papelera = false);
	}

	/**
	 * Muestra una lista de los registros eliminados.
	 *
	 * @return Response
	 */
	public function indexOnlyTrashed()
	{
		//Se obtienen todos los registros.
		$certificados = Certificado::onlyTrashed()
						->orderBy('CERT_id')
						->join('AGENCIAS', 'AGENCIAS.AGEN_id', '=', 'CERTIFICADOS.AGEN_id')
						->join('REGIONALES', 'REGIONALES.REGI_id', '=', 'AGENCIAS.REGI_id')
						->get();

		$arrAgencias = Agencia::getAgencias();
		$arrRegionales = Regional::getRegionales();

		//Se carga la vista y se pasan los registros
		return view('certificados/index', compact('certificados', 'arrAgencias', 'arrRegionales'))
				->with('papelera', $papelera = true);
	}

	/**
	 * Muestra el formulario para crear un nuevo registro.
	 *
	 * @return Response
	 */
	public function create()
	{

		$arrAgencias = Agencia::getAgencias();
		$arrRegionales = Regional::getRegionales();

		return view('certificados/create', compact('arrAgencias', 'arrRegionales'));
	}

	/**
	 * Guarda el registro nuevo en la base de datos.
	 *
	 * @return Response
	 */
	public function store()
	{
		//Validación de datos
		$this->validate(request(), [
			'CERT_codigo' => ['required', 'string', 'max:4'],
			'CERT_equipo' => ['required', 'string', 'max:15'],
			'AGEN_id' => ['required', 'numeric'],
		]);

		//Permite seleccionar los datos que se desean guardar.
		$certificado = new Certificado;
		$certificado->CERT_codigo = Input::get('CERT_codigo');
		$certificado->CERT_equipo = Input::get('CERT_equipo');
		//$certificado->CERT_activa =  (Input::get('CERT_activa')) ? true : false;
		$certificado->AGEN_id = Input::get('AGEN_id'); //Relación con Agencia
		$certificado->CERT_creadopor = auth()->user()->username;

		//Se guarda modelo
		$certificado->save();

		// redirecciona al index de controlador
		Session::flash('message', 'Certificado '.$certificado->CERT_codigo.' creado exitosamente!');
		return redirect()->to('certificados');
	}


	/**
	 * Muestra información de un registro.
	 *
	 * @param  int  $CERT_id
	 * @return Response
	 */
	public function show($CERT_id)
	{
		// Se obtiene el registro
		$certificado = Certificado::findOrFail($CERT_id);

		// Muestra la vista y pasa el registro
		return view('certificados/show', compact('certificado'));
	}


	/**
	 * Muestra el formulario para editar un registro en particular.
	 *
	 * @param  int  $CERT_id
	 * @return Response
	 */
	public function edit($CERT_id)
	{
		// Se obtiene el registro
		$certificado = Certificado::findOrFail($CERT_id);

		$arrAgencias = Agencia::getAgencias();
		$arrRegionales = Regional::getRegionales();

		// Muestra el formulario de edición y pasa el registro a editar
		return view('certificados/edit', compact('certificado', 'arrAgencias', 'arrRegionales'));
	}


	/**
	 * Actualiza un registro en la base de datos.
	 *
	 * @param  int  $CERT_id
	 * @return Response
	 */
	public function update($CERT_id)
	{
		//Validación de datos
		$this->validate(request(), [
			'CERT_codigo' => ['required', 'string', 'max:4'],
			'CERT_equipo' => ['required', 'string', 'max:15'],
			'AGEN_id' => ['required', 'numeric'],
		]);

		// Se obtiene el registro
		$certificado = Certificado::findOrFail($CERT_id);

		$certificado->CERT_codigo = Input::get('CERT_codigo');
		$certificado->CERT_equipo = Input::get('CERT_equipo');
		//$certificado->CERT_activa =  (Input::get('CERT_activa')) ? true : false;
		$certificado->AGEN_id = Input::get('AGEN_id'); //Relación con Agencia

		$certificado->CERT_modificadopor = auth()->user()->username;
		//Se guarda modelo
		$certificado->save();

		// redirecciona al index de controlador
		Session::flash('message', 'Certificado '.$certificado->CERT_codigo.' modificado exitosamente!');
		return redirect()->to('certificados');
	}

	/**
	 * Elimina un registro de la base de datos.
	 *
	 * @param  int  $CERT_id
	 * @return Response
	 */
	public function destroy($CERT_id, $showMsg=True)
	{
		$certificado = Certificado::withTrashed()->findOrFail($CERT_id);

		$modoBorrado = Input::get('_modoBorrado');
		
		if($modoBorrado === 'softDelete'){
			$certificado->CERT_eliminadopor = auth()->user()->username;
			$certificado->save();
			$certificado->delete();
		}
		elseif($modoBorrado === 'forceDelete'){
			$certificado->forceDelete();
		}

		// redirecciona al index de controlador
		if($showMsg){
			Session::flash('message', 'Certificado '.$certificado->CERT_codigo.' eliminado exitosamente!');
			return redirect()->back();
		}
	}

	/**
	 * Elimina todos los registros borrados de la base de datos.
	 *
	 * @param  int  $CERT_id
	 * @return Response
	 */
	public function vaciarPapelera($showMsg=True)
	{
		$certificados = Certificado::onlyTrashed();
		$count = $certificados->get()->count();
		$certificados->forceDelete();

		// redirecciona al index de controlador
		if($showMsg){
			Session::flash('message', '¡'.$count.' certificado(s) eliminados exitosamente!');
			return redirect()->back();
		}
	}


	/**
	 * Restaura un registro eliminado de la base de datos.
	 *
	 * @param  int  $CERT_id
	 * @return Response
	 */
	public function restore($CERT_id, $showMsg=True)
	{
		$certificado = Certificado::onlyTrashed()->findOrFail($CERT_id);
		$certificado->restore();
		//$certificado->history()->restore();

		// redirecciona al index de controlador
		if($showMsg){
			Session::flash('message', 'Certificado '.$certificado->CERT_codigo.' restaurado exitosamente!');
			return redirect()->back();
		}
	}


}

