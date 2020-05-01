<?php

namespace App\Models;

use App\Models\ModelWithSoftDeletes;

class Operador extends ModelWithSoftDeletes
{

	//Nombre de la tabla en la base de datos
	protected $table = 'OPERADORES';
    protected $primaryKey = 'OPER_ID';
	protected $filterKey  = 'OPER_CEDULA';

	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'OPER_FECHACREADO';
	const UPDATED_AT = 'OPER_FECHAMODIFICADO';
	const DELETED_AT = 'OPER_FECHAELIMINADO';
	protected $dates = ['OPER_FECHACREADO', 'OPER_FECHAMODIFICADO', 'OPER_FECHAELIMINADO'];

	protected $fillable = [
        'OPER_CODIGO',
        'OPER_CEDULA',
        'OPER_NOMBRE',
        'OPER_APELLIDO',
        'REGI_ID',
        'ESOP_ID',
	];

	public static function rules($id = 0){
		$rules = [
            'OPER_CEDULA' => ['required', 'numeric', 'digits_between:1,15', static::unique($id,'OPER_CEDULA')],
            'OPER_NOMBRE' => ['required', 'string', 'max:100'],
            'OPER_APELLIDO' => ['required', 'string', 'max:100'],
            'REGI_ID' => ['required', 'numeric'],
            'ESOP_ID' => ['required', 'numeric'],
		];
		return $rules;
	}

    public function regional()
    {
        $foreingKey = 'REGI_ID';
        return $this->belongsTo(Regional::class, $foreingKey);
    }

    public function estado()
    {
        $foreingKey = 'ESOP_ID';
        return $this->belongsTo(EstadoOperador::class, $foreingKey);
    }


}
