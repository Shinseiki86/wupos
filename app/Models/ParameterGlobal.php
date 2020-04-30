<?php

namespace App\Models;

use App\Models\ModelWithSoftDeletes;

class ParameterGlobal extends ModelWithSoftDeletes
{
	
	//Nombre de la tabla en la base de datos
	protected $table = 'parameters_global';
	protected $primaryKey = 'PGLO_ID';

	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'PGLO_FECHACREADO';
	const UPDATED_AT = 'PGLO_FECHAMODIFICADO';
	const DELETED_AT = 'PGLO_FECHAELIMINADO';
	protected $dates = ['PGLO_FECHACREADO', 'PGLO_FECHAMODIFICADO', 'PGLO_FECHAELIMINADO'];

	protected $fillable = [
		'PGLO_DESCRIPCION',
		'PGLO_VALOR',
		'PGLO_OBSERVACIONES',
	];

	public static function rules($id = 0){
		return [
			'PGLO_DESCRIPCION' => 'required|max:100|'.static::unique($id,'PGLO_DESCRIPCION'),
			'PGLO_VALOR' => 'required',
			'PGLO_OBSERVACIONES' => 'max:300',
		];
	}


}
