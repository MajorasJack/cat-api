<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\MovieList;
use App\Models\ListType;
use App\Models\Movie;
use Faker\Generator as Faker;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(MovieList::class, function (Faker $faker) {
    return [
        'list_type_id' => factory(ListType::class)->create()->id,
        'movie_id' => factory(Movie::class)->create()->id,
        'created_by' => factory(User::class)->create()->id,
    ];
});
