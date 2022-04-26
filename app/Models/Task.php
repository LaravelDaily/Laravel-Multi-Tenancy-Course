<?php

namespace App\Models;

use App\Traits\FilterByUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, FilterByUser;

    protected $fillable = ['name', 'project_id', 'user_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /* ALTERNATIVE APPROACH
    protected static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $model->user_id = auth()->id();
        });

        self::addGlobalScope(function(Builder $builder) {
            $builder->whereHas('project', function($query) {
                $query->where('user_id', auth()->id());
            });
        });
    }
    */
}
