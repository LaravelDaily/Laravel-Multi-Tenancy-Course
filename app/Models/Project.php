<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

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
