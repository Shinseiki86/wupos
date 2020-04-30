<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgenciasTable extends Migration
{

    private $nomTabla = 'AGENCIAS';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        $commentTabla = 'Agencias GYF';

        echo '- Creando tabla '.$this->nomTabla.'...' . PHP_EOL;

        Schema::create($this->nomTabla, function (Blueprint $table) {

			$table->increments('AGEN_ID')
				->comment('Valor autonumérico, llave primaria de la tabla AGENCIAS.');

			$table->unSignedInteger('AGEN_CODIGO')->unique()
				->comment('Código asignado a la agencia.');

			$table->string('AGEN_NOMBRE', 100)
				->comment('Nombre de la agencia.');

			$table->string('AGEN_DESCRIPCION')->nullable()
				->comment('Descripción de la agencia.');

			$table->string('AGEN_CUENTAWU')->nullable()
				->comment('Código WUPOS de la agencia.');

			$table->boolean('AGEN_ACTIVA')
				->comment('Booleano que define si la agencia está activa.');

			$table->unSignedInteger('REGI_ID')
				->comment('Campo foráneo de la tabla REGIONALES.');

			//Traza
			$table->string('AGEN_CREADOPOR')
				->comment('Usuario que creó el registro en la tabla.');
			$table->timestamp('AGEN_FECHACREADO')
				->comment('Fecha en que se creó el registro en la tabla.');
			$table->string('AGEN_MODIFICADOPOR')->nullable()
				->comment('Usuario que realizó la última modificación del registro en la tabla.');
			$table->timestamp('AGEN_FECHAMODIFICADO')->nullable()
				->comment('Fecha de la última modificación del registro en la tabla.');
			$table->string('AGEN_ELIMINADOPOR')->nullable()
				->comment('Usuario que eliminó el registro en la tabla.');
			$table->timestamp('AGEN_FECHAELIMINADO')->nullable()
				->comment('Fecha en que se eliminó el registro en la tabla');

			//Relaciones
			$table->foreign('REGI_ID')
			->references('REGI_ID')
			->on('REGIONALES');

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
