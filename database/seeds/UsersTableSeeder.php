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

            //Estudiantes
            \DB::table('USERS')->insert( array(
                'name' => 'Estudiante 1 de prueba',
                'username' => 'estudiante1',
                'email' => 'estudiante1@correo.com',
                'password'  => \Hash::make('123'),
                'ROLE_id' => Wupos\Rol::where('ROLE_rol','estudiante')->get()->first()->ROLE_id,
                'USER_creadopor' => 'admin',
                'USER_fechacreado' => \Carbon\Carbon::now()->toDateTimeString(),
            ));
            \DB::table('USERS')->insert( array(
                'name' => 'Estudiante 2 de prueba',
                'username' => 'estudiante2',
                'email' => 'estudiante2@correo.com',
                'password'  => \Hash::make('123'),
                'ROLE_id' => Wupos\Rol::where('ROLE_rol','estudiante')->get()->first()->ROLE_id,
                'USER_creadopor' => 'admin',
                'USER_fechacreado' => \Carbon\Carbon::now()->toDateTimeString(),
            ));

            //Docentes
            \DB::table('USERS')->insert( array(
                'name' => 'Docente 1 de prueba',
                'username' => 'docente1',
                'email' => 'docente1@correo.com',
                'password'  => \Hash::make('123'),
                'ROLE_id' => Wupos\Rol::where('ROLE_rol','docente')->get()->first()->ROLE_id,
                'USER_creadopor' => 'admin',
                'USER_fechacreado' => \Carbon\Carbon::now()->toDateTimeString(),
            ));
            \DB::table('USERS')->insert( array(
                'name' => 'Docente 2 de prueba',
                'username' => 'docente2',
                'email' => 'docente2@correo.com',
                'password'  => \Hash::make('123'),
                'ROLE_id' => Wupos\Rol::where('ROLE_rol','docente')->get()->first()->ROLE_id,
                'USER_creadopor' => 'admin',
                'USER_fechacreado' => \Carbon\Carbon::now()->toDateTimeString(),
            ));

            //5 usuarios faker
            //$USERS = factory(Wupos\User::class)->times(5)->create();

            $this->command->info('--- Fin Creación de Usuarios prueba');
        }


    }