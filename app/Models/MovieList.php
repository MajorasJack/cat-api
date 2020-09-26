<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MovieList extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function listType()
    {
        return $this->belongsTo(ListType::class);
    }

    /**
     * @return BelongsTo
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }
}
