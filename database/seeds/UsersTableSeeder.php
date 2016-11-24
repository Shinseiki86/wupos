<?php
    
use Illuminate\Database\Seeder;

    class UsersTableSeeder extends Seeder {

        public function run() {

            $this->command->info('--- Creación de Usuarios prueba');
            //Admin
            \DB::table('USERS')->insert( array(
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@correo.com',
                'password'  => \Hash::make('123'),
                'ROLE_id' => Wupos\Rol::where('ROLE_rol','admin')->get()->first()->ROLE_id,
                'USER_creadopor' => 'SYSTEM',
                'USER_fechacreado' => \Carbon\Carbon::now()->toDateTimeString(),
            ));

            //Editores
            \DB::table('USERS')->insert( array(
                'name' => 'Editor 1 de prueba',
                'username' => 'editor1',
                'email' => 'editor1@correo.com',
                'password'  => \Hash::make('123'),
                'ROLE_id' => Wupos\Rol::where('ROLE_rol','editor')->get()->first()->ROLE_id,
                'USER_creadopor' => 'admin',
                'USER_fechacreado' => \Carbon\Carbon::now()->toDateTimeString(),
            ));
            \DB::table('USERS')->insert( array(
                'name' => 'Editor 2 de prueba',
                'username' => 'editor2',
                'email' => 'editor2@correo.com',
                'password'  => \Hash::make('123'),
                'ROLE_id' => Wupos\Rol::where('ROLE_rol','editor')->get()->first()->ROLE_id,
                'USER_creadopor' => 'admin',
                'USER_fechacreado' => \Carbon\Carbon::now()->toDateTimeString(),
            ));

            //Usuarios
            \DB::table('USERS')->insert( array(
                'name' => 'Usuario 1 de prueba',
                'username' => 'usuario1',
                'email' => 'usuario1@correo.com',
                'password'  => \Hash::make('123'),
                'ROLE_id' => Wupos\Rol::where('ROLE_rol','user')->get()->first()->ROLE_id,
                'USER_creadopor' => 'admin',
                'USER_fechacreado' => \Carbon\Carbon::now()->toDateTimeString(),
            ));
            \DB::table('USERS')->insert( array(
                'name' => 'Usuario 2 de prueba',
                'username' => 'usuario2',
                'email' => 'usuario2@correo.com',
                'password'  => \Hash::make('123'),
                'ROLE_id' => Wupos\Rol::where('ROLE_rol','user')->get()->first()->ROLE_id,
                'USER_creadopor' => 'admin',
                'USER_fechacreado' => \Carbon\Carbon::now()->toDateTimeString(),
            ));


            //5 usuarios faker
            //$USERS = factory(Wupos\User::class)->times(5)->create();

            $this->command->info('--- Fin Creación de Usuarios prueba');
        }


    }