<?php

namespace App\Http\Controllers;

use App\Client\OmdbApiClient;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
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
}
