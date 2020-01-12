<?php

namespace App\Http\Controllers;

use App\Client\OmdbApiClient;
use App\Genre;
use App\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    /**
     * @var OmdbApiClient
     */
    public $client;

    /**
     * MovieController constructor.
     */
    public function __construct()
    {
        $this->client = new OmdbApiClient();
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

        return response()->json([
            'message' => sprintf(
                '%s has been inserted',
                $movie->title
           ),
        ]);
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

        return response()->json([
            'message' => 'Success, movie has been deleted!',
        ]);
    }
}
