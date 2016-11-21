<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertWuposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CERTIFICADOS', function (Blueprint $table) {
            $table->increments('CERT_id')
                ->comment('Valor autonumérico, llave primaria de la tabla CERTIFICADOS.');

            $table->unSignedInteger('CERT_codigo')->unique()
                ->comment('Código terminal.');

            $table->string('CERT_equipo', 15)->unique()
                ->comment('Nombre del equipo donde se instaló el certificado.');

            $table->unSignedInteger('AGEN_id')
                ->comment('Campo foráneo de la tabla AGENCIAS.');

            //Traza
            $table->string('CERT_creadopor')
                ->comment('Usuario que creó el registro en la tabla.');
            $table->timestamp('CERT_fechacreado')
                ->comment('Fecha en que se creó el registro en la tabla.');
            $table->string('CERT_modificadopor')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('CERT_fechamodificado')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');
            $table->string('CERT_eliminadopor')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->string('CERT_motivoeliminado')->nullable()
                ->comment('Motivo eliminación del registro.');
            $table->timestamp('CERT_fechaeliminado')->nullable()
                ->comment('Fecha en que se eliminó el registro en la tabla');

            //Relaciones
            $table->foreign('AGEN_id')
            ->references('AGEN_id')
            ->on('AGENCIAS');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('CERTIFICADOS');
    }
}
