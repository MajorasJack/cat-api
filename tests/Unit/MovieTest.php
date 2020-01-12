<?php

namespace Tests\Unit;

use App\Movie;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use DatabaseTransactions;

    public function testAMovieCanBeInserted()
    {
        $response = $this->get('search?keyword=Cannibal Holocaust');

        $movie = $response['results'][0];

        $this->post('/movies/create', [
            'imdb_id' => $movie['imdbID']
        ])
            ->assertStatus(Response::HTTP_CREATED);
    }

    public function testAMovieCanBeDeleted()
    {
        $movie = factory(Movie::class)->make();

        $this->delete('/movies/destroy', [
                'imdb_id' => $movie->imdb_id,
            ])
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
