<?php

namespace App\Traits;

trait ModelRulesTrait
{
    /**
     * Regla para validar que el nuevo registro sea único en la tabla.
     * En caso de ser una modificación, excluye el registro actual.
     * @param  type  $obj
     * @return 
     */
    protected static function unique($rowIgnore, $column, $table = null){
        $instance = new static;
        if(!isset($table)){
            $table = $instance->getTable();
        }
        return 'unique:'.$table.','.$column.','.$rowIgnore.','.$instance->getKeyName();
    }

    /**
     * Regla para validar que múltiples columnas sean únicas en la tabla.
     * En caso de ser una modificación, excluye el registro actual.
     * Librería: felixkiss/uniquewith-validator
     * @param  type  $obj
     * @return 
     */
    protected static function uniqueWith($rowIgnore, $columns = [], $table = null){
        if(!empty($columns)){
	        $instance = new static;
	        if(!isset($table)){
	            $table = $instance->getTable();
            }
        	return 'unique_with:'.$table.','.implode(',',$columns).','.$rowIgnore.'='.$instance->getKeyName();
        }
    }

}