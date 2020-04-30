<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Encuesta;

class EncuestasTest extends TestCase
{
    public function testCreateEncuesta()
    {
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

/*
    public function testEditEncuesta()
    {
        //$this->withoutMiddleware();
        $user = User::where('username','editor2')->get()->first();
        $this->be($user); //You are now authenticated

        $this->actingAs($user)
            ->visit('encuestas/1')
            ->see('Encuesta # 1')
            ->click('Add Pregunta')
            ->see('Nueva Pregunta')
            ->type('Prueba de pregunta abierta', 'PREG_texto')
            ->select('Abierta', 'PRTI_id')
            ->press('Guardar')
            ;
    }
*/
/*
    public function testDeleteEncuesta()
    {
        //$this->withoutMiddleware();

        $user = User::where('username','admin')->get()->first();
        $this->be($user); //You are now authenticated

        $this->actingAs($user)
            ->visit('encuestas')
            ->see('Encuestas')
            ->click('Borrar');
    }
*/
}
