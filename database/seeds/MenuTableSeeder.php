<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Permission;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        list($orderMenuLeft, $orderMenuTop) = $this->createItemsSystem();

    //LEFT
        $orderItem = 0;
        $parent = Menu::create([
            'MENU_LABEL' => 'Parámetros',
            'MENU_ICON' => 'fas fa-cog',
            'MENU_ORDER' => $orderMenuLeft++,
        ]);
            Menu::create([
                'MENU_LABEL' => 'Regionales',
                'MENU_URL' => 'gyf/regionales',
                'MENU_ICON' => 'fas fa-university',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('regional-index'),
            ]);
            Menu::create([
                'MENU_LABEL' => 'Agencias',
                'MENU_URL' => 'gyf/agencias',
                'MENU_ICON' => 'fas fa-piggy-bank',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('agencia-index'),
            ]);


		
    //TOP
        $parent = Menu::create([
            'MENU_LABEL' => 'Gestión Certificados',
            'MENU_URL' => 'wu/certificados',
            'MENU_ICON' => 'fas fa-address-card',
            'MENU_ORDER' => $orderMenuTop++,
            'MENU_POSITION' => 'TOP',
            'PERM_ID' => $this->getPermission('certificado-index'),
        ]);

        $parent = Menu::create([
            'MENU_LABEL' => 'Gestión Operadores',
            'MENU_URL' => 'wu/operadores',
            'MENU_ICON' => 'fas fa-user-secret',
            'MENU_ORDER' => $orderMenuTop++,
            'MENU_POSITION' => 'TOP',
            'PERM_ID' => $this->getPermission('operador-index'),
        ]);





    //Extras
        $parent = Menu::create([
            'MENU_LABEL' => 'Reportes',
            'MENU_ICON' => 'fas fa-chart-pie',
            'MENU_URL' => 'reports',
            'MENU_ORDER' => $orderMenuLeft++,
            'PERM_ID' => $this->getPermission('report'),
        ]);
    }

	
    //Obtiene el permiso
    private function getPermission($namePermission)
    {
        $perm = Permission::where('name', $namePermission)->get()->first();
        if(isset($perm))
            return $perm->id;
        return null;
    }

    //
    private function createItemsSystem()
    {
        $orderMenuLeft = 0;
        $orderMenuTop = 0;

        $orderItem = 0;
        $parent = Menu::create([
            'MENU_LABEL' => 'Sistema',
            'MENU_ICON' => 'fas fa-cogs',
            'MENU_ORDER' => $orderMenuLeft++,
        ]);

            $orderItem2 = 0;
            $parent2 = Menu::create([
                'MENU_LABEL' => 'Usuarios y roles',
                'MENU_ICON' => 'fas fa-user-circle',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
            ]);
                Menu::create([
                    'MENU_LABEL' => 'Usuarios',
                    'MENU_URL' => 'auth/usuarios',
                    'MENU_ICON' => 'fas fa-user',
                    'MENU_PARENT' => $parent2->MENU_ID,
                    'MENU_ORDER' => $orderItem2++,
                    'PERM_ID' => $this->getPermission('user-index'),
                ]);
                Menu::create([
                    'MENU_LABEL' => 'Roles',
                    'MENU_URL' => 'auth/roles',
                    'MENU_ICON' => 'fas fa-male',
                    'MENU_PARENT' => $parent2->MENU_ID,
                    'MENU_ORDER' => $orderItem2++,
                    'PERM_ID' => $this->getPermission('role-index'),
                ]);
                Menu::create([
                    'MENU_LABEL' => 'Permisos',
                    'MENU_URL' => 'auth/permisos',
                    'MENU_ICON' => 'fas fa-address-card',
                    'MENU_PARENT' => $parent2->MENU_ID,
                    'MENU_ORDER' => $orderItem2++,
                    'PERM_ID' => $this->getPermission('permission-index'),
                ]);

            // $orderItem2 = 0;
            // $parent2 = Menu::create([
            //     'MENU_LABEL' => 'Geográficos',
            //     'MENU_ICON' => 'fas fa-globe-americas',
            //     'MENU_PARENT' => $parent->MENU_ID,
            //     'MENU_ORDER' => $orderItem++,
            // ]);
            //     Menu::create([
            //         'MENU_LABEL' => 'Países',
            //         'MENU_URL' => 'cnfg-geograficos/paises',
            //         'MENU_ICON' => 'fas fa-map-marker-alt',
            //         'MENU_PARENT' => $parent2->MENU_ID,
            //         'MENU_ORDER' => $orderItem2++,
            //         'PERM_ID' => $this->getPermission('pais-index'),
            //     ]);
            //     Menu::create([
            //         'MENU_LABEL' => 'Departamentos',
            //         'MENU_URL' => 'cnfg-geograficos/departamentos',
            //         'MENU_ICON' => 'fas fa-map-marker-alt',
            //         'MENU_PARENT' => $parent2->MENU_ID,
            //         'MENU_ORDER' => $orderItem2++,
            //         'PERM_ID' => $this->getPermission('departamento-index'),
            //     ]);
            //     Menu::create([
            //         'MENU_LABEL' => 'Ciudades',
            //         'MENU_URL' => 'cnfg-geograficos/ciudades',
            //         'MENU_ICON' => 'fas fa-map-marker-alt',
            //         'MENU_PARENT' => $parent2->MENU_ID,
            //         'MENU_ORDER' => $orderItem2++,
            //         'PERM_ID' => $this->getPermission('ciudad-index'),
            //     ]);
            //     Menu::create([
            //         'MENU_LABEL' => 'Barrios',
            //         'MENU_URL' => 'cnfg-geograficos/barrios',
            //         'MENU_ICON' => 'fas fa-map-marker-alt',
            //         'MENU_PARENT' => $parent2->MENU_ID,
            //         'MENU_ORDER' => $orderItem2++,
            //         'PERM_ID' => $this->getPermission('barrio-index'),
            //     ]);

            Menu::create([
                'MENU_LABEL' => 'Menú',
                'MENU_URL' => 'app/menu',
                'MENU_ICON' => 'fas fa-bars',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'MENU_ENABLED' => true,
                'PERM_ID' => $this->getPermission('app-menu'),
            ]);
            Menu::create([
                'MENU_LABEL' => 'Carga masiva',
                'MENU_URL' => 'app/upload',
                'MENU_ICON' => 'fas fa-cog',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('app-upload'),
            ]);
            Menu::create([
                'MENU_LABEL' => 'Parámetros del Sistema',
                'MENU_URL' => 'app/parametrosgenerales',
                'MENU_ICON' => 'fas fa-bolt',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('app-parametrosgenerales'),
            ]);
            /*Menu::create([
                'MENU_LABEL' => 'Parámetros generales',
                'MENU_URL' => 'app/parameters',
                'MENU_ICON' => 'fas fa-cog',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('app-parameters'),
           ]);*/


        return [$orderMenuLeft, $orderMenuTop];
    }
}
