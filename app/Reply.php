<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favouritable, RecordsActivity;

    protected $fillable = ['user_id', 'body'];

    protected $with = ['user', 'favourites', 'thread'];

    protected $appends = ['favouritesCount', 'isFavourite'];
    
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
     * Thread relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Url to reply.
     *
     * @return string
     */
    public function path()
    {
        return $this->thread->path() . '#reply-' . $this->id;
    }

    /**
     * Shows was the thread published greater than 1 min ago.
     *
     * @return bool
     */
    public function wasJustPublished() : bool
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }
}
