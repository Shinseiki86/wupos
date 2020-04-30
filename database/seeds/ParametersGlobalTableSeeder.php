<?php

use Illuminate\Database\Seeder;
use App\Models\ParameterGlobal;

class ParametersGlobalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->command->info('---Seeder ParametersGlobal');

        $parameters = [
            ['PGLO_DESCRIPCION'=>'EJEMPLO_DESC', 'PGLO_VALOR'=>'EJE_VALOR', 'PGLO_OBSERVACIONES'=>'EJEMPLO DE UN PARÁMETRO. PARA QUE NO SE PUEDA BORRAR, PGLO_CREADOPOR=SYSTEM', 'PGLO_CREADOPOR'=>'prueba'],
        ];

        foreach ($parameters as $data) {
            $parameter = ParameterGlobal::create($data);
        }
    }
}
