<?php

namespace App\Client;

use GuzzleHttp\Client as Guzzle;

class TheMovieDbApiClient extends Guzzle
{
    public function __construct()
    {
        parent::__construct([
            'base_uri' => trim(config('themoviedb.api_url'), '/') . '/',
        ]);
    }

    /**
     * Wraps the Guzzle package's post method in order to be able to
     * automatically attach authorization headers
     *
     * @param string $endpoint
     * @param  mixed $args
     * @return array
     */
    public function get($endpoint, $args = [])
    {
        $args['api_key'] = config('themoviedb.api_key');

        $endpoint = sprintf(
            '%s?%s',
            $endpoint,
            http_build_query($args)
        );

        $response = $this::request('GET', $endpoint);

        return json_decode((string) $response->getBody(), true);
    }
}
