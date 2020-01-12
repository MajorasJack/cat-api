<?php

namespace Tests\Unit;

use Illuminate\Http\Response;
use Tests\TestCase;

class OmdbTest extends TestCase
{
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
                    ]
                ],
                'count'
            ]);
    }
}
