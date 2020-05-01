<?php

namespace App\Models;

use App\Models\ModelWithSoftDeletes;

class Certificado extends ModelWithSoftDeletes
{

	//Nombre de la tabla en la base de datos
	protected $table = 'CERTIFICADOS';
    protected $primaryKey = 'CERT_ID';
	protected $filterKey  = 'CERT_CODIGO';

	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'CERT_FECHACREADO';
	const UPDATED_AT = 'CERT_FECHAMODIFICADO';
	const DELETED_AT = 'CERT_FECHAELIMINADO';
	protected $dates = ['CERT_FECHACREADO', 'CERT_FECHAMODIFICADO', 'CERT_FECHAELIMINADO'];

	protected $fillable = [
        'CERT_CODIGO',
        'CERT_EQUIPO',
        'AGEN_ID',
	];

	public static function rules($id = 0){
		$rules = [
            'CERT_CODIGO' => ['required', 'string', 'max:4', static::unique($id,'CERT_CODIGO')],
            'CERT_EQUIPO' => ['required', 'string', 'max:15'],
            'AGEN_ID'     => ['required', 'numeric'],
		];
		return $rules;
	}

    public function agencia()
    {
        $foreingKey = 'AGEN_ID';
        return $this->belongsTo(Agencia::class, $foreingKey);
    }


}
