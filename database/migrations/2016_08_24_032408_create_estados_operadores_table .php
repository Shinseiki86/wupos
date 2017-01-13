<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadosOperadoresTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$nomTabla = 'ESTADOSOPERADORES';
		$commentTabla = 'Tabla con los posibles estados que puede tener un OPERADOR.';

		Schema::create($nomTabla, function (Blueprint $table) {
			$table->increments('ESOP_id')
				->comment('Valor autonumérico, llave primaria de la tabla ESTADOSOPERADORES.');
			$table->string('ESOP_descripcion')
				->comment('Descripción del estado del operador. Puede ser: Pendiente Crear, Creado, Pendiente Eliminar, Eliminado');

			//Traza
			$table->string('ESOP_creadopor')
				->comment('Usuario que creó el registro en la tabla.');
			$table->timestamp('ESOP_fechacreado')
				->comment('Fecha en que se creó el registro en la tabla.');
			$table->string('ESOP_modificadopor')->nullable()
				->comment('Usuario que realizó la última modificación del registro en la tabla.');
			$table->timestamp('ESOP_fechamodificado')->nullable()
				->comment('Fecha de la última modificación del registro en la tabla.');
			$table->string('ESOP_eliminadopor')->nullable()
				->comment('Usuario que eliminó el registro en la tabla.');
			$table->timestamp('ESOP_fechaeliminado')->nullable()
				->comment('Fecha en que se eliminó el registro en la tabla');
		});

		if(env('DB_CONNECTION') == 'pgsql')
			DB::statement("COMMENT ON TABLE ".env('DB_SCHEMA').".\"".$nomTabla."\" IS '".$commentTabla."'");
		elseif(env('DB_CONNECTION') == 'mysql')
			DB::statement("ALTER TABLE ".$nomTabla." COMMENT = '".$commentTabla."'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ESTADOSOPERADORES');
	}
}
