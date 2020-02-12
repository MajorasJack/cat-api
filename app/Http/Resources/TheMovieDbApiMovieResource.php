<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TheMovieDbApiMovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'external_id' => $this->resource['id'],
            'title' => $this->resource['original_title'],
            'description' => $this->resource['overview'],
            'image' => config('themoviedb.image_url') . $this->resource['poster_path'],
            'release_year' => Carbon::parse($this->resource['release_date'])->format('Y'),
            'added' => $this->resource['added'],
        ];
    }
}
