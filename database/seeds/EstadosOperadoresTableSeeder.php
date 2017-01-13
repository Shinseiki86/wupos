<?php

use Illuminate\Database\Seeder;

class EstadosOperadoresTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		$this->command->info('------Estados operadores');
		foreach(Config::get('enums.estados_operadores') as $estado){
			Wupos\EstadoOperador::create([
				'ESOP_descripcion' => $estado,
				'ESOP_creadopor' => 'SYSTEM',
			]);
		}
	}
}
