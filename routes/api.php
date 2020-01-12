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

Route::get('/', function (Request $request) {
    return $request->user();
});

Route::get('/search', 'SearchController@index')->name('movie.search');

Route::get('/search/id', 'MovieSearchController@index')->name('movie.search.id');

Route::get('/movies', 'MovieController@index')->name('movies.index');
Route::get('/movies/{id}', 'MovieController@show')->name('movies.search');
Route::post('/movies/create', 'MovieController@store')->name('movies.create');
Route::patch('/movies/update', 'MovieController@update')->name('movies.update');
Route::delete('/movies/destroy', 'MovieController@destroy')->name('movies.destroy');
