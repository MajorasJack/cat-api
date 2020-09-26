<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ListType;
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

$factory->define(ListType::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'created_by' => factory(User::class)->create()->id,
    ];
});
