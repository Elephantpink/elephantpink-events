<?php

use Illuminate\Http\Request;

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

Route::prefix('api/v1/')->namespace('\EPink\Events\Http\Controllers')->middleware('api')->group(function() {
    Route::apiResource('events', 'EventsController');

    Route::options('{any?}', function (){
        return response(null, 204);
    })->where('any', '.*');
});