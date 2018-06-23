<?php


namespace App;


trait Favouritable
{
    /**
     * Boot a model.
     */
    protected static function bootFavouritable()
    {
        self::deleting(function ($model) {
            $model->favourites->each->delete();
        });
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

    /**
     * @param int $userId
     */
    public function unfavourite(int $userId)
    {
        $attributes = ['user_id' => $userId];

        $this->favourites()->where($attributes)->get()->each->delete();
    }

    /**
     * Is the reply favourited by current user.
     *
     * @return bool
     */
    public function isFavourite() : bool
    {
        return !! $this->favourites->where('user_id', auth()->id())->count();
    }

    public function getIsFavouriteAttribute()
    {
        return $this->isFavourite();
    }

    /**
     * Mutator for favourites counts field.
     *
     * @return mixed
     */
    public function getFavouritesCountAttribute()
    {
        return $this->favourites->count();
    }
}