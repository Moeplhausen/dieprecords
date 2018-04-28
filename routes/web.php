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

Route::get('/', 'RecordsController@showRecords')->name('records');

Route::get('/top100', 'RecordsController@showTOP100Records')->name('top100');


Route::get('/info', function () {
    return view('apiInfo');
})->name('info');
Route::post('/submitrecord', 'RecordsController@submit')->name('submitrecord');

Route::get('/statistics', 'RecordsController@showBestTanks')->name('statistics');

Route::post('/login', 'AuthController@login')->name('login');


Route::get('/records/users/{name}', 'RecordsController@showRecordsByName');

Route::get('/rejections', 'SubmissionsController@showrejections')->name('rejections');

Route::get('/submissions', 'SubmissionsController@show')->name('submissions');


Route::group(['middleware' => ['redirectGuests', 'auth.basic']], function () {

    Route::post('/decidesubmission', 'SubmissionsController@decide')->name('decidesubmission');
    Route::post('/logout', 'AuthController@logout')->name('logout');
});


