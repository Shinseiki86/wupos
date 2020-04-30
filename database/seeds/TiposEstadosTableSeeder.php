<?php

use Illuminate\Database\Seeder;

use App\Models\PreguntaTipo;
use App\Models\EncuestaEstado;

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


		/*$this->command->info('------ preg_tipos');
		$preg_tipos = [
			'Abierta',
			'SI/NO',
			'Escala',
			'Elección única',
			'Elección múltiple',
		];
		foreach($preg_tipos as $tipo){
			PreguntaTipo::create([
				'PRTI_DESCRIPCION' => $tipo
			]);
		}*/


	}
}
