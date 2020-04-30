<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Encuesta;

class SeguridadTest extends TestCase
{
    public function testAccesoEncuesta()
    {


        $this->seed('TestingDatabaseSeeder');


        $user = User::where('username','editor2')->get()->first();

        $this->be($user); //You are now authenticated

        $this->actingAs($user)
            ->visit('encuestas')
            ->see('Encuestas')
            ->click('Crear Encuesta')
            ->seePageIs('encuestas/create')
            ->see('Nueva Encuesta');

        $this->type('Encuesta de prueba # 1', 'ENCU_TITULO')
            ->type('Test de nueva encuesta', 'ENCU_descripcion')
            ->type('08/03/2018 02:30 PM', 'ENCU_FECHAVIGENCIA')
            ->select('Estudiante', 'ROLE_id[]');
            /*->press('Guardar')
            ->seePageIs('encuestas')
            ->see('¡Encuesta creada exitosamente!')
            ->seeInDataBase('ENCUESTAS', ['ENCU_TITULO' => 'Encuesta de prueba # 1'])*/
    }

}
