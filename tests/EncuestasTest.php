<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Wupos\User;
use Wupos\Encuesta;

class EncuestasTest extends TestCase
{
    public function testCreateEncuesta()
    {
        //$this->withoutMiddleware();

        //$user = factory(Wupos\User::class)->create();
        $user = User::where('username','editor2')->get()->first();

        $this->be($user); //You are now authenticated

        $this->actingAs($user)
            ->visit('encuestas')
            ->see('Encuestas')
            ->click('Nueva Encuesta')
            ->seePageIs('encuestas/create')
            ->see('Nueva Encuesta')
            ->type('Encuesta de prueba # 1', 'ENCU_titulo')
            ->type('Test de nueva encuesta', 'ENCU_descripcion')
            ->type('2017/11/10 12:00', 'ENCU_fechavigencia')
            ->press('Guardar')
            //->seePageIs('http://localhost/encuestas')
            ->see('¡Encuesta creada exitosamente!')
            ->seeInDataBase('ENCUESTAS', ['ENCU_titulo' => 'Encuesta de prueba # 1']);
    }

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
            ->select('Abierta', 'TIPR_id')
            ->press('Guardar')
            ;
    }

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
