<?php
namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;

class ParameterController extends Controller
{
	protected $route = 'app.parameters';

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('permission:app-parameters');

	}

	/**
	 * Muestra una lista de los registros.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view($this->route.'.index');
	}


}

