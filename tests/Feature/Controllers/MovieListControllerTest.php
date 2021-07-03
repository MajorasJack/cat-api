<?php

namespace Tests\Feature\Controllers;

use App\Models\Movie;
use App\Models\MovieList;
use App\Models\User;
use App\Models\ListType;
use Laravel\Passport\Passport;
use Tests\TestCase;

class MovieListControllerTest extends TestCase
{
    public function testThatItCanGetAllMoviesListTypesForUser()
    {
        $user = User::factory()->create();

        $listType = ListType::factory()->create([
            'created_by' => $user->id,
        ]);

        $movieList = MovieList::factory()->create([
            'list_type_id' => $listType->id,
            'created_by' => $user->id,
        ]);

        $movies = Movie::factory()->count(5)->create();

        $movies->each(function (Movie $movie) use ($movieList) {
            $movie->movieList()->save($movieList);
        });

        Passport::actingAs($user);

        $this->get(route('movie-lists.index'))
            ->assertOk()
            ->assertJson([
                [
                    'title' => $listType->title,
                    'movies' => array_map(function ($movie) {
                        return [
                            'id' => $movie['id'],
                            'external_id' => $movie['themoviedb_id'],
                            'title' => $movie['title'],
                            'image' => "https://image.tmdb.org/t/p/w1280{$movie['image']}",
                            'watched' => $movie['watched'],
                            'distributors' => [],
                            'genres' => [],
                            'added' => true,
                        ];
                    }, $movies->toArray())
                ]
            ]);

    }

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

        $this->post('movie-lists', [
            'title' => $title,
            'movies' => $movies->pluck('id')->toArray(),
        ])
            ->assertCreated()
            ->assertJson([
                'title' => $title,
                'movies' => array_map(function ($movie) {
                    return [
                        'id' => $movie['id'],
                        'external_id' => $movie['themoviedb_id'],
                        'title' => $movie['title'],
                        'image' => "https://image.tmdb.org/t/p/w1280{$movie['image']}",
                        'watched' => $movie['watched'],
                        'distributors' => [],
                        'genres' => [],
                        'added' => true,
                    ];
                }, $movies->toArray()),
            ]);
    }
}
