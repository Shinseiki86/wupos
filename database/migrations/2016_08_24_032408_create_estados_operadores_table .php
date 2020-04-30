<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadosOperadoresTable extends Migration
{

    private $nomTabla = 'ESTADOSOPERADORES';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$commentTabla = 'Tabla con los posibles estados que puede tener un OPERADOR.';

        Schema::create($this->nomTabla, function (Blueprint $table) {
			$table->increments('ESOP_ID')
				->comment('Valor autonumérico, llave primaria de la tabla ESTADOSOPERADORES.');
			$table->string('ESOP_DESCRIPCION')
				->comment('Descripción del estado del operador. Puede ser: Pendiente Crear, Creado, Pendiente Eliminar, Eliminado');

			//Traza
			$table->string('ESOP_CREADOPOR')
				->comment('Usuario que creó el registro en la tabla.');
			$table->timestamp('ESOP_FECHACREADO')
				->comment('Fecha en que se creó el registro en la tabla.');
			$table->string('ESOP_MODIFICADOPOR')->nullable()
				->comment('Usuario que realizó la última modificación del registro en la tabla.');
			$table->timestamp('ESOP_FECHAMODIFICADO')->nullable()
				->comment('Fecha de la última modificación del registro en la tabla.');
			$table->string('ESOP_ELIMINADOPOR')->nullable()
				->comment('Usuario que eliminó el registro en la tabla.');
			$table->timestamp('ESOP_FECHAELIMINADO')->nullable()
				->comment('Fecha en que se eliminó el registro en la tabla');
		});

        if(env('DB_CONNECTION') == 'pgsql')
            DB::statement("COMMENT ON TABLE ".env('DB_SCHEMA').".\"".$this->nomTabla."\" IS '".$commentTabla."'");
        elseif(env('DB_CONNECTION') == 'mysql')
            DB::statement("ALTER TABLE ".$this->nomTabla." COMMENT = '".$commentTabla."'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        echo '- Borrando tabla '.$this->nomTabla.'...' . PHP_EOL;
        Schema::dropIfExists($this->nomTabla);
	}
}
