<?php

namespace App\Client;

use GuzzleHttp\Client as Guzzle;

class OmdbApiClient extends Guzzle
{
    public function __construct()
    {
        parent::__construct([
            'base_uri' => trim(config('omdb.api_url'), '/') . '/',
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
    public function get($endpoint, $args)
    {
        $args['apikey'] = config('omdb.api_key');

        $endpoint = sprintf(
            '%s?%s',
            $endpoint,
            http_build_query($args)
        );

        $response = $this::request('GET', $endpoint, $args);

        return json_decode((string) $response->getBody(), true);
    }
}
