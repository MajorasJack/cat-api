<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
            'external_id' => $this->themoviedb_id,
            'title' => $this->title,
            'image' => config('themoviedb.image_url') . $this->image,
            'watched' => $this->watched,
            'distributors' => $this->distributors()->pluck('title'),
            'genres' => $this->genres()->pluck('title'),
        ];
    }
}
