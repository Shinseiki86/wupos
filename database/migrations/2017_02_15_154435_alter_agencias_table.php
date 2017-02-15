<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAgenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('AGENCIAS', function (Blueprint $table) {
            $table->dropUnique(['AGEN_cuentawu']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('AGENCIAS', function (Blueprint $table) {
            $table->string('AGEN_cuentawu')->unique()
                ->change();
        });
    }
}
