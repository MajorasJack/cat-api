<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListType extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $guarded = [];

    /**
     * @return HasOne
     */
    public function movieList(): HasOne
    {
        return $this->hasOne(MovieList::class);
    }

    /**
     * @return HasOne
     */
    public function usersMovieLists(): HasOne
    {
        return $this->hasOne(MovieList::class)->where('created_by', auth()->user()->id);
    }

    /**
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}
