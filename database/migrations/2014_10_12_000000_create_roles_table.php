<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ROLES', function (Blueprint $table) {
			$table->increments('ROLE_id')
				->comment('Valor autonumérico, llave primaria de la tabla ROLES.');
			$table->string('ROLE_rol', 15)->unique()
				->comment('Define el tipo de rol. Debe ser único. Los roles creados por SYSTEM no se deben modificar.');
			$table->string('ROLE_descripcion')
				->comment('Texto con el cual será visualizado el rol. Puede ser modificado y no afectará la lógica del proceso.');
			
			//Traza
			$table->string('ROLE_creadopor')
				->comment('Usuario que creó el registro en la tabla');
			$table->timestamp('ROLE_fechacreado')
				->comment('Fecha en que se creó el registro en la tabla.');
			$table->string('ROLE_modificadopor')->nullable()
				->comment('Usuario que realizó la última modificación del registro en la tabla.');
			$table->timestamp('ROLE_fechamodificado')->nullable()
				->comment('Fecha de la última modificación del registro en la tabla.');
			$table->string('ROLE_eliminadopor')->nullable()
				->comment('Usuario que eliminó el registro en la tabla.');
			$table->timestamp('ROLE_fechaeliminado')->nullable()
				->comment('Fecha en que se eliminó el registro en la tabla.');
		});

		if(env('DB_CONNECTION') == 'pgsql')
			DB::statement("COMMENT ON TABLE ".env('DB_SCHEMA', 'public').".\"ROLES\" IS 'Tabla de roles que peude tener un usuario.'");

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ROLES');
	}
}
