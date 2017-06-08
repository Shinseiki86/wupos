<?php

namespace Wupos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelWithSoftDeletes extends Model
{
    use SoftDeletes;
    
    /**
     * Perform the actual delete query on this model instance.
     * 
     * @return void
     */
    protected function runSoftDelete()
    {
        $query = $this->newQuery()->where($this->getKeyName(), $this->getKey());

        $this->{$this->getDeletedAtColumn()} = $time = $this->freshTimestamp();

        $prefix = strtoupper(substr($this::CREATED_AT, 0, 4));
        $deleted_by = $prefix.'_eliminadopor';

        $query->update([
           $this->getDeletedAtColumn() => $this->fromDateTime($time),
           $deleted_by => auth()->user()->username
        ]);

        //$deleted_by => (\Auth::id()) ?: null
    }

    protected static function boot() {
        parent::boot();

        static::creating(function($model) {
            $prefix = strtoupper(substr($model->getKeyName(), 0, 4));
            $created_by = $prefix.'_creadopor';
            $model->$created_by = auth()->check() ? auth()->user()->username : 'SYSTEM';
            return true;
        });
        static::updating(function($model) {
            $prefix = strtoupper(substr($model->getKeyName(), 0, 4));
            $updated_by = $prefix.'_modificadopor';
            if (\Schema::hasColumn($model->getTable(), $updated_by)) {
                $model->$updated_by = auth()->check()
                    ? auth()->user()->username
                    : 'SYSTEM';
                return true;
            }
        });
    }

}
