<?php
/*
|--------------------------------------------------------------------------
| Funciones PHP Globales (Helpers)
|--------------------------------------------------------------------------
|
| Variedad de funciones creadas para ser utilizadas en cualquier proyecto,
| 
| 
|
*/

use Illuminate\Support\Arr;
use Carbon\Carbon;

use App\Models\ParametroGeneral;


if (! function_exists('expression_concat')) {
    /**
     * Crea un array con la llave primaria y una columna a partir de un Model.
     * Se utiliza para contruir <select> en los views.
     *
     * @param  string|Model  $class
     * @param  string  $column
     * @param  string  $primaryKey
     * @return array
     */
    function expression_concat($columns = [], $alias = null, $table = null, $glue=' ', $forceUpper=true)
    {
        if(config('database.default') == 'pgsql'){
            foreach ($columns as $key => $column) {
                $columns[$key] = (isset($table) ? '"'.$table.'".' : '').'"'.$column.'"';
            }
            if(isset($alias)){$alias = '"'.$alias.'"';};
        }
        $sqlIni = ($forceUpper?'UPPER':'').'(CONCAT_WS(\''.$glue.'\',';
        $sqlEnd = isset($alias) ? ')) AS '.$alias : '))';
        $sqlColumns = null;
        foreach ($columns as $column) {
            $sqlColumns = !isset($sqlColumns)
                ? $column
                : $sqlColumns.','.$column;
        }
        
        return \DB::raw($sqlIni.$sqlColumns.$sqlEnd);
    }
}

if (! function_exists('expression_count')) {
    /**
     * Crea un array con la llave primaria y una columna a partir de un Model.
     * Se utiliza para contruir <select> en los views.
     *
     * @param  string|Model  $class
     * @param  string  $column
     * @param  string  $primaryKey
     * @return array
     */
    function expression_count($table, $alias)
    {
        $query = \DB::table($table)
                    ->select(\DB::raw('COUNT(*)'))
                    ->toSql();

        if(isset($alias)){
            $alias = 'COUNT_'.$table;
        }

        return \DB::raw("({$query}) as \"".$alias."\"");
    }
}

if (! function_exists('model_to_array')) {
    /**
     * Crea un array con la llave primaria y una columna a partir de un Model.
     * Se utiliza para contruir <select> en los views.
     *
     * @param  string|Model  $class
     * @param  string  $column
     * @param  string  $primaryKey
     * @param  array  $whereArr
     * @return array
     */
    function model_to_array($class, $column, $primaryKey = null, $whereArr = [])
    {
        if( is_array($primaryKey) and empty($whereArr)){
            $whereArr = $primaryKey;
            $primaryKey = null;
        }

        if($class instanceof Illuminate\Database\Eloquent\Collection){
            if($class->isEmpty()){
                return [];
            } else {
                //Si es un Modelo, no se aplican las clausulas where.
                $model = $class;
                $primaryKey = isset($primaryKey) ? $primaryKey : $model->first()->getKeyName();
            }
        } else {

            $class = get_model($class);

            $primaryKey = isset($primaryKey) ? $primaryKey : (new $class)->getKeyName();
            $model = $class::orderBy($primaryKey)
                            ->select([ $primaryKey , $column ]);

            //Inclusión de clausulas where
            foreach ($whereArr as $where) {
                $columnWhere = $where[0];
                if(isset($where[2])){
                    $operatorWhere = $where[1];
                    $valueWhere = $where[2];
                } else {
                    $operatorWhere = '=';
                    $valueWhere = $where[1];
                }
                switch(strtolower($operatorWhere)){
                    case 'in': 
                        $model = $model->whereIn($columnWhere, $valueWhere);break;
                    case 'notin': 
                        $model = $model->whereNotIn($columnWhere, $valueWhere);break;
                    default:
                        $model = $model->where($columnWhere, $operatorWhere, $valueWhere);
                }
                
            }
        }

        //Si $column es una expresión, se adiciona alias a la columna (Compatibilidad para Postgress).
        if($column instanceof \Illuminate\Database\Query\Expression){
            $column = str_replace('"', '', array_last(explode(') AS ', $column->getValue())));
        }

        //Si $column es un array, se agrega $primaryKey y se retornan todas las columnas del array.
        if(is_array($column)){
            $column[] = $primaryKey;
            $model = $model->select($column)->get()->keyBy($primaryKey);
        }
        //Si $column es un string, sólo se retorna la columna solicitada.
        elseif (is_string($column)) {
            $model = $model->pluck($column, $primaryKey);
        }

        return $model->toArray();
    }
}


if (! function_exists('get_model')) {
    /** Valida que un modelo exista y retorna un string válido para utilizar.
     * 
     * @return string 
     */
    function get_model($name_model) {
        //$class = class_exists($class) ? $class : '\\App\\Models\\'.basename($class);
        return class_exists($name_model) ? $name_model : '\\App\\Models\\'.last(explode('\\',basename($name_model)));
    }
}

if (! function_exists('current_route_action')) {
    /**
     * 
     * @return string 
     */
    function current_route_action() {
        return explode("@", \Route::currentRouteAction())[1];
    }
}


if (! function_exists('array_implode')) {
    /**
     * Implode an array with the key and value pair giving
     * a glue, a separator between pairs and the array
     * to implode.
     * @param string $glue The glue between key and value
     * @param string $separator Separator between pairs
     * @param array $array The array to implode
     * @return string The imploded array
     */
    function array_implode( $glue, $separator, $array ) {
        if ( ! is_array( $array ) ) {return $array;}
        $string = array();
        foreach ( $array as $key => $val ) {
            if ( is_array( $val ) ){
                $val = implode( ',', $val );
            }
            $string[] = "{$key}{$glue}{$val}";
        }
        return implode( $separator, $string );
    }
}


if (! function_exists('img_to_base64')) {
    /**
     * Covertir imagen en base64.
     * @param string $pathImg Ruta del archivo.
     * @return string $dataUri
     */
    function img_to_base64( $pathImg ) {
        //
        $type = pathinfo($pathImg, PATHINFO_EXTENSION);
        $data = file_get_contents($pathImg);
        $dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $dataUri;
    }
}


if (! function_exists('delete_tree')) {
    /**
     * Borra archivos en el servidor.
     * @param string $dir Ruta del archivo.
     * @return bool $resultado 
     */
    function delete_tree( $dir ) {
        $files = array_diff(scandir($dir), array('.','..')); 
        foreach($files as $file) {
            //Primero se borran todos los archivos que se encuentran dentro de la carpeta
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
        } 
        //Y luego se borra la carpeta, retornando el valor
        //Un error de nivel E_WARNING será generado si se produce un error.
        return rmdir($dir); 
    }
}


if (! function_exists('str_upperspace')) {
    /**
     * Convierte un string sin espacios, en donde cada palabra inicia con mayúscula.
     * Ej: class_basename($modelo) //return "NombreClase"
     *     str_upperspace(class_basename($modelo)) //return "Nombre Clase"
     * @param string $str String sin espacios tipo NombrePropio.
     * @return string $str_space
     */
    function str_upperspace( $str ) {
        $pattern = '/([A-Z])/'; 
        $replacement = ' ${1}'; 
        $str_space = ltrim(preg_replace($pattern, $replacement, $str));
        return $str_space; 
    }
}


if (! function_exists('flash_alert')) {
    /**
     * Almacena un mensaje para ser presentado como alerta flotante en la vista.
     * @param string $msg Mensaje a presentar.
     * @param string $type Tipo de alerta. Puede ser: info, success, warning o danger.
     * @return void
     */
    function flash_alert( $msg, $type = 'info' ) {
        session()->flash('alert-'.$type, [$msg]);
    }
}


if (! function_exists('flash_modal')) {
    /**
     * Almacena un mensaje para ser presentado como ventana modal en la vista.
     * @param string $msg Mensaje a presentar.
     * @param string $type Tipo de modal. Puede ser: info, success, warning o danger.
     * @return void
     */
    function flash_modal( $msg, $type = 'info' ) {
        session()->flash('modal-'.$type, $msg);
    }
}


if (! function_exists('datetime')) {
    /**
     * Convierte un Date a String formateado
     * @param string|Date $date Fecha a convertir.
     * @return string Fecha formateada
     */
    function datetime( $date , $showTime=false) {
        $format = $showTime ? 'd/m/Y h:i A' : 'd/m/Y';
        return isset($date) ? $date->format($format) : null;
    }
}


if (! function_exists('get_logo')) {
    /**
     * Verifica si existe un logo definido por el usuario. Retorna la ruta del logo corporativo.
     * @return string Path
     */
    function get_logo() {
        return File::exists('images/logo-user.png')
            ? asset('images/logo-user.png')
            : asset('images/logo-default.png');
    }
}


if (! function_exists('convert_to_date')) {
    /**
     * Convierte una cadena de texto a una fecha
     * @param string $fecha_string fecha en formato de texto
     * @return Carbon
     */
    function convert_to_date($fecha_string) {
        return new Carbon($fecha_string);
    }
}

if (! function_exists('number_to_letter')) {
    /**
     * Convierte un número a formato basado en reglas de números escritos con palabras
     * !! NumberFormatter requiere habilitar extensión php_intl.dll en php.ini
     * @param  int $num
     * @return string
     */
    function number_to_letter($num, $lang = 'es') {
        $numFormat = new \NumberFormatter($lang, \NumberFormatter::SPELLOUT);
        return $numFormat->format($num);
    }
}

if (! function_exists('validaFecha')) {
    /**
     * Convierte una cadena de texto a una fecha
     * @param string $fecha_string Mensaje a presentar.
     * @return a date 
     */
    function validaFecha($fechaI,$fechaF) {
        $dtI = Carbon::parse($fechaI);
        $dtF = Carbon::parse($fechaF);
        $cant="true";
        if ($dtI>$dtF) {
            $cant="false";
        }
        return $cant;
    }
}


if (! function_exists('fechaActual')) {
    /**
     * Retorna la fecha actual
     * @return string 
     */
    function fechaActual() {  
        $date = Carbon::now();   
        return $date->toDateString(); 
    }
}


if (! function_exists('getGlobalParameter')) {
    /**
     * Retorna un parámetro general desde la base de datos.
     * @return string 
     */
    function getGlobalParameter($PAGE_DESCRIPCION, $valueDefault) {  
        $parameter = ParametroGeneral::where('PAGE_DESCRIPCION', $PAGE_DESCRIPCION)->first();
        if(isset($parameter)){
            $parameter = $parameter->PAGE_VALOR;
        }
        else{
            $parameter = $valueDefault;
        }

        return $parameter;
    }
}

if (! function_exists('getFechaHabilAdicionada')) {
    /**
     * Retorna una fecha calculada con base en una fecha inicial y un número de días. Esta fecha se encuentra excluida de días habiles y sin contar los días festivos
     * @return string 
     */
    function getFechaHabilAdicionada($fecha, $dias) {
        //se trae el parametro general que contiene todos los festivos
        $parameter = getGlobalParameter('DIAS_FESTIVOS', null);
        //se crea un arreglo con los festivos que trae el parametro anterior
        $festivos = explode(',', $parameter);
        //se Parsea la fecha que viene como parametro a Carbon
        $fechafinal = Carbon::parse($fecha);
        //se le suman los días que vienen como parametro
        $fechafinal->addWeekdays($dias);
        //se valida que festivos sea diferente de nulo
        if(isset($festivos)){
            //se recorren todos los festivos
            for($i = 1; $i <= $dias; $i++) {
                //se revisa si alguna de las fechas es un Festivo
                if(in_array(Carbon::parse($fecha)->addWeekdays($i)->toDateString(), $festivos)) {
                    $fechafinal->addDay();
                }
            }
        }
        else{
            $fechafinal = null;
        }

        return $fechafinal;
    }
}

if (! function_exists('number_to_ordinal')) {
    /**
     * Retorna un texto con los números ordinales
     * @return string 
     */
    function number_to_ordinal($num) {
        //se trae el parametro general que contiene todos los festivos
        $ordinal = [
            1=>'first',
            2=>'second',
            3=>'third',
            4=>'fourth',
        ];
        return $ordinal[$num];
    }
}



if (! function_exists('get_current_period')) {
    /**
     *  Retorna el periodo actual en formato "AAAA - SS",
     *  donde SS es 01 para primer semestre y 02 para segundo semestre. 
     * @return string
     */
    function get_current_period( ) {
        return Carbon::now()->year.' - '.(Carbon::now()->month<7?'01':'02');
    }
}