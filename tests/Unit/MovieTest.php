<?php

namespace Tests\Unit;

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
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => sprintf(
                    '%s has been inserted',
                    $movie['Title']
                )
            ]);
    }

    public function testAMovieCanBeDeleted()
    {
        $response = $this->get('search?keyword=Cannibal Holocaust');

        $movie = $response['results'][0];

        $this->post('/movies/create', [
            'imdb_id' => $movie['imdbID']
        ]);

        $this->post('/movies/destroy', [
            'imdb_id' => $movie['imdbID'],
        ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Success, movie has been deleted!',
            ]);
    }
}
