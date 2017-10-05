<?php

namespace Wupos;

use Wupos\ModelWithSoftDeletes;

class Operador extends ModelWithSoftDeletes
{

    //Nombre de la tabla en la base de datos
    protected $table = 'OPERADORES';
    protected $primaryKey = 'OPER_id';

    //Traza: Nombre de campos en la tabla para auditoría de cambios
    const CREATED_AT = 'OPER_fechacreado';
    const UPDATED_AT = 'OPER_fechamodificado';
    const DELETED_AT = 'OPER_fechaeliminado';
    protected $dates = ['OPER_fechaeliminado'];

    protected $fillable = [
        'OPER_codigo',
        'OPER_cedula',
        'OPER_nombre',
        'OPER_apellido',
        'REGI_id',
        'ESOP_id',
        'OPER_creadopor',
        'OPER_modificadopor',
        'OPER_eliminadopor',
        'OPER_fechamodificado',
    ];
    
    public function regional()
    {
        $foreingKey = 'REGI_id';
        return $this->belongsTo(Regional::class, $foreingKey);
    }

    public function estado()
    {
        $foreingKey = 'ESOP_id';
        return $this->belongsTo(EstadoOperador::class, $foreingKey);
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($model) {
            $model->update(['ESOP_id' => EstadoOperador::ELIMINADO]);
            return true;
        });
    }

}
