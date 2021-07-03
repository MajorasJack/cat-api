<?php

use Illuminate\Support\Facades\Route;

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


Route::middleware('auth:api')->group(function () {
    Route::get('/me', 'MeController@index')->name('me.index');

    Route::get('/search', 'TheMovieDbApiController@index')->name('movie.search.index');
    Route::get('/search/{id}', 'TheMovieDbApiController@show')->name('movie.search.show');

    Route::get('/ean-lookup/{ean}', 'EanLookupController@show')->name('ean.lookup.show');

    Route::get('/distributors', 'DistributorController@index')->name('distributors.index');

    Route::apiResource('/movies', 'MovieController');

    Route::apiResource('/movie-lists', 'MovieListController');
});
