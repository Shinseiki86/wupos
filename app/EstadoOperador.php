<?php

namespace Wupos;

use Illuminate\Database\Eloquent\Model;

class EstadoOperador extends ModelWithSoftDeletes
{
    //Nombre de la tabla en la base de datos
    protected $table = 'ESTADOSOPERADORES';
    protected $primaryKey = 'ESOP_id';

    //Traza: Nombre de campos en la tabla para auditoría de cambios
    const CREATED_AT = 'ESOP_fechacreado';
    const UPDATED_AT = 'ESOP_fechamodificado';
    const DELETED_AT = 'ESOP_fechaeliminado';
    protected $dates = ['ESOP_fechaeliminado'];

    protected $fillable = [
        'ESOP_descripcion',
    ];

    //Constantes para referenciar los estados
    const PEND_CREAR    = 1;
    const CREADO        = 2;
    const PEND_ELIMINAR = 3;
    const ELIMINADO     = 4;

    public function operadores()
    {
        $foreingKey = 'REGI_id';
        return $this->hasMany(Operador::class, $foreingKey);
    }


}
