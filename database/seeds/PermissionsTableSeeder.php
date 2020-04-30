<?php
    
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder {

    private $rolOwner;
    private $rolAdmin;
    private $rolConsulta;
    private $rolAtila;
    private $rolSeg;

    public function run(){

        $this->getRoles();
        $this->createpermissionsSystem();
        $this->command->info('--- Seeder Creación de Permisos');

        //Permisos para el negocio
        //$this->createPermissions(Modelo::class, 'modelo display_name', 'description...', true, false);
        $this->createPermissions(Regional::class, 'regionales', null, true);
        $this->createPermissions(Agencia::class, 'agencias', null, true);
        
        $this->createPermissions(Certificado::class, 'certificados', null, true);
        $permsCertificado['restore'] = Permission::create([
            'name'         => 'certificado-restore',
            'display_name' => 'Restaurar certificado (Papelera)',
            'description'  => 'Permite restaurar certificados que fueron borradas.',
        ]);
        $this->rolAdmin->attachPermissions($permsCertificado);

        $this->createPermissions(Operador::class, 'operadores', null, true, false);
        $permsOperador['restore'] = Permission::create([
            'name'         => 'operador-restore',
            'display_name' => 'Restaurar operador (Papelera)',
            'description'  => 'Permite restaurar operadores que fueron borrados.',
        ]);
        $this->rolAdmin->attachPermissions($permsOperador);

    }


    private function createPermissions($name, $display_name, $description = null, $attachAdmin=true)
    {
        $name = strtolower(last(explode('\\',basename(get_model($name)))));

        if($description == null)
            $description = $display_name;

        $create = Permission::create([
            'name'         => $name.'-create',
            'display_name' => 'Crear '.$display_name,
            'description'  => 'Crear '.$description,
        ]);
        $edit = Permission::create([
            'name'         => $name.'-edit',
            'display_name' => 'Editar '.$display_name,
            'description'  => 'Editar '.$description,
        ]);
        $index = Permission::create([
            'name'         => $name.'-index',
            'display_name' => 'Listar '.$display_name,
            'description'  => 'Listar '.$description,
        ]);
        $delete = Permission::create([
            'name'         => $name.'-delete',
            'display_name' => 'Borrar '.$display_name,
            'description'  => 'Borrar '.$description,
        ]);

        $this->rolConsulta->attachPermissions([$index]);
        
        if($attachAdmin)
            $this->rolAdmin->attachPermissions([$index, $create, $edit, $delete]);

        return compact('create', 'edit', 'index', 'delete');
    }


    private function getRoles() {
        $roles = Role::all();
        $this->rolOwner = $roles->where('name', 'owner')->first();
        $this->rolAdmin = $roles->where('name', 'admin')->first();
        $this->rolConsulta = $roles->where('name', 'consultas')->first();
        $this->rolAtila = $roles->where('name', 'atila')->first();
        $this->rolSeg = $roles->where('name', 'seguridad')->first();
    }


    private function createpermissionsSystem()
    {
        
        //Permisos del sistema
        $menu = Permission::create([
            'name'         => 'app-menu',
            'display_name' => 'Administrar menú',
            'description'  => 'Permite crear, eliminar y ordenar el menú del sistema.',
        ]);
        $uploads = Permission::create([
            'name'         => 'app-upload',
            'display_name' => 'Cargas masivas',
            'description'  => '¡CUIDADO! Permite realizar cargas masivas de datos en el sistema.',
        ]);
        $parametersg = Permission::create([
            'name'         => 'app-parameterglobal',
            'display_name' => 'Administrar parámetros generales del Sistema',
            'description'  => 'Permite crear, eliminar y ordenar los parámetros generales del sistema.',
        ]);

        $this->rolOwner->attachPermissions([$menu, $parametersg, $uploads]);
        $this->rolAdmin->attachPermissions([$menu, $parametersg]);

        $reports = Permission::create([
            'name'         => 'report-index',
            'display_name' => 'Reportes',
            'description'  => 'Permite ejecutar reportes y exportarlos.',
        ]);
        $this->rolOwner->attachPermission($reports);
        $this->rolAdmin->attachPermissions([$reports,$uploads]);
        //$this->rolConsulta->attachPermission($reports);

        $this->createPermissions(User::class, 'usuarios', null,  true, false);
        $this->createPermissions(Permission::class, 'permisos', null, true, false);
        $this->createPermissions(Role::class, 'roles', null, true, false);
    }

}