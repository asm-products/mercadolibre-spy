<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function() {
  return redirect('analysis');
});

// items
Route::get('analysis/{analysis}/items', 'ItemsController@index');
Route::post('items', 'ItemsController@follow');

// sources
Route::get('sources/parse', 'SourcesController@parse');
Route::get('analysis/{id}/sources', 'SourcesController@index');
Route::get('analysis/{id}/sources/create', 'SourcesController@create');
Route::put('analysis/{id}/sources', 'SourcesController@store');

// analysis
Route::get('analysis/{analysis}/delete', 'AnalysisController@destroy');
Route::resource('analysis', 'AnalysisController');

Route::controllers([

	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',

]);
