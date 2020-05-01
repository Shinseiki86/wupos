<?php

namespace App\Models;

use App\Models\ModelWithSoftDeletes;

class Agencia extends ModelWithSoftDeletes
{

	//Nombre de la tabla en la base de datos
	protected $table = 'AGENCIAS';
    protected $primaryKey = 'AGEN_ID';
	protected $filterKey  = 'AGEN_NOMBRE';

	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'AGEN_FECHACREADO';
	const UPDATED_AT = 'AGEN_FECHAMODIFICADO';
	const DELETED_AT = 'AGEN_FECHAELIMINADO';
	protected $dates = ['AGEN_FECHACREADO', 'AGEN_FECHAMODIFICADO', 'AGEN_FECHAELIMINADO'];

	protected $appends = ['count_certificados'];

	protected $fillable = [
		'AGEN_CODIGO',
		'AGEN_NOMBRE',
		'AGEN_DESCRIPCION',
		'AGEN_CUENTAWU',
		'AGEN_ACTIVA',
		'REGI_ID',
	];

	public static function rules($id = 0){
		$rules = [
			'AGEN_CODIGO' => ['required','numeric',static::unique($id,'AGEN_CODIGO')],
			'AGEN_NOMBRE' => ['required','max:100',static::unique($id,'AGEN_NOMBRE')],
			'AGEN_DESCRIPCION' => ['max:300'],
			'REGI_ID'     => ['required','numeric']
		];
		return $rules;
	}

	public function certificados()
	{
		$foreingKey = 'AGEN_ID';
		return $this->hasMany(Certificado::class, $foreingKey);
	}

	public function regional()
	{
		$foreingKey = 'REGI_ID';
		return $this->belongsTo(Regional::class, $foreingKey);
	}


	/**
	 * Retorna el total de certificados por agencia
	 *
	 * @param  void
	 * @return integer
	 */
	public function getCountCertificadosAttribute()
	{
		return $this->certificados->count();
	}
}
