<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOperadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('OPERADORES', function (Blueprint $table) {
            $table->increments('OPER_id')
                ->comment('Valor autonumérico, llave primaria de la tabla CERTIFICADOS.');

            $table->integer('OPER_codigo', false, true)
                ->comment('ID del Operador (3A).');

            $table->integer('OPER_cedula', false, true)->unique()->nullable()
                ->comment('Cédula del Operador.');

            $table->string('OPER_nombre', 100)
                ->comment('Nombre del Operador (25A).');

            $table->string('OPER_apellido', 100)
                ->comment('Apellido del Operador (25A)');

            $table->unSignedInteger('REGI_id')
                ->comment('Campo foráneo de la tabla REGIONALES.');
                
            $table->unSignedInteger('ESOP_id')
                ->comment('Campo foráneo de la tabla ESTADOSOPERADORES.');

            //Traza
            $table->string('OPER_creadopor')
                ->comment('Usuario que creó el registro en la tabla.');
            $table->timestamp('OPER_fechacreado')
                ->comment('Fecha en que se creó el registro en la tabla.');
            $table->string('OPER_modificadopor')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('OPER_fechamodificado')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');
            $table->string('OPER_eliminadopor')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->string('OPER_motivoeliminado')->nullable()
                ->comment('Motivo eliminación del registro.');
            $table->timestamp('OPER_fechaeliminado')->nullable()
                ->comment('Fecha en que se eliminó el registro en la tabla');

            //Relaciones
            $table->foreign('REGI_id')
            ->references('REGI_id')
            ->on('REGIONALES');

            $table->foreign('ESOP_id')
            ->references('ESOP_id')
            ->on('ESTADOSOPERADORES');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('OPERADORES');
    }
}
