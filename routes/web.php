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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('OpenDataFile', 'OpenDataFileController', ['except' => [
    'show'
]]);
Route::group(['prefix' => 'OpenDataFile/{OpenDataFile}/'], function (){

    Route::get('/execute', 'OpenDataFileController@execute')->name('OpenDataFile.execute');

});

Route::resource('actor', 'ActorController', ['only' => [
    'show', 'index',
]]);

Route::resource('vote', 'VoteController', ['only' => [
    'show', 'index',
]]);

Route::resource('legislativeFolder', 'LegislativeFolderController', ['only' => [
    'show', 'index',
]]);

Route::resource('legislativeDocument', 'LegislativeDocumentController', ['only' => [
    'show', 'index',
]]);

Route::resource('amendment', 'AmendmentController', ['only' => [
    'show',
]]);


Auth::routes();

Route::get('/home', 'HomeController@index');


Route::group(['prefix' => 'admin'], function (){

    Route::get('/', 'AdminController@show')->name('admin.show');

});
