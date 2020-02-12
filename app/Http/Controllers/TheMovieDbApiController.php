<?php

namespace App\Http\Controllers;

use App\Movie;
use App\Client\TheMovieDbApiClient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Resources\TheMovieDbApiMovieResource;

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
        $exclude = Movie::pluck('themoviedb_id');

        $response = $this->client->get('search/movie', [
            'query' => $request->get('keyword'),
        ]);

        $results = array_map(function ($result) use ($exclude) {
            $result['added'] = $exclude->contains($result['id']);
            return $result;
        }, $response['results']);

        return response()->json([
            'results' => TheMovieDbApiMovieResource::collection($results),
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
