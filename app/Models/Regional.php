<?php

namespace App\Models;

use App\Models\ModelWithSoftDeletes;

class Regional extends ModelWithSoftDeletes
{
	//Nombre de la tabla en la base de datos
	protected $table = 'REGIONALES';
    protected $primaryKey = 'REGI_ID';
	protected $filterKey  = 'REGI_NOMBRE';

	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'REGI_FECHACREADO';
	const UPDATED_AT = 'REGI_FECHAMODIFICADO';
	const DELETED_AT = 'REGI_FECHAELIMINADO';
	protected $dates = ['REGI_FECHACREADO', 'REGI_FECHAMODIFICADO', 'REGI_FECHAELIMINADO'];

	protected $appends = ['count_agencias',];

	protected $fillable = [
		'REGI_CODIGO',
		'REGI_NOMBRE',
	];

	public static function rules($id = 0){
		return [
            'REGI_CODIGO' => ['required', 'numeric',static::unique($id,'REGI_CODIGO')],
			'REGI_NOMBRE' => ['required', 'max:300',static::unique($id,'REGI_NOMBRE')],
		];
	}

	public function agencias()
	{
		$foreingKey = 'REGI_ID';
		return $this->hasMany(Agencia::class, $foreingKey);
	}


	/**
	 * Retorna el total de agencias por regional
	 *
	 * @param  void
	 * @return integer
	 */
	public function getCountAgenciasAttribute()
	{
		return $this->agencias->count();
	}

}
