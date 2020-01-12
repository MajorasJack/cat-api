<?php

namespace App\Http\Controllers;

use App\Client\OmdbApiClient;
use App\Genre;
use App\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MovieController extends Controller
{
    /**
     * @var OmdbApiClient
     */
    public $client;

    /**
     * MovieController constructor.
     * @param OmdbApiClient $client
     */
    public function __construct(OmdbApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $movies = Movie::all();

        return response()->json([
            'movies' => $movies,
            'count' => $movies->count(),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        return response()->json([
            'movie' => Movie::findOrFail($request->get('id')),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $response = $this->client->get('', [
            'i' => $request->get('imdb_id'),
        ]);

        $movie = Movie::updateOrCreate([
            'imdb_id' => $response['imdbID'],
        ], [
            'title' => $response['Title'],
            'image' => $response['Poster'],
            'imdb_id' => $response['imdbID'],
        ]);

        foreach (explode(', ', $response['Genre']) as $item) {
            $genre = Genre::firstOrCreate([
                'title' => $item,
            ]);

            $movie->genres()->save($genre);
        }

        return response()->json($movie->toArray(),Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $movie = Movie::whereImdbId($request->get('imdb_id'))->first();

        if ($movie) {
            $movie->genres()->detach();

            $movie->delete();
        }

        return response()->noContent();
    }
}
