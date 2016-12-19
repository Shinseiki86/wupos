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
		'AGEN_codigo',
		'AGEN_nombre',
		'AGEN_descripcion',
		'AGEN_cuentawu',
		'AGEN_activa',
		'REGI_id',
	];
	
	//public static $ENCU_estados = Config::get('enums.estados_encuesta');

	public function regional()
	{
		$foreingKey = 'REGI_id';
		return $this->belongsTo(Regional::class, $foreingKey);
	}

	public function certificados()
	{
		$foreingKey = 'AGEN_id';
		return $this->hasMany(Certificado::class, $foreingKey)
			->orderby($foreingKey);
	}

    /**
     * Retorna un array de las agencias existentes. Se utiliza en Form::select
     *
     * @param  null
     * @return Array
     */
    public static function getAgencias()
    {
        $agencias = self::orderBy('AGEN_id')
        				->where('AGEN_activa', true)
                        ->select('AGEN_id', 'AGEN_codigo', 'AGEN_nombre', 'REGI_id')
                        ->get();

        return $agencias;
    }

}
