<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperadoresTable extends Migration
{

    private $nomTabla = 'OPERADORES';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $commentTabla = 'Tabla con los Operadores suministrados por WU.';

        Schema::create($this->nomTabla, function (Blueprint $table) {
            $table->increments('OPER_ID')
                ->comment('Valor autonumérico, llave primaria de la tabla OPERADORES.');

            $table->integer('OPER_CODIGO', false, true)
                ->comment('ID del Operador (3A).');

            $table->integer('OPER_CEDULA', false, true)->unique()->nullable()
                ->comment('Cédula del Operador.');

            $table->string('OPER_NOMBRE', 100)
                ->comment('Nombre del Operador (25A).');

            $table->string('OPER_APELLIDO', 100)
                ->comment('Apellido del Operador (25A)');

            $table->unSignedInteger('REGI_ID')
                ->comment('Campo foráneo de la tabla REGIONALES.');
                
            $table->unSignedInteger('ESOP_ID')
                ->comment('Campo foráneo de la tabla ESTADOSOPERADORES.');

            //Traza
            $table->string('OPER_CREADOPOR')
                ->comment('Usuario que creó el registro en la tabla.');
            $table->timestamp('OPER_FECHACREADO')
                ->comment('Fecha en que se creó el registro en la tabla.');
            $table->string('OPER_MODIFICADOPOR')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('OPER_FECHAMODIFICADO')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');
            $table->string('OPER_ELIMINADOPOR')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->string('OPER_MOTIVOELIMINADO')->nullable()
                ->comment('Motivo eliminación del registro.');
            $table->timestamp('OPER_FECHAELIMINADO')->nullable()
                ->comment('Fecha en que se eliminó el registro en la tabla');

            //Relaciones
            $table->foreign('REGI_ID')
            ->references('REGI_ID')
            ->on('REGIONALES');

            $table->foreign('ESOP_ID')
            ->references('ESOP_ID')
            ->on('ESTADOSOPERADORES');

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
