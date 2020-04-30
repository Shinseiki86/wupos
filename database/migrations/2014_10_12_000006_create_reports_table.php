<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    
    private $nomTabla = 'reports';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $commentTabla = 'reports: Reportes disponibles';

        echo '- Creando tabla '.$this->nomTabla.'...' . PHP_EOL;
        DB::beginTransaction();
        Schema::create($this->nomTabla, function (Blueprint $table) {

            $table->increments('id')
                ->comment('Valor autonumérico, llave primaria de la tabla.');

            $table->string('code', 4)
                ->comment('Identificador');

            $table->string('name', 300)
                ->comment('Nombre del reporte');

            $table->string('controller', 50)
                ->comment('Controlador');

            $table->string('action', 50)
                ->comment('Función en el controlador');

            $table->boolean('filter_required')->default(true)
                ->comment('Filtro requerido al realizar consultas.');

            $table->boolean('enable')->default(true)
                ->comment('Estado');

            //Traza
            $table->timestamps();

        });
        
        if(env('DB_CONNECTION') == 'pgsql')
            DB::statement("COMMENT ON TABLE ".env('DB_SCHEMA').".\"".$this->nomTabla."\" IS '".$commentTabla."'");
        elseif(env('DB_CONNECTION') == 'mysql')
            DB::statement("ALTER TABLE ".$this->nomTabla." COMMENT = '".$commentTabla."'");



        // Create table for associating roles to users (Many-to-Many)
        Schema::create('report_role', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->integer('report_id')->unsigned();

            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('report_id')->references('id')->on('reports')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['role_id', 'report_id']);
        });
        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        echo '- Borrando tabla '.$this->nomTabla.'...' . PHP_EOL;
        Schema::dropIfExists('report_role');
        Schema::dropIfExists($this->nomTabla);
    }

}
