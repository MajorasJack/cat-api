<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use WithFaker;

    public function testApiCanBeAccessedAndSendsBackValidData()
    {
        $this->get('search?keyword=The Collector')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'results' => [
                    [
                        'popularity',
                        'id',
                        'video',
                        'vote_count',
                        'vote_average',
                        'title',
                        'release_date',
                        'original_language',
                        'original_title',
                        'genre_ids' => [],
                        'backdrop_path',
                        'adult',
                        'overview',
                        'poster_path',
                    ],
                ],
                'count',
            ]);
    }

    public function testCanSearchApiByMovieId()
    {
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
                ]
            ]);
    }

    public function testIdSearchReturnsCorrectStatusWithIncorrectSearch()
    {
        $this->get('/search/' . $this->faker->word)
            ->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
