<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    protected $guarded = [];

    use HasFactory;

    protected $casts = [
        'themoviedb_id' => 'int',
        'watched' => 'boolean'
    ];

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'movie_genres');
    }

    public function distributors(): BelongsToMany
    {
        return $this->belongsToMany(Distributor::class, 'movie_distributors');
    }

    public function movieList(): BelongsToMany
    {
        return $this->belongsToMany(MovieList::class);
    }
}
