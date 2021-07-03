<?php

namespace App\Http\Resources;

use App\Models\MovieList;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'movies' => $this->movieList->movies ?
                MovieResource::collection($this->movieList->movies)
                : [],
        ];
    }
}
