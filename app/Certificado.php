<?php

namespace Wupos;

use Illuminate\Database\Eloquent\Model;

class Certificado extends ModelWithSoftDeletes
{
	//Nombre de la tabla en la base de datos
	protected $table = 'CERTIFICADOS';
    protected $primaryKey = 'CERT_id';

	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'CERT_fechacreado';
	const UPDATED_AT = 'CERT_fechamodificado';
	const DELETED_AT = 'CERT_fechaeliminado';
	protected $dates = ['CERT_fechaeliminado'];

	protected $fillable = [
		'CERT_codigo',
		'CERT_equipo',
		'AGEN_id',
	];

	public function agencia()
	{
		$foreingKey = 'AGEN_id';
		return $this->belongsTo(Agencia::class, $foreingKey);
	}

}
