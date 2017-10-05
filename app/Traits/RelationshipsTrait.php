<?php

namespace Wupos\Traits;

use ErrorException;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Database\Eloquent\Relations\Relation;

/*
	https://laracasts.com/discuss/channels/eloquent/get-all-model-relationships
	@phildawson
	Obtener las relaciones (hasMany, ) que tiene un modelo.
*/
trait RelationshipsTrait
{
	public function relationships($onlyType=null) {

		//$model = new static;
		$relationships = [];

		foreach((new ReflectionClass($this))->getMethods(ReflectionMethod::IS_PUBLIC) as $method)
		{
			if ($method->class != get_class($this) ||
				!empty($method->getParameters()) ||
				$method->getName() == __FUNCTION__) {
				continue;
			}

			try {
				$return = $method->invoke($this);
				if ($return instanceof Relation) {

					$type = (new ReflectionClass($return))->getShortName();
					if($onlyType != null && $onlyType != $type)
						continue;

					$relModelName = (new ReflectionClass($return->getRelated()))->getName();
					$methodName = $method->getName();
					$count = $this->$methodName()->count();

					$relationships[$methodName] = [
						'type' => $type,
						'model' => $relModelName,
						'count' => $count,
					];
				}
			} catch(ErrorException $e) {}
		}

		return $relationships;
	}


}