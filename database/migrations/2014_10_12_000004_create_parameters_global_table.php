<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametersGlobalTable extends Migration
{
   private $nomTabla = 'parameters_global';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $commentTabla = 'parameters_global: contiene los parametros generales de la aplicación';

        echo '- Creando tabla '.$this->nomTabla.'...' . PHP_EOL;
        Schema::create($this->nomTabla, function (Blueprint $table) {
            $table->increments('PGLO_ID')
                ->comment('Valor autonumérico, llave primaria de la tabla.');

            $table->string('PGLO_DESCRIPCION', 100)
                ->comment('descripcion del parametro');

            $table->string('PGLO_VALOR', 100)
                ->comment('valor del parametro');

            $table->string('PGLO_OBSERVACIONES', 300)
                ->comment('observaciones del parametro')->nullable();
            
            //Traza
            $table->string('PGLO_CREADOPOR')
                ->comment('Usuario que creó el registro en la tabla');
            $table->timestamp('PGLO_FECHACREADO')
                ->comment('Fecha en que se creó el registro en la tabla.');
            $table->string('PGLO_MODIFICADOPOR')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('PGLO_FECHAMODIFICADO')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');
            $table->string('PGLO_ELIMINADOPOR')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->timestamp('PGLO_FECHAELIMINADO')->nullable()
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
