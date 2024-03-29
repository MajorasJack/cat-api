<?php

namespace App\Http\Controllers;

use App\Client\TheMovieDbApiClient;
use App\Models\Genre;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Exception;
use App\Client\TheMovieDbApiClientException;

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
        return response()->json(MovieResource::collection(Movie::all()));
    }

    /**
     * @param Movie $movie
     * @return JsonResponse
     */
    public function show(Movie $movie)
    {
        return response()->json(new MovieResource($movie));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws TheMovieDbApiClientException
     */
    public function store(Request $request)
    {
        $response = $this->client->makeRequest('GET', "movie/{$request->get('themoviedb_id')}");

        $movie = Movie::updateOrCreate([
            'themoviedb_id' => $response['id'],
        ], [
            'title' => $response['original_title'],
            'image' => $response['poster_path'],
            'themoviedb_id' => $response['id'],
        ]);

        if ($request->has('distributor')) {
            $movie->distributors()->attach($request->get('distributor'));
        }

        foreach ($response['genres'] as $genre) {
            $movie->genres()->save(
                Genre::firstOrCreate([
                    'title' => $genre['name'],
                    'themoviedb_id' => $genre['id'],
                ])
            );
        }

        return response()->json(new MovieResource($movie), Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param Movie $movie
     *
     * @return JsonResponse
     */
    public function update(Request $request, Movie $movie)
    {
        $movie->update(
            $request->only([
                'title',
                'image',
                'themoviedb_id',
                'watched',
            ])
        );

        return response()->json(new MovieResource($movie), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param Movie $movie
     *
     * @return Response
     * @throws Exception
     */
    public function destroy(Request $request, Movie $movie): Response
    {
        $movie->genres()->detach();
        $movie->distributors()->detach();

        $movie->delete();

        return response()->noContent();
    }
}
