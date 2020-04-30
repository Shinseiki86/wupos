<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
	
	//Nombre de la tabla en la base de datos
	protected $table = 'audits';
	protected $primaryKey = 'id';

	//Traza: Nombre de campos en la tabla para auditoría de cambios
	const CREATED_AT = 'created_at';
	const UPDATED_AT = 'updated_at';
	protected $dates = ['created_at', 'updated_at'];

}
