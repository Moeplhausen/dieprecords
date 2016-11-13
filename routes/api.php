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

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');*/
Route::get('/gamemodes', 'ApiController@gamemodes');

Route::get('/tanks', 'ApiController@tanks');

Route::get('/records', 'ApiController@records');

Route::get('/records/{method}', 'ApiController@records');

Route::post('/submit/record', 'ApiController@submit')->middleware('throttle:20,60');
Route::post('/submit/recordtest', 'ApiController@submittest');

