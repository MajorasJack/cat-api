<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $guarded = [];

    use HasFactory;

    protected $casts = [
        'themoviedb_id' => 'int',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genres');
    }

    public function distributors()
    {
        return $this->belongsToMany(Distributor::class, 'movie_distributors');
    }
}
