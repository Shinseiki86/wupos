<?php
namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use \Carbon\Carbon;

use App\Models\Audit;

class RptAuditController extends ReportController
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Query base para la construcción de nuevos reportes.
	 *
	 * @return QueryBuilder
	 */
	private function getQuery()
	{

		$query = Audit::join('users', 'users.id', '=', 'audits.user_id')
			->select([
				'audits.id as ID',
				'users.username as USER',
				'audits.event as EVENT',
				'audits.auditable_id as AUDITABLE_ID',
				'audits.auditable_type as AUDITABLE_TYPE',
				'audits.new_values as NEW_VALUES',
				'audits.old_values as OLD_VALUES',
				'audits.url as URL',
				'audits.ip_address as IP_ADDRESS',
				'audits.user_agent as USER_AGENT',
				'audits.created_at as CREATED_AT',
				'audits.updated_at as UPDATED_AT',
			]);

		return $query;
	}


	/**
	 * Nuevo reporte usando el query base.
	 *
	 * @return Json
	 */
	public function logsAuditoria()
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