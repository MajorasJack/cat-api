<?php

namespace Tests\Feature\Controllers;

use App\Models\Distributor;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Tests\TestCase;

class MovieControllerTest extends TestCase
{
    public function testThatItReturnsAllMoviesAsExpected()
    {
        Movie::factory()->count(10)->create();

        Passport::actingAs(User::factory()->create());

        $this->get('movies')
            ->assertOk();
    }

    public function testThatItReturnsSingleMovieAsExpected()
    {
        $movie = Movie::factory()->create();

        Passport::actingAs(User::factory()->create());

        $this->get("movies/{$movie->id}")
            ->assertOk()
            ->assertJson([
                'id' => $movie->id,
                'external_id' => $movie->themoviedb_id,
                'title' => $movie->title,
                'image' => config('themoviedb.image_url') . $movie->image,
                'watched' => $movie->watched,
                'distributors' => [],
                'genres' => [],
                'added' => true,
            ]);
    }

    public function testThatItReturnsSingleMovieAsExpectedWithDistributorsAndGenres()
    {
        $movie = Movie::factory()->create();

        $movie->distributors()->attach(Distributor::factory()->create());

        $movie->genres()->save(Genre::factory()->create());

        Passport::actingAs(User::factory()->create());

        $this->get("movies/{$movie->id}")
            ->assertOk()
            ->assertJson([
                'id' => $movie->id,
                'external_id' => $movie->themoviedb_id,
                'title' => $movie->title,
                'image' => config('themoviedb.image_url') . $movie->image,
                'watched' => $movie->watched,
                'distributors' => $movie->distributors()->pluck('title')->toArray(),
                'genres' => $movie->genres()->pluck('title')->toArray(),
                'added' => true,
            ]);
    }

    public function testAMovieCanBeInserted()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->get('search?keyword=Cannibal Holocaust');

        $movie = $response['results'][0];

        $this->post('/movies', [
            'title' => $movie['title'],
            'image' => str_replace(config('themoviedb.image_url'), '', $movie['image']),
            'themoviedb_id' => $movie['external_id'],
        ])
            ->assertCreated();
    }

    public function testAMovieWithDistributorsCanBeInserted()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->get('search?keyword=Cannibal Holocaust');

        $movie = $response['results'][0];

        $this->post('/movies', [
            'title' => $movie['title'],
            'image' => str_replace(config('themoviedb.image_url'), '', $movie['image']),
            'themoviedb_id' => $movie['external_id'],
            'distributor' => Distributor::factory()->create(),
        ])
            ->assertCreated();
    }

    public function testAMovieCanBeDeleted()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $movie = Movie::factory()->create();

        $this->delete("movies/{$movie->id}")
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testAMovieCanBeUpdated()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $movie = Movie::factory()->create([
            'watched' => false,
        ]);

        $this->put("/movies/{$movie->id}", [
            'watched' => true,
        ]);

        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
            'watched' => true,
        ]);
    }
}
