<?php

namespace App\Models;

use App\Traits\ModelRulesTrait;
use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Report extends Model implements AuditableContract
{
    use ModelRulesTrait, AuditableTrait;

	//Nombre de la tabla en la base de datos
	//protected $table = 'reports';

	protected $fillable = [
		'id',
		'code',
		'name',
		'controller',
		'action',
		'filter_required',
		'enable',
	];

	public static function rules($id = 0){
		$rules = [
			'code'       => ['required','max:4',static::unique($id,'code')],
			'name'       => ['required','max:300',static::unique($id,'name')],
			'controller' => ['required','max:50'],
			'action'     => ['required','max:50'],
			'filter_required'     => ['required','boolean'],
			'enable'     => ['required','boolean'],
		];
		return $rules;
	}
	
	public function roles()
	{
		return $this->belongsToMany(Role::class);
	}
}