<?php

use Illuminate\Database\Seeder;
use App\Models\Report;
use App\Models\Role;

class ReportsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->command->info('---Seeder Reports');
		$reports = [
			['code'=>'900', 'name'=>'LOGS DE AUDITORÍA', 'controller'=>'Audit', 'action'=>'logsAuditoria', 'filter_required'=>false, 'roles'=>[Role::OWNER, Role::ADMIN]],
		];

		foreach ($reports as $report) {
			$rep = Report::create(array_except($report,'roles'));
			$rep->roles()->sync($report['roles'], true);
		}
	}
}
