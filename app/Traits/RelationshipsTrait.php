<?php

namespace App\Traits;

use Exception;
use ErrorException;
use BadMethodCallException;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Database\Eloquent\Relations\Relation;

/*
	https://laracasts.com/discuss/channels/eloquent/get-all-model-relationships
	@phildawson
	Obtener las relaciones (BelongsTo, hasMany, BelongsToMany, ...) que tiene un modelo.
*/
trait RelationshipsTrait
{
	public function relationships($onlyType=null) {
		$relationships = [];

		if (!in_array(get_class($this), ['App\Models\User','App\Models\Role','App\Models\Permission'])){

			foreach((new ReflectionClass($this))->getMethods(ReflectionMethod::IS_PUBLIC) as $method){
				if ($method->class != get_class($this) ||
					!empty($method->getParameters()) ||
					$method->getName() == __FUNCTION__) {
					continue;
				}
				try {
					$return = $method->invoke($this);
					if ($return instanceof Relation) {

						$type = (new ReflectionClass($return))->getShortName();
						if( $onlyType != null && $onlyType != $type ){
							continue;
						}
						$modelRelated = $return->getRelated();
						$relModelName = (new ReflectionClass($modelRelated))->getName();
						$methodName = $method->getName();
						$count = $this->$methodName()->count();

						$relationships[$methodName] = [
							'type'       => $type,
							'primaryKey' => $modelRelated->primaryKey,
							'model'      => $relModelName,
							'count'      => $count,
						];
					}
				} catch(ErrorException $e) {} catch(BadMethodCallException $e){}
			}

		}
		
		return $relationships;
	}


	public static function getRelationships(){
		$model = new static;
		return $model->relationships();
	}


}