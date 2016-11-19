<?php

use Illuminate\Database\Seeder;

class ParametrizacionTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->command->info('---Parametros iniciales');
		
		foreach(Config::get('enums.roles') as $rol){
			$newRol = new Wupos\Rol;
			$newRol->ROLE_rol         = $rol['rol'];
			$newRol->ROLE_descripcion = $rol['descripcion'];
			$newRol->ROLE_creadopor   = 'SYSTEM';
			$newRol->save();
		}
		
		$this->command->info('---FIN ParametrizacionTableSeeder');
	}
}
