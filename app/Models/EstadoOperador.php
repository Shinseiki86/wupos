<?php

namespace App\Models;

use App\Models\ModelWithSoftDeletes;

class EstadoOperador extends ModelWithSoftDeletes
{
	//Nombre de la tabla en la base de datos
	protected $table = 'ESTADOSOPERADORES';
    protected $primaryKey = 'ESOP_ID';

	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'ESOP_FECHACREADO';
	const UPDATED_AT = 'ESOP_FECHAMODIFICADO';
	const DELETED_AT = 'ESOP_FECHAELIMINADO';
	protected $dates = ['ESOP_FECHACREADO', 'ESOP_FECHAMODIFICADO', 'ESOP_FECHAELIMINADO'];


    //Constantes para referenciar los estados
    const PEND_CREAR    = 1;
    const CREADO        = 2;
    const PEND_ELIMINAR = 3;
    //const ELIMINADO     = 4;

	protected $fillable = [
		'ESOP_DESCRIPCION',
	];

	public static function rules($id = 0){
		return [
			'ESOP_DESCRIPCION' => ['required', 'max:50',static::unique($id,'ESOP_DESCRIPCION')],
		];
	}

	public function operadores()
	{
		$foreingKey = 'ESOP_ID';
		return $this->hasMany(Operador::class, $foreingKey);
	}


}
