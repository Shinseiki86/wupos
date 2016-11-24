<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionalesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		//Se crea tabla de estados de la encuesta
		Schema::create('REGIONALES', function (Blueprint $table) {
			$table->increments('REGI_id')
				->comment('Valor autonumérico, llave primaria de la tabla REGIONALES.');
			
			$table->unSignedInteger('REGI_codigo')->unique()
				->comment('Código asignado a la regional.');

			$table->string('REGI_nombre', 100)
				->comment('Nombre de la regional.');

			//Traza
			$table->string('REGI_creadopor')
				->comment('Usuario que creó el registro en la tabla.');
			$table->timestamp('REGI_fechacreado')
				->comment('Fecha en que se creó el registro en la tabla.');
			$table->string('REGI_modificadopor')->nullable()
				->comment('Usuario que realizó la última modificación del registro en la tabla.');
			$table->timestamp('REGI_fechamodificado')->nullable()
				->comment('Fecha de la última modificación del registro en la tabla.');
			$table->string('REGI_eliminadopor')->nullable()
				->comment('Usuario que eliminó el registro en la tabla.');
			$table->timestamp('REGI_fechaeliminado')->nullable()
				->comment('Fecha en que se eliminó el registro en la tabla');
		});

		if(env('DB_CONNECTION') === 'pgsql'){
			DB::statement("COMMENT ON TABLE ".env('DB_SCHEMA', 'public').".\"REGIONALES\" IS 'Tabla de las regionales.'");
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('REGIONALES');
	}
}
