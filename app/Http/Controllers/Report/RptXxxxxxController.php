<?php
namespace App\Http\Controllers\Report;
use App\Http\Controllers\Controller;

use App\Models\Model;

class RptModelController extends ReportController
{

	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Query base para la construcción de nuevos reportes.
	 *
	 * @return Json
	 */
	private function getQuery()
	{

		$query = Model::all();

		return $query;
	}


	/**
	 * Nuevo reporte usando el query base.
	 *
	 * @return Json
	 */
	public function newReport()
	{
		$instance = new static;
		$query = $instance->getQuery();

		if(isset($instance->data['fchaDesde'])){
			$query->whereDate('audits.created_at', '>=', Carbon::parse($instance->data['fchaDesde']));
		}
		if(isset($instance->data['fchaHasta'])){
			$query->whereDate('audits.created_at', '<=', Carbon::parse($instance->data['fchaHasta']));
		}

		return $instance->buildJson($query, $columnChart='EVENT');
	}


}