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
            'Title' => $this->title,
            'Image' => config('themoviedb.image_url') . $this->image,
            'Watched' => $this->watched,
            'Distributors' => $this->distributors()->pluck('title'),
            'Genres' => $this->genres()->pluck('title'),
        ];
    }
}
