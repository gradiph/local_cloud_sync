<?php

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

Route::get('/', 'BookController@index');
Route::get('/random', 'BookController@random');

Route::prefix('/query')->name('query.')->group(function() {
    Route::post('/execute', 'QueryController@execute')->name('execute');
    Route::post('/get', 'QueryController@get')->name('get');
    Route::post('/set/uploaded', 'QueryController@setUploaded')->name('set.uploaded');
    Route::post('/set/executed', 'QueryController@setExecuted')->name('set/executed');
});
