<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends \Spatie\Multitenancy\Models\Tenant
{
    use HasFactory;

    protected $fillable = ['name', 'domain', 'database'];
}
