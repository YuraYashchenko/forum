<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['user_id', 'body'];
    /**
     * User that leave a reply.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favouritable');
    }

    /**
     * Favourite a reply.
     *
     * @param int $userId
     */
    public function favourite(int $userId)
    {
        $attributes = ['user_id' => $userId];

        if (! $this->favourites()->where($attributes)->exists())
        {
            $this->favourites()->create([
                'user_id' => $userId
            ]);
        }
    }
}
