<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    private $nomTabla = 'users';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $commentTabla = 'Tabla de usuarios para ingresar al aplicativo.';

        echo '- Creando tabla '.$this->nomTabla.'...' . PHP_EOL;
        Schema::create($this->nomTabla, function (Blueprint $table) {
            $table->increments('id')
                ->comment('Valor autonumérico, llave primaria de la tabla users.');
            $table->string('name')
                ->comment('Nombre completo del usuario.');
            $table->string('username')->unique()
                ->comment('Cuenta del usuario, con la cual realizará la autenticación. Valor único en la tabla');
            $table->string('cedula')->unique()
                ->comment('cedula del usuario');
            $table->string('email')->unique()
                ->comment('Correo electrónico del usuario. Necesario para enviar enlace de restauración de contraseña.');
            $table->string('password')
                ->comment('Contraseña del usuario cifrada.');
            $table->rememberToken()
                ->comment('Almacena un token para autenticar el usuario automáticamente si se activó el check \"Recordarme\" al iniciar sesión. Mas información: https://laravel.com/docs/5.2/authentication#remembering-users');

            //Traza
            $table->string('USER_CREADOPOR')
                ->comment('Usuario que creó el registro en la tabla');
            $table->timestamp('created_at')
                ->comment('Fecha en que se creó el registro en la tabla.');

            $table->string('USER_MODIFICADOPOR')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('modified_at')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');

            $table->string('USER_ELIMINADOPOR')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->timestamp('deleted_at')->nullable()
                ->comment('Fecha en que se eliminó el registro en la tabla.');

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
