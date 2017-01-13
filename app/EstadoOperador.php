<?php

namespace Wupos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoOperador extends Model
{
    //Nombre de la tabla en la base de datos
    protected $table = 'ESTADOSOPERADORES';
    protected $primaryKey = 'ESOP_id';

    //Traza: Nombre de campos en la tabla para auditoría de cambios
    const CREATED_AT = 'ESOP_fechacreado';
    const UPDATED_AT = 'ESOP_fechamodificado';
    use SoftDeletes;
    const DELETED_AT = 'ESOP_fechaeliminado';
    protected $dates = ['ESOP_fechaeliminado'];

    protected $fillable = [
        'ESOP_descripcion',
    ];

    public function operadores()
    {
        $foreingKey = 'REGI_id';
        return $this->hasMany(Operador::class, $foreingKey);
    }


}
