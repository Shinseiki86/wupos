<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;

trait SoftDeletesTrait
{
	use SoftDeletes;
	
    /**
     * Perform the actual delete query on this model instance.
     * 
     * @return void
     */
    protected function runSoftDelete()
    {
        $query = $this->newQueryWithoutScopes()->where($this->getKeyName(), $this->getKey());

        $this->{$this->getDeletedAtColumn()} = $time = $this->freshTimestamp();

        $prefix = strtoupper(substr($this::CREATED_AT, 0, 4));
        $deleted_by = $prefix.'_ELIMINADOPOR';

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
            $created_by = $prefix.'_CREADOPOR';
            if(!isset($model->$created_by)){
                $model->$created_by = auth()->check() ? auth()->user()->username : 'SYSTEM';
            }
            return true;
        });
        static::updating(function($model) {
            $prefix = strtoupper(substr($model->getKeyName(), 0, 4));
            $updated_by = $prefix.'_MODIFICADOPOR';
            if(!isset($model->$updated_by)){
                $model->$updated_by = auth()->check() ? auth()->user()->username : 'SYSTEM';
            }
            return true;
        });
    }

}