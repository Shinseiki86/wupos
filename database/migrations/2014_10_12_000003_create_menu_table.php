<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    
    private $nomTabla = 'MENUS';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $commentTabla = 'Tabla con las entradas que se mostrarán en el menú.';

        echo '- Creando tabla '.$this->nomTabla.'...' . PHP_EOL;
        Schema::create($this->nomTabla, function (Blueprint $table) {

            $table->increments('MENU_ID')
                ->comment('Valor autonumérico, llave primaria de la tabla '.$this->nomTabla.'.');

            $table->string('MENU_LABEL',30)->comment('');
            $table->string('MENU_URL',300)->nullable()->comment('');
            $table->string('MENU_ICON',300)->nullable()->comment('');
            $table->unsignedInteger('MENU_PARENT')->default(0)->comment('');
            $table->smallInteger('MENU_ORDER')->default(0)->comment('');
            $table->string('MENU_POSITION', 10)->default('LEFT')
                    ->comment('Item puede estar ubicado en la barra superior (TOP) o en la barra lateral (LEFT)');
            $table->boolean('MENU_ENABLED')->default(true)->comment('');

            $table->unsignedInteger('PERM_ID')->nullable()
                    ->comment('Llave foranea con permissions. Determina si el menú es visible para el usuario.');

            //Traza
            $table->string('MENU_CREADOPOR')
                ->comment('Usuario que creó el registro en la tabla');
            $table->timestamp('MENU_FECHACREADO')
                ->comment('Fecha en que se creó el registro en la tabla.');
            $table->string('MENU_MODIFICADOPOR')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('MENU_FECHAMODIFICADO')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');
            $table->string('MENU_ELIMINADOPOR')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->timestamp('MENU_FECHAELIMINADO')->nullable()
                ->comment('Fecha en que se eliminó el registro en la tabla.');

            //Relación con tabla permissions
            $table->foreign('PERM_ID')
                ->references('id')
                ->on('permissions');

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
