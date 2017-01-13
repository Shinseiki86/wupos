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

		$this->command->info('------Roles');
		foreach(Config::get('enums.roles') as $rol){
			$newRol = new Wupos\Rol;
			$newRol->ROLE_rol         = $rol['rol'];
			$newRol->ROLE_descripcion = $rol['descripcion'];
			$newRol->ROLE_creadopor   = 'SYSTEM';
			$newRol->save();
		}
		
		$this->command->info('------Regionales');
		foreach(Config::get('enums.regionales') as $regional){
			$newRegional = new Wupos\Regional;

			$newRegional->REGI_codigo = $regional['cod'];
			$newRegional->REGI_nombre = $regional['nombre'];

			$newRegional->REGI_creadopor   = 'SYSTEM';
			$newRegional->save();
		}
		
		
		$this->command->info('---FIN ParametrizacionTableSeeder');
	}
}
