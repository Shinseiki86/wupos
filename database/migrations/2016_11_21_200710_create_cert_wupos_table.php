<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCertWuposTable extends Migration
{
    private $nomTabla = 'CERTIFICADOS';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $commentTabla = 'Tabla con los Certificados suministrados por WU.';

        Schema::create($this->nomTabla, function (Blueprint $table) {
            $table->increments('CERT_ID')
                ->comment('Valor autonumérico, llave primaria de la tabla CERTIFICADOS.');

            $table->string('CERT_CODIGO', 4)->nullable()
                ->comment('Código terminal.');

            $table->string('CERT_EQUIPO', 15)->nullable()
                ->comment('Nombre del equipo donde se instaló el certificado.');

            $table->unSignedInteger('AGEN_ID')
                ->comment('Campo foráneo de la tabla AGENCIAS.');

            //Traza
            $table->string('CERT_CREADOPOR')
                ->comment('Usuario que creó el registro en la tabla.');
            $table->timestamp('CERT_FECHACREADO')
                ->comment('Fecha en que se creó el registro en la tabla.');
            $table->string('CERT_MODIFICADOPOR')->nullable()
                ->comment('Usuario que realizó la última modificación del registro en la tabla.');
            $table->timestamp('CERT_FECHAMODIFICADO')->nullable()
                ->comment('Fecha de la última modificación del registro en la tabla.');
            $table->string('CERT_ELIMINADOPOR')->nullable()
                ->comment('Usuario que eliminó el registro en la tabla.');
            $table->string('CERT_MOTIVOELIMINADO')->nullable()
                ->comment('Motivo eliminación del registro.');
            $table->timestamp('CERT_FECHAELIMINADO')->nullable()
                ->comment('Fecha en que se eliminó el registro en la tabla');

            //Relaciones
            $table->foreign('AGEN_ID')
            ->references('AGEN_ID')
            ->on('AGENCIAS');

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
