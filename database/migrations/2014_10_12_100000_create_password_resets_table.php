<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('password_resets', function (Blueprint $table) {
			$table->string('email')->index();
			$table->string('token')->index();
			$table->timestamp('created_at');
		});

		if(env('DB_CONNECTION') == 'pgsql')
			DB::statement("COMMENT ON TABLE ".env('DB_SCHEMA', 'public').".\"password_resets\" IS 'Tabla para almacenar los token generados al solicitar cambio de contraseña.'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('password_resets');
	}
}
