<?php

namespace Database\Factories;

use App\Models\MovieList;
use App\Models\ListType;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MovieList::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'list_type_id' => ListType::factory()->create(),
            'movie_id' => Movie::factory()->create(),
            'created_by' => User::factory()->create(),
        ];
    }
}
