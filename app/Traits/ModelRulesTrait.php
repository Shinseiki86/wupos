<?php

namespace Wupos\Traits;

trait ModelRulesTrait
{
    protected static function unique($id, $column, $table = null){
        $instance = new static;
        if(!isset($table))
            $table = $instance->table;
        return 'unique:'.$table.','.$column.','.$id.','.$instance->getKeyName();
    }

}