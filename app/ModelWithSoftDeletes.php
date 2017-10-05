<?php

namespace Wupos;

use Wupos\Traits\ModelRulesTrait;
use Wupos\Traits\SoftDeletesTrait;
use Wupos\Traits\RelationshipsTrait;
use Illuminate\Database\Eloquent\Model;

class ModelWithSoftDeletes extends Model
{
    use SoftDeletesTrait, RelationshipsTrait, ModelRulesTrait;

}
