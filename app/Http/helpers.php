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


if (! function_exists('model_to_array')) {
    /**
     * Crea un array con la llave primaria y una columna a partir de un Model.
     * Se utiliza para contruir <select> en los views.
     *
     * @param  string|object  $class
     * @param  string  $column
     * @param  string  $primaryKey
     * @return array
     */
    function model_to_array($class, $column, $primaryKey = null)
    {

        if(is_object($class)){
            $models = $class;
            $primaryKey = isset($primaryKey) ? $primaryKey : $models->first()->getKeyName();
        } else {

            $class = class_exists($class) ? $class : '\\Eva360\\'.basename(str_replace('\\', '/', $class));
            $primaryKey = isset($primaryKey) ? $primaryKey : (new $class)->getKeyName();
            $models = $class::orderBy($primaryKey)
                            ->get([ $primaryKey , $column ]);
        }

        $array = [];
        foreach ($models as $model) {
            $array = Arr::add(
                $array,
                $model->$primaryKey,
                $model->$column
            );
        }

        return $array;
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
        if ( ! is_array( $array ) ) return $array;
        $string = array();
        foreach ( $array as $key => $val ) {
            if ( is_array( $val ) )
                $val = implode( ',', $val );
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
        if(session()->has('alert-'.$type)){
            $msg = session()->get('alert-'.$type) + [$msg];
        } else {
            $msg = [$msg];
        }
        session()->flash('alert-'.$type, $msg);
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
