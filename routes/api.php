<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| All routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group.
|
*/
Route::post('/auth/login', LoginController::class)
    ->middleware('throttle:10,1')
    ->name('login');

Route::post('/v1/users', [UserController::class, 'store']); 
Route::get('/v1/users/{user}', [UserController::class, 'show']);

Route::middleware('auth.token')->group(function () {
    Route::prefix('v1/users')->group(function () {
        Route::get('/', [UserController::class, 'all']);         
    });

});
