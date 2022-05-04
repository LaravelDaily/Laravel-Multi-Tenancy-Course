<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class Tenant extends \Spatie\Multitenancy\Models\Tenant
{
    use HasFactory;

    protected $fillable = ['name', 'domain', 'database'];

    protected static function booted()
    {
        static::creating(function(Tenant $tenant) {
            $query = "CREATE DATABASE IF NOT EXISTS $tenant->database;";
            DB::statement($query);
        });

        static::created(function(Tenant $tenant) {
            Artisan::call('tenants:artisan "migrate --database=tenant"');
        });
    }
}
