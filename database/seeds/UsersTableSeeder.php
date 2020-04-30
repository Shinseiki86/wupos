<?php
    
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder {

    private $rolOwner;
    private $rolAdmin;
    private $rolEditor;

    public function run() {

        $pass = '123';

        //*********************************************************************
        $this->command->info('--- Seeder Creación de Roles');

        $this->rolOwner = Role::create([
            'name'         => 'owner',
            'display_name' => 'Project Owner',
            'description'  => 'User is the owner of a given project.',
        ]);
        $this->rolAdmin = Role::create([
            'name'         => 'admin',
            'display_name' => 'Administrador',
            'description'  => 'User is allowed to manage and edit other users.',
        ]);
        $this->rolConsultas = Role::create([
            'name'         => 'consultas',
            'display_name' => 'Consultas',
            'description'  => 'Usuario solo para consultas.',
        ]);
        $rolAtila = Role::create([
            'name'         => 'atila',
            'display_name' => 'Atila',
            'description'  => 'Usuario de Atila para gestionar Certificados',
        ]);
        $rolSeg = Role::create([
            'name'         => 'seguridad',
            'display_name' => 'Seguridad',
            'description'  => 'Usuaro para gestionar Operadores',
        ]);


        //*********************************************************************
        $this->command->info('--- Seeder Creación de Usuarios prueba');

        //Admin
        $admin = User::firstOrcreate( [
            'name' => 'Administrador',
            'cedula' => 1,
            'username' => 'admin',
            'email' => 'admin@mail.com',
            'password'  => \Hash::make($pass),
        ]);
        $admin->attachRole($this->rolAdmin);

        //Owner
        /*$owner = User::create( [
            'name' => 'Owner',
            'cedula' => 2,
            'username' => 'owner',
            'email' => 'owner@mail.com',
            'password'  => \Hash::make($pass),
        ]);
        $owner->attachRoles([$this->rolAdmin, $this->rolOwner]);*/
        
        //Editores
        $consulta = User::create( [
            'name' => 'Consulta 1 de prueba',
            'cedula' => 444444444,
            'username' => 'consulta1',
            'email' => 'consulta@test.com',
            'password'  => \Hash::make($pass),
            'USER_CREADOPOR'  => 'PRUEBAS'
        ]);
        $consulta->attachRole($this->rolConsultas);


        $atila = User::create( [
            'name' => 'Atila de prueba',
            'cedula' => 6666666666,
            'username' => 'atila',
            'email' => 'atila@test.com',
            'password'  => \Hash::make($pass),
            'USER_CREADOPOR'  => 'PRUEBAS'
        ]);
        $atila->attachRole($rolAtila);

        $seg = User::create( [
            'name' => 'Seguridad prueba',
            'cedula' => 7777777777,
            'username' => 'seg',
            'email' => 'seg@test.com',
            'password'  => \Hash::make($pass),
            'USER_CREADOPOR'  => 'PRUEBAS'
        ]);
        $seg->attachRole($rolSeg);

        //5 usuarios faker
        //$users = factory(App\User::class)->times(5)->create();
    }
}