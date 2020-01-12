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
                        'Title',
                        'Year',
                        'imdbID',
                        'Type',
                        'Poster',
                    ],
                ],
                'count',
            ]);
    }

    public function testCanSearchApiByImdbId()
    {
        $this->get('search/id?id=tt0844479')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'movie' => [
                    'Title',
                    'Year',
                    'Rated',
                    'Released',
                    'Runtime',
                    'Genre',
                    'Director',
                    'Writer',
                    'Actors',
                    'Plot',
                    'Language',
                    'Country',
                    'Awards',
                    'Poster',
                    'Ratings' => [
                        [
                            'Source',
                            'Value',
                        ],
                    ],
                    'Metascore',
                    'imdbRating',
                    'imdbVotes',
                    'imdbID',
                    'Type',
                    'DVD',
                    'BoxOffice',
                    'Production',
                    'Website',
                    'Response',
                ],
            ]);
    }

    public function testIdSearchReturnsCorrectStatusWithIncorrectSearch()
    {
        $this->get('search/id?id=t' . $this->faker->numberBetween(1000, 9999))
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => 'Incorrect IMDb ID.'
            ]);
    }
}
