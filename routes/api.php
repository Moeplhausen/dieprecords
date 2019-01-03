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
Route::get('/gamemodes', 'ApiController@gamemodes')->name('apigamemodes');

Route::get('/tanks', 'ApiController@tanks')->name('apitanks');

Route::get('/records', 'ApiController@records')->name('apirecords');

Route::get('/records/{method}', 'ApiController@records');
Route::get('/recordsByName/{name}', 'ApiController@recordsByName');


Route::get('/history/{tankid}/{gamemode}/{desktop}', 'ApiController@history');


Route::get('/names/edit/{token}/{discord_user}/{newName}', 'ApiController@editDiscordName');
Route::get('/names/manage/{token}/{discord_user}/{mayEdit}/{newName}', 'ApiController@setEditRightDiscordName');
Route::get('/names/add/{token}/{discord_user}/{request_name}', 'ApiController@setDiscordNameConnection');



//Route::post('/submit/record', 'ApiController@submit')->middleware('throttle:6,10');
//Route::post('/submit/recordtest', 'ApiController@submittest');



