<?php

namespace Wupos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agencia extends Model
{
	//Nombre de la tabla en la base de datos
	protected $table = 'AGENCIAS';
    protected $primaryKey = 'AGEN_id';

	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'AGEN_fechacreado';
	const UPDATED_AT = 'AGEN_fechamodificado';
	use SoftDeletes;
	const DELETED_AT = 'AGEN_fechaeliminado';
	protected $dates = ['AGEN_fechaeliminado'];

	protected $fillable = [
		'AGEN_nombre',
		'AGEN_descripcion',
		'AGEN_activa',
		'REGI_id',
	];

	
	//public static $ENCU_estados = Config::get('enums.estados_encuesta');

	public function regional()
	{
		$foreingKey = 'REGI_id';
		return $this->belongsTo(Regional::class, $foreingKey);
	}

}
