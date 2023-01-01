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
    ->name('api.v1.')
    ->group(function() {
        Route::post('/auth', 'AuthController@login');

        Route::middleware(['auth.jwt'])->group(function() {
            Route::prefix('/account')
                ->namespace('Account')
                ->name('account.')
                ->group(function () {
                    Route::get('/user', 'UserController@getCurrent');
                    Route::put('/user', 'UserController@updateCurrent');
                });

            Route::prefix('/admin')
                ->namespace('Admin')
                ->name('admin.')
                ->middleware(['access'])
                ->group(function () {
                    Route::post('/invitations', 'InvitationsController@create')
                        ->name('invitations.create');
                });
        });

        Route::get('/invitations/confirm', 'InvitationsController@confirm')
            ->name('invitations.confirm');
    });
