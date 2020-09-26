<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use WithFaker;

    public function testApiCanBeAccessedAndSendsBackValidData()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $this->get('search?keyword=The Collector')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'results' => [
                    [
                        'external_id',
                        'title',
                        'description',
                        'image',
                        'release_year',
                        'added',
                    ],
                ],
                'count',
            ]);
    }

    public function testCanSearchApiByMovieId()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $this->get('/search/565')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'movie' => [
                    'adult',
                    'backdrop_path',
                    'belongs_to_collection' => [
                        'id',
                        'name',
                        'poster_path',
                        'backdrop_path',
                    ],
                    'budget',
                    'genres' => [
                        [
                            'id',
                            'name',
                        ],
                    ],
                    'homepage',
                    'id',
                    'imdb_id',
                    'original_language',
                    'original_title',
                    'overview',
                    'popularity',
                    'poster_path',
                    'production_companies' => [
                        [
                            'id',
                            'logo_path',
                            'name',
                            'origin_country',
                        ],
                    ],
                    'production_countries' => [
                        [
                            'iso_3166_1',
                            'name',
                        ],
                    ],
                    'release_date',
                    'revenue',
                    'runtime',
                    'spoken_languages' => [
                        [
                            'iso_639_1',
                            'name',
                        ],
                    ],
                    'status',
                    'tagline',
                    'title',
                    'video',
                    'vote_average',
                    'vote_count',
                ],
            ]);
    }

    public function testIdSearchReturnsCorrectStatusWithIncorrectSearch()
    {
        $user = factory(User::class)->create();

        Passport::actingAs($user);

        $this->get('/search/' . $this->faker->word)
            ->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
