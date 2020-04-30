<?php

namespace App\Models;

use App\Traits\ModelRulesTrait;
use App\Traits\RelationshipsTrait;

use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements AuditableContract
{
    use Notifiable, EntrustUserTrait, AuditableTrait, ModelRulesTrait, RelationshipsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'cedula',
        'email',
        'password',
        'USER_CREADOPOR',
        'USER_MODIFICADOPOR',
    ];


    //Traza: Nombre de campos en la tabla para auditoría de cambios
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';
    const DELETED_AT = 'deleted_at';
    protected $dates = ['created_at', 'modified_at', 'deleted_at'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Attributes to exclude from the Audit.
     *
     * @var array
     */
    protected $auditExclude = [
        'password',
        'remember_token',
    ];
    
    public static function rules($id = 0){
        return [
            'name'      => ['required','max:255'],
            'cedula'    => ['required','max:15',static::unique($id,'cedula')],
            'email'     => ['required','email','max:320',static::unique($id,'email')],
            'username'  => $id!=0 ? [] : ['required','max:15',static::unique($id,'username')],
            'roles'     => ['required','array'],
            'password'  => $id!=0 ? [] : ['required'.'min:6','confirmed'],//regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/
        ];
    }


    /**
     * Relations with roles
     * 
     * @return Collection
     */
    public function roles(){
        return $this->belongsToMany(Role::class);
    }


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
            $model->username = strtolower($model->username);
            if(!isset($model->USER_CREADOPOR)){
                $model->USER_CREADOPOR = auth()->check() ? auth()->user()->username : 'SYSTEM';
            }
            return true;
        });
        static::updating(function($model) {
            $model->USER_MODIFICADOPOR = auth()->check() ? auth()->user()->username : 'SYSTEM';
            return true;
        });
    }

    public static function resolveId() {
        return auth()->check() ? auth()->user()->getAuthIdentifier() : null;
    }
}
