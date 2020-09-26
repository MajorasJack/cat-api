<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Tests\TestCase;

class MovieListTest extends TestCase
{
    use WithFaker;

    public function testItCanCreateAMovieList()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $this->post('movie_lists', [
            'title' => $this->faker->word,
        ])
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'title',
                'movies' => [
                    'external_id',
                    'title',
                    'image',
                    'watched',
                    'distributors',
                    'genres',
                    'added',
                ],
            ]);
    }
}
