<?php

namespace App\Http\Controllers;

use App\Client\OmdbApiClient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MovieSearchController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $response = (new OmdbApiClient())->get('', [
            's' => $request->get('keyword'),
        ]);

        return response()->json([
            'results' => $response['Search'],
            'count' => $response['totalResults'],
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        $response = (new OmdbApiClient())->get('', [
            'i' => $request->get('id'),
        ]);

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
