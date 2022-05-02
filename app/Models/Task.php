<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToPrimaryModel;

class Task extends Model
{
    use HasFactory, BelongsToPrimaryModel;

    protected $fillable = ['name', 'project_id'];

    public function getRelationshipToPrimaryModel(): string
    {
        return 'project';
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
