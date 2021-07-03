<?php

namespace Tests\Feature;

use App\Models\Movie;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class MovieListTest extends TestCase
{
    public function testItCanCreateAMovieListWithoutSupplyingMovies()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $this->post('movie-lists', [
            'title' => $this->faker->word,
        ])
            ->assertCreated()
            ->assertJsonStructure([
                'title',
            ]);
    }

    public function testItCanCreateAMovieListWhenSupplyingMovies()
    {
        $user = User::factory()->create();

        $movies = Movie::factory()->count(5)->create();

        $title = $this->faker->word;

        Passport::actingAs($user);

        $formattedMovies = array_map(function ($movie) {
            return [
                'id' => $movie['id'],
                'external_id' => $movie['themoviedb_id'],
                'title' => $movie['title'],
                'image' => "https://image.tmdb.org/t/p/w1280{$movie['image']}",
                'watched' => '0',
                'distributors' => [],
                'genres' => [],
                'added' => true,
            ];
        }, $movies->toArray());

        $this->post('movie-lists', [
            'title' => $title,
            'movies' => $movies->pluck('id')->toArray(),
        ])
            ->assertCreated()
            ->assertJson([
                'title' => $title,
                'movies' => $formattedMovies,
            ]);
    }
}
