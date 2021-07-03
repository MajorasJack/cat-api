<?php

namespace App\Http\Resources;

use App\Models\MovieList;
use Illuminate\Http\Resources\Json\JsonResource;

class EanProductResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->getName(),
            'ean' => $this->getEan(),
        ];
    }
}
