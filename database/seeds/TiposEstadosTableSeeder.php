<?php

use Illuminate\Database\Seeder;

use App\Models\EstadoOperador;

class TiposEstadosTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->command->info('---Tipos y estados iniciales');


		$this->command->info('------ EstadoOperador');
		$estadosOperador = [
			'ACTIVO',
			'INACTIVO',
		];
		foreach($estadosOperador as $estado){
			EstadoOperador::create([
				'ESOP_DESCRIPCION' => $estado,
				'ESOP_CREADOPOR' => 'INIT',
			]);
		}


	}
}
