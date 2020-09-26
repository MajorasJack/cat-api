<?php

namespace Tests\Unit;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use DatabaseTransactions;

    public function testAMovieCanBeInserted()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $response = $this->get('search?keyword=Cannibal Holocaust');

        $movie = $response['results'][0];

        $this->post('/movies', [
            'title' => $movie['title'],
            'image' => str_replace(config('themoviedb.image_url'), '', $movie['image']),
            'themoviedb_id' => $movie['external_id'],
        ])
            ->assertStatus(Response::HTTP_CREATED);
    }

    public function testAMovieCanBeDeleted()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $movie = factory(Movie::class)->create();

        $this->delete('/movies/' . $movie->id)
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testAMovieCanBeUpdated()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $movie = factory(Movie::class)->create([
            'watched' => false,
        ]);

        $this->put('/movies/' . $movie->id, [
            'watched' => true,
        ]);

        $this->assertDatabaseHas('movies', [
            'id' => $movie->id,
            'watched' => true,
        ]);
    }
}
