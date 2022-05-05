<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    'auth',
    InitializeTenancyBySubdomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::resource('tasks', \App\Http\Controllers\TaskController::class);
    Route::resource('projects', \App\Http\Controllers\ProjectController::class);

    Route::get('accounts/delete', [\App\Http\Controllers\UserController::class, 'destroy'])
        ->name('account-delete');
});
