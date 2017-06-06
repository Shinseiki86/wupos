<?php

namespace Wupos\Console\Commands;

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        if (!$this->confirm('¿Borrar todas las tablas? [y|N]'))
            exit('Comando "DropTables" cancelado.');

        switch (env('DB_CONNECTION')) {
                case 'mysql':
                $colname = 'Tables_in_' . env('DB_DATABASE');
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
                $this->comment(PHP_EOL."Todas las tablas fueron borradas en ".env('DB_DATABASE').PHP_EOL);
                break;
            case 'pgsql':
                DB::statement('DROP SCHEMA '.env('DB_SCHEMA').' CASCADE');
                DB::statement('CREATE SCHEMA '.env('DB_SCHEMA'));
                DB::commit();
                $this->comment(PHP_EOL."Todas las tablas fueron borradas en ".env('DB_DATABASE').'.'.env('DB_SCHEMA').PHP_EOL);
                break;
            default:
                $this->comment(PHP_EOL."DB no soportada\nDetectado: ".env('DB_CONNECTION').PHP_EOL);
                break;
        }

    }
}