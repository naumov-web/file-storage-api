<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/v1')
    ->namespace('App\Http\Controllers\Api\V1')
    ->group(function() {
        Route::post('/auth', 'AuthController@login');

        Route::middleware(['auth.jwt'])->group(function() {
            Route::prefix('/account')
                ->namespace('Account')
                ->group(function () {
                    Route::get('/user', 'UserController@getCurrent');
                });
        });
    });
