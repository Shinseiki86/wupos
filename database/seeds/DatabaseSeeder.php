<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(MenuTableSeeder::class);
        $this->call(ParametersGlobalTableSeeder::class);
        $this->call(ReportsTableSeeder::class);

        $this->call(TiposEstadosTableSeeder::class);

        // // ** pruebas **
        //$this->call(EncuestasTableSeeder::class);
        // $this->call(EncuestaCalidadUniajcSeeder::class);
        // $this->call(EncuestaDocenteSeeder::class);


        $this->command->info('---FIN');
    }
}
