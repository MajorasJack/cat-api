<?php

namespace Tests\Unit\Client;

use Tests\TestCase;
use App\Client\TheMovieDbApiClient;
use App\Client\TheMovieDbApiClientException;

class TheMovieDbApiClientTest extends TestCase
{
    public function testItThrowsTheMovieDbApiExceptionOnFailure()
    {
        $client = new TheMovieDbApiClient();

        $this->expectException(TheMovieDbApiClientException::class);

        $client->makeRequest($this->faker->word, $this->faker->word);
    }
}
