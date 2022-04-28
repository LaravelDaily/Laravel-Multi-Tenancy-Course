<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterByTenant {

    public static function boot()
    {
        parent::boot();

        $currentTenantID = auth()->user()->current_tenant_id;

        self::creating(function($model) use ($currentTenantID) {
            $model->tenant_id = $currentTenantID;
        });

        self::addGlobalScope(function(Builder $builder) use ($currentTenantID) {
            $builder->where('tenant_id', $currentTenantID);
        });
    }

}
