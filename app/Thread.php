<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
      /**
     * Generate url for thread.
     *
     * @return string
     */
    public function path()
    {
        return '/threads/' . $this->id;
    }

    /**
     * Replies associated for thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * A thread related to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
}
