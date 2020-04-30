<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMigrationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$nomTabla = 'migrations';
		$commentTabla = 'Tabla creada por Laravel para controlar versiones de la base de datos. No se recomienda eliminar ni cambiar el nombre. Mas información: https://laravel.com/docs/5.2/migrations';

        echo '- Modificando tabla '.$nomTabla.'...' . PHP_EOL;

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
	}

}
