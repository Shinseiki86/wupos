<?php

namespace Wupos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regional extends Model
{
	//Nombre de la tabla en la base de datos
	protected $table = 'REGIONALES';
    protected $primaryKey = 'REGI_id';

	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'REGI_fechacreado';
	const UPDATED_AT = 'REGI_fechamodificado';
	use SoftDeletes;
	const DELETED_AT = 'REGI_fechaeliminado';
	protected $dates = ['REGI_fechaeliminado'];

	protected $fillable = [
		'REGI_codigo',
		'REGI_nombre',
	];


	public function agencias()
	{
		$foreingKey = 'REGI_id';
		return $this->hasMany(Agencia::class, $foreingKey)
			->orderby($foreingKey);
	}


    /**
     * Retorna un array de las regionales existentes. Se utiliza en Form::select
     *
     * @param  null
     * @return Array
     */
    public static function getRegionales()
    {
        $regionales = self::orderBy('REGI_id')
                                ->select('REGI_id', 'REGI_nombre')
                                ->get();
        return $regionales;
    }

}
