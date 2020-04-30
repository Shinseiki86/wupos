<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionalesTable extends Migration
{

    private $nomTabla = 'REGIONALES';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        $commentTabla = 'Regionales GYF';

        echo '- Creando tabla '.$this->nomTabla.'...' . PHP_EOL;

        Schema::create($this->nomTabla, function (Blueprint $table) {

			$table->increments('REGI_ID')
				->comment('Valor autonumérico, llave primaria de la tabla REGIONALES.');
			
			$table->unSignedInteger('REGI_CODIGO')->unique()
				->comment('Código asignado a la regional.');

			$table->string('REGI_NOMBRE', 100)
				->comment('Nombre de la regional.');

			//Traza
			$table->string('REGI_CREADOPOR')
				->comment('Usuario que creó el registro en la tabla.');
			$table->timestamp('REGI_FECHACREADO')
				->comment('Fecha en que se creó el registro en la tabla.');
			$table->string('REGI_MODIFICADOPOR')->nullable()
				->comment('Usuario que realizó la última modificación del registro en la tabla.');
			$table->timestamp('REGI_FECHAMODIFICADO')->nullable()
				->comment('Fecha de la última modificación del registro en la tabla.');
			$table->string('REGI_ELIMINADOPOR')->nullable()
				->comment('Usuario que eliminó el registro en la tabla.');
			$table->timestamp('REGI_FECHAELIMINADO')->nullable()
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
