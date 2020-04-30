<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Se pasa las variables con los array para construir el menú a la vista
        view()->composer('layouts.menu.menu-left', function($view) {
            $view->with('menusLeft', session()->get('menusLeft'));
        });
        view()->composer('layouts.menu.menu-top', function($view) {
            $view->with('menusTop', session()->get('menusTop'));
        });

        //Directiva Blade para imprimir una variable Carbon/Date con formato de fecha.
        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('d/m/Y h:i A'); ?>";
        });

        //Directiva Blade para incluir una vista Blade desde otra vista.
        //A diferencia de @include, la ruta no es estática sino relativa al blade desde donde se llama.
        Blade::directive('rinclude', function($expression) {
            $viewBasePath = config('view.paths')[0];
            $curCompiledFilePath = Blade::getPath();
            $paths = explode('/', substr($curCompiledFilePath, strlen($viewBasePath)), -1);
            $basePath = '';

            foreach($paths as $path) {
                $basePath .= $path . '.';
            }

            $basePath = trim($basePath, '.');

            if (starts_with($expression, '(')){
                $expression = substr($expression, 2, -2);
            }

            $expression = str_replace("'", "", $expression);

            return "<?php echo \$__env->make('$basePath.$expression', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>";
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
