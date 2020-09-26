<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListType extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function movieList()
    {
        return $this->hasMany(MovieList::class);
    }

    /**
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}
