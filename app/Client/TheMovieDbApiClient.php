<?php

namespace App\Client;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class TheMovieDbApiClient extends Guzzle
{
    public function __construct()
    {
        parent::__construct([
            'base_uri' => trim(config('themoviedb.api_url'), '/') . '/',
        ]);
    }


    /**
     * @param string $method
     * @param string $endpoint
     * @param array $options
     * @return ResponseInterface|array
     * @throws TheMovieDbApiClientException
     */
    public function makeRequest(string $method, string $endpoint, array $options = [])
    {
        $options['api_key'] = config('themoviedb.api_key');

        $endpoint = sprintf(
            '%s?%s',
            $endpoint,
            http_build_query($options)
        );

        try {
            $response = $this->request($method, $endpoint);
        } catch (GuzzleException $exception) {
            throw new TheMovieDbApiClientException($exception);
        }

        return cache()->remember(
            $endpoint . json_encode($options),
            86400,
            function () use ($response) {
                return json_decode((string) $response->getBody(), true);
            }
        );
    }
}
