<?php

use Illuminate\Support\Arr;


if (! function_exists('model_to_array')) {
    /**
     * Crea un array con la llave primaria y una columna a partir de un Model.
     * Se utiliza para contruir <select> en los views.
     *
     * @param  string  $class
     * @param  string  $column
     * @param  string  $primaryKey
     * @return array
     */
    function model_to_array($class, $column, $primaryKey = null)
    {
        $primaryKey = isset($primaryKey) ? $primaryKey : (new $class)->getKeyName();

        //Se crea una colección con los estados disponibles
        $models = $class::orderBy($primaryKey)
                        ->get([ $primaryKey , $column ]);

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
