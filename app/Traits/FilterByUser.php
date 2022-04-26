<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterByUser {

    protected static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $model->user_id = auth()->id();
        });

        self::addGlobalScope(function(Builder $builder) {
            $builder->where('user_id', auth()->id());
        });
    }

}
