<?php

namespace App\Http\Controllers;

use App\Client\TheMovieDbApiClient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TheMovieDbApiController extends Controller
{
    /**
     * @var TheMovieDbApiClient
     */
    public $client;

    /**
     * TheMovieDbApiController constructor.
     * @param TheMovieDbApiClient $client
     */
    public function __construct(TheMovieDbApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $response = $this->client->get('search/movie', [
            'query' => $request->get('keyword'),
        ]);

        return response()->json([
            'results' => $response['results'],
            'count' => $response['total_results'],
            'pages' => $response['total_pages'],
            'page' => $response['page'],
        ]);
    }

    /**
     * @param integer $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $response = $this->client->get('movie/' . $id);

        if (isset($response['Error'])) {
            return response()->json([
                'error' => $response['Error'],
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'movie' => $response,
        ]);
    }
}
