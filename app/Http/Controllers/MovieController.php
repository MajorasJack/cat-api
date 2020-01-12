<?php

namespace App\Http\Controllers;

use App\Client\TheMovieDbApiClient;
use App\Genre;
use App\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MovieController extends Controller
{
    /**
     * @var TheMovieDbApiClient
     */
    public $client;

    /**
     * MovieController constructor.
     * @param TheMovieDbApiClient $client
     */
    public function __construct(TheMovieDbApiClient $client)
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
        $response = $this->client->get('movie/' . $request->get('themoviedb_id'), []);

        $movie = Movie::updateOrCreate([
            'themoviedb_id' => $response['id'],
        ], [
            'title' => $response['original_title'],
            'image' => $response['poster_path'],
            'themoviedb_id' => $response['id'],
        ]);

        foreach ($response['genres'] as $item) {
            $genre = Genre::firstOrCreate([
                'title' => $item['name'],
                'themoviedb_id' => $item['id'],
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
        $movie = Movie::whereThemoviedbId($request->get('themoviedb_id'))->first();

        if ($movie) {
            $movie->genres()->detach();

            $movie->delete();
        }

        return response()->noContent();
    }
}
