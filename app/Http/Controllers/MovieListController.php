<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieListResource;
use App\Models\ListType;
use App\Models\MovieList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
                ListType::whereCreatedBy(auth()->user()->getAuthIdentifier())
                    ->with('movieList', 'movieList.movie')
                    ->get()
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function store(Request $request)
    {
        $listType = ListType::firstOrCreate([
            'title' => $request->input('title'),
            'created_by' => auth()->user()->getAuthIdentifier(),
        ]);

        foreach ($request->input('movies') as $movie) {
            MovieList::updateOrCreate([
                'list_type_id' => $listType->id,
                'created_by' => auth()->user()->getAuthIdentifier(),
                'movie_id' => $movie,
            ]);
        }

        return response()->json(
            new MovieListResource($listType->load('movieList', 'movieList.movie')),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param MovieList $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
