<?php

namespace App\Http\Controllers;

use App\Client\TheMovieDbApiClient;
use App\Genre;
use App\Http\Resources\MovieResource;
use App\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return MovieResource::collection(Movie::all());
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function show(Request $request)
    {
        return response()->json([
            'movie' => MovieResource::collection(Movie::findOrFail($request->get('id'))),
        ]);
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function store(Request $request)
    {
        $response = $this->client->get('movie/' . $request->get('themoviedb_id'));

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

        return MovieResource::collection($movie);
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
