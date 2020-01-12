<?php

namespace App\Http\Controllers;

use App\Client\TheMovieDbApiClient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TheMovieDbApiController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $response = (new TheMovieDbApiClient())->get('search/movie', [
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
        $response = (new TheMovieDbApiClient())->get('movie/' . $id, []);

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
