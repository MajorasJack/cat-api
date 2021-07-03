<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieListResource;
use App\Models\ListType;
use App\Models\Movie;
use App\Models\MovieList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class MovieListController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(
            MovieListResource::collection(
                ListType::with('usersMovieLists', 'usersMovieLists.movies')
                    ->where('created_by', auth()->user()->id)
                    ->get()
            )
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $listType = ListType::firstOrCreate([
            'title' => $request->input('title'),
            'created_by' => auth()->user()->getAuthIdentifier(),
        ]);

        $movieList = MovieList::updateOrCreate([
            'list_type_id' => $listType->id,
            'created_by' => auth()->user()->getAuthIdentifier(),
        ]);

        if ($request->has('movies')) {
            foreach ($request->input('movies') as $movie) {
                $movieList->movies()->save(Movie::find($movie));
            }
        }

        return response()->json(
            new MovieListResource($listType->load('usersMovieLists', 'usersMovieLists.movies')),
            Response::HTTP_CREATED
        );
    }

    /**
     * @param MovieList $movieList
     * @return MovieListResource
     */
    public function show(MovieList $movieList)
    {
        return new MovieListResource($movieList->load('usersMovieLists', 'usersMovieLists.movies'));
    }

    /**
     * @param Request $request
     * @param MovieList $movieList
     * @return JsonResponse
     */
    public function update(Request $request, MovieList $movieList)
    {
        $movieList->update(
            $request->only([
                'list_type_id',
            ])
        );

        if ($request->has('movies')) {
            $movieList->movies()->save($request->get('movies'));
        }

        return response()->json(
            new MovieListResource($movieList->load('usersMovieLists', 'usersMovieLists.movies'))
        );
    }

    /**
     * @param Request $request
     * @param MovieList $movieList
     * @return Response
     */
    public function destroy(Request $request, MovieList $movieList)
    {
        $movieList->delete();

        return response()->noContent();
    }
}
