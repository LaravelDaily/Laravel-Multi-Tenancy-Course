<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => 'auth'], function() {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::resource('tasks', \App\Http\Controllers\TaskController::class);
    Route::resource('projects', \App\Http\Controllers\ProjectController::class);

    Route::get('tenants/change/{tenantID}', [\App\Http\Controllers\TenantController::class, 'changeTenant'])
        ->name('tenants.change');

    Route::resource('users', \App\Http\Controllers\UserController::class)
        ->only('index', 'store')
        ->middleware('can:manage_users');
});

Route::get('invitations/{token}', [\App\Http\Controllers\UserController::class, 'acceptInvitation'])
    ->name('invitations.accept');

require __DIR__.'/auth.php';
