<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgenciasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('AGENCIAS', function (Blueprint $table) {
			$table->increments('AGEN_id')
				->comment('Valor autonumérico, llave primaria de la tabla AGENCIAS.');

			$table->unSignedInteger('AGEN_codigo')->unique()
				->comment('Código asignado a la agencia.');

			$table->string('AGEN_nombre', 100)
				->comment('Nombre de la agencia.');

			$table->string('AGEN_codigowupos')->unique()
				->comment('Código WUPOS de la agencia.');

			$table->boolean('AGEN_activa')
				->comment('Booleano que define si la agencia está activa.');

			$table->unSignedInteger('REGI_id')
				->comment('Campo foráneo de la tabla REGIONALES.');

			//Traza
			$table->string('AGEN_creadopor')
				->comment('Usuario que creó el registro en la tabla.');
			$table->timestamp('AGEN_fechacreado')
				->comment('Fecha en que se creó el registro en la tabla.');
			$table->string('AGEN_modificadopor')->nullable()
				->comment('Usuario que realizó la última modificación del registro en la tabla.');
			$table->timestamp('AGEN_fechamodificado')->nullable()
				->comment('Fecha de la última modificación del registro en la tabla.');
			$table->string('AGEN_eliminadopor')->nullable()
				->comment('Usuario que eliminó el registro en la tabla.');
			$table->timestamp('AGEN_fechaeliminado')->nullable()
				->comment('Fecha en que se eliminó el registro en la tabla');

			//Relaciones
			$table->foreign('REGI_id')
			->references('REGI_id')
			->on('REGIONALES');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('AGENCIAS');
	}
}
