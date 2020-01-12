<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    public $guarded = [];

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_distributors');
    }
}
