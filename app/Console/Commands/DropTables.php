<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class DropTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'droptables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Borra todas las tablas de la base de datos actual.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        if (!$this->confirm('¿Borrar todas las tablas? [y|N]')){
            exit('Comando "DropTables" cancelado.');
        }

        $conn   = env('DB_CONNECTION');
        $db     = env('DB_DATABASE');
        $schema = env('DB_SCHEMA');
        switch ($conn) {
                case 'mysql':
                $colname = 'Tables_in_' . $db;
                $tables = DB::select('SHOW TABLES');
                foreach($tables as $table) {
                    $droplist[] = $table->$colname;
                }
                $droplist = implode(',', $droplist);

                DB::beginTransaction();
                DB::statement('SET FOREIGN_KEY_CHECKS = 0');//turn off referential integrity
                DB::statement("DROP TABLE $droplist");
                DB::statement('SET FOREIGN_KEY_CHECKS = 1');//turn referential integrity back on
                DB::commit();
                $this->comment(PHP_EOL."Todas las tablas fueron borradas en ".$db.PHP_EOL);
                break;
            case 'pgsql':
                DB::statement('DROP SCHEMA '.$schema.' CASCADE');
                DB::statement('CREATE SCHEMA '.$schema);
                DB::commit();
                $this->comment(PHP_EOL."Todas las tablas fueron borradas en ".$db.'.'.$schema.PHP_EOL);
                break;
            default:
                $this->comment(PHP_EOL."DB no soportada\nDetectado: ".$conn.PHP_EOL);
                break;
        }

    }
}