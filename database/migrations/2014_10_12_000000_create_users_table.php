<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('USERS', function (Blueprint $table) {
			$table->increments('USER_id');
			$table->string('name')
				->comment('Nombre completo del usuario.');
			$table->string('username')->unique()
				->comment('Cuenta del usuario, con la cual realizará la autenticación. Valor único en la tabla');
			$table->string('email')
				->comment('Correo electrónico del usuario.');
			$table->string('password')
				->comment('Contraseña del usuario cifrada.');
			$table->unSignedInteger('ROLE_id')
				->comment('Campo foráneo de la tabla ROLES.');
			$table->rememberToken();

			//Traza
			$table->string('USER_creadopor')
				->comment('Usuario que creó el registro en la tabla');
			$table->timestamp('USER_fechacreado')
				->comment('Fecha en que se creó el registro en la tabla.');
			$table->string('USER_modificadopor')->nullable()
				->comment('Usuario que realizó la última modificación del registro en la tabla.');
			$table->timestamp('USER_fechamodificado')->nullable()
				->comment('Fecha de la última modificación del registro en la tabla.');
			$table->string('USER_eliminadopor')->nullable()
				->comment('Usuario que eliminó el registro en la tabla.');
			$table->timestamp('USER_fechaeliminado')->nullable()
				->comment('Fecha en que se eliminó el registro en la tabla.');

			//Relaciones
			$table->foreign('ROLE_id')
			->references('ROLE_id')
			->on('ROLES');
		});

		if(env('DB_CONNECTION') == 'pgsql')
			DB::statement("COMMENT ON TABLE ".env('DB_SCHEMA', 'public').".\"USERS\" IS 'Tabla de usuarios para ingresar al aplicativo.'");
		//elseif(env('DB_CONNECTION') == 'mysql')

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('USERS');
	}
}
