<?php

namespace App\Models;

use App\Contracts\UuidInterface;
use Auth;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Str;
use Schema;

class Model extends EloquentModel
{
    protected $hidden = ['id', 'pivot'];

    static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            if ($model instanceof UuidInterface) {
                $model->uuid = Str::orderedUuid()->toString();
            }

            if (Schema::hasColumn($model->getTable(), 'user_id') && is_null($model->user_id))
            {
                if (Auth::user() instanceof User) {
                    $model->user_id = Auth::user()->uuid;
                }
            }
        });
    }

    public function resolveRouteBinding($value, $field = null)
    {
        if (Schema::hasColumn($this->getTable(), 'user_id') && Auth::user() instanceof User)
        {
            return $this->where([
                $field ?? $this->getRouteKeyName() => $value,
                'user_id' => Auth::user()->uuid
            ])
            ->first();
        }

        return parent::resolveRouteBinding($value, $field);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
