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

Route::get('/search', 'MovieSearchController@index')->name('movie.search.index');
Route::get('/search/id', 'MovieSearchController@show')->name('movie.search.show');

Route::get('/movies', 'MovieController@index')->name('movies.index');
Route::get('/movies/{id}', 'MovieController@show')->name('movies.show');
Route::post('/movies/create', 'MovieController@store')->name('movies.create');
Route::patch('/movies/update', 'MovieController@update')->name('movies.update');
Route::delete('/movies/destroy', 'MovieController@destroy')->name('movies.destroy');
