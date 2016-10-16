<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'RecordsController@show');
Route::post('/submitrecord','RecordsController@submit');

Route::post('/login','AuthController@login');


Route::group(['middleware'=>'auth.basic'],function (){
    Route::get('/submissions', 'SubmissionsController@show');
    Route::post('/decidesubmission','SubmissionsController@decide');
    Route::post('/logout','AuthController@logout');
});