<?php

namespace App\Http\Controllers;

use App\Client\OmdbApiClient;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OmdbController extends Controller
{
    public function search(Request $request)
    {
        $response = (new OmdbApiClient())->get('', [
            's' => $request->get('keyword'),
        ]);

        return response()->json([
            'results' => $response['Search'],
            'count' => $response['totalResults']
        ]);
    }
}
